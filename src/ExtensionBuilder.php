<?php

namespace Aimeos\Cms;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use ZipArchive;

final class ExtensionBuilder
{
    /** @var array<string, string> */
    private const TYPES = [
        'aimeos-2026' => 'Aimeos 2026.x extension',
        'aimeos-2025' => 'Aimeos 2025.x extension',
        'aimeos-2024' => 'Aimeos 2024.x extension',
        'aimeos-2023' => 'Aimeos 2023.x extension',
        'aimeos-2022' => 'Aimeos 2022.x extension',
        'laravel-2026' => 'Laravel theme 2026.x extension',
        'laravel-2025' => 'Laravel theme 2025.x extension',
        'laravel-2024' => 'Laravel theme 2024.x extension',
        'laravel-2023' => 'Laravel theme 2023.x extension',
        'laravel-2022' => 'Laravel theme 2022.x extension',
        'typo3-2026' => 'TYPO3 2026.x extension',
        'typo3-2025' => 'TYPO3 2025.x extension',
        'typo3-2024' => 'TYPO3 2024.x extension',
        'typo3-2023' => 'TYPO3 2023.x extension',
        'typo3-2022' => 'TYPO3 2022.x extension',
    ];

    public function __construct(
        private readonly string $source = __DIR__.'/../resources/extensions',
    ) {}

    /**
     * @return array<string, string>
     */
    public static function types(): array
    {
        return self::TYPES;
    }

    public static function namePattern(string $type): string
    {
        return str_starts_with($type, 'typo3-')
            ? '/\A[a-z0-9]+(?:_[a-z0-9]+)*\z/'
            : '/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/';
    }

    /**
     * Creates an Aimeos extension ZIP and returns its temporary path.
     */
    public function create(string $name, string $type): string
    {
        if (! isset(self::TYPES[$type])) {
            throw new RuntimeException(sprintf('Unsupported extension type "%s".', $type));
        }

        if (preg_match(self::namePattern($type), $name) !== 1) {
            throw new RuntimeException('Invalid extension name.');
        }

        $template = $this->source.'/'.$type;

        if (! is_dir($template)) {
            throw new RuntimeException(sprintf('Extension template "%s" is not available.', $type));
        }

        $directory = sys_get_temp_dir().'/aimeos-extension-'.bin2hex(random_bytes(16));
        $archive = $directory.'.zip';

        if (! mkdir($directory, 0700, true)) {
            throw new RuntimeException('Unable to create the extension workspace.');
        }

        try {
            if (str_starts_with($type, 'typo3-')) {
                $year = substr($type, 6);
                $this->copy($template, $directory, $name);
                $this->copy(
                    $this->source.'/aimeos-'.$year,
                    $directory.'/Resources/Private/Extensions/'.$name,
                    $name,
                );
            } else {
                $this->copy($template, $directory, $name);
            }

            $this->zip($archive, $directory);
        } catch (\Throwable $e) {
            if (is_file($archive)) {
                @unlink($archive);
            }

            throw $e;
        } finally {
            $this->remove($directory);
        }

        return $archive;
    }

    private function copy(string $source, string $destination, string $name): void
    {
        if (! is_dir($source)) {
            throw new RuntimeException(sprintf('Extension template directory "%s" is not available.', basename($source)));
        }

        if (! is_dir($destination) && ! mkdir($destination, 0700, true)) {
            throw new RuntimeException('Unable to create an extension directory.');
        }

        $package = preg_replace('/[^A-Za-z]/', '', $name) ?? '';
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        );

        foreach ($iterator as $item) {
            $target = $destination.'/'.$iterator->getSubPathName();

            if ($item->isDir()) {
                if (! is_dir($target) && ! mkdir($target, 0700, true)) {
                    throw new RuntimeException('Unable to create an extension directory.');
                }

                continue;
            }

            $content = file_get_contents($item->getPathname());

            if ($content === false) {
                throw new RuntimeException('Unable to read an extension template.');
            }

            $content = str_replace(['<extname>', '<EXTNAME>'], [$name, $package], $content);

            if (file_put_contents($target, $content) === false) {
                throw new RuntimeException('Unable to write an extension file.');
            }
        }

        foreach (['client/html/themes/default', 'themes/client/html/default'] as $path) {
            $default = $destination.'/'.$path;

            if (is_dir($default) && ! rename($default, dirname($default).'/'.$name)) {
                throw new RuntimeException('Unable to rename the extension theme directory.');
            }
        }
    }

    private function zip(string $archive, string $directory): void
    {
        $zip = new ZipArchive;

        if ($zip->open($archive, ZipArchive::CREATE | ZipArchive::EXCL) !== true) {
            throw new RuntimeException('Unable to create the extension archive.');
        }

        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST,
            );

            foreach ($iterator as $item) {
                $path = $iterator->getSubPathName();
                $added = $item->isDir()
                    ? $zip->addEmptyDir($path)
                    : $zip->addFile($item->getPathname(), $path);

                if (! $added) {
                    throw new RuntimeException('Unable to add a file to the extension archive.');
                }
            }
        } finally {
            if (! $zip->close()) {
                throw new RuntimeException('Unable to finish the extension archive.');
            }
        }
    }

    private function remove(string $directory): void
    {
        if (! is_dir($directory)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($iterator as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }

        @rmdir($directory);
    }
}
