<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 */


namespace Aimeos\<EXTNAME>;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;


class ExtensionServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	public function boot()
	{
		$this->loadViewsFrom( __DIR__ . DIRECTORY_SEPARATOR . 'views', '<extname>' );

		if( file_exists( $basepath = base_path( 'ext' ) ) )
		{
			foreach( new \DirectoryIterator( $basepath ) as $entry )
			{
				if( $entry->isDir() && !$entry->isDot() && file_exists( $entry->getPathName() . '/themes/client/html' ) ) {
					$this->publishes( [$entry->getPathName() . '/themes/client/html' => public_path( 'vendor/shop/themes' )], 'public' );
				}
			}
		}

		$class = '\Composer\InstalledVersions';

		if( class_exists( $class ) && method_exists( $class, 'getInstalledPackagesByType' ) )
		{
			$extdir = base_path( 'ext' );
			$packages = \Composer\InstalledVersions::getInstalledPackagesByType( 'aimeos-extension' );

			foreach( $packages as $package )
			{
				$path = realpath( \Composer\InstalledVersions::getInstallPath( $package ) );

				if( strncmp( $path, $extdir, strlen( $extdir ) ) && file_exists( $path . '/themes/client/html' ) ) {
					$this->publishes( [$path . '/themes/client/html' => public_path( 'vendor/shop/themes' )], 'public' );
				}
			}
		}
	}
}