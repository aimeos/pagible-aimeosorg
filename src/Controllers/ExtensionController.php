<?php

namespace Aimeos\Cms\Controllers;

use Aimeos\Cms\ExtensionBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExtensionController extends Controller
{
    public function download(Request $request, ExtensionBuilder $builder): BinaryFileResponse
    {
        $type = (string) $request->input('type');
        $separator = str_starts_with($type, 'typo3-') ? 'underscore ("_")' : 'dash ("-")';
        $data = $request->validate([
            'name' => ['required', 'string', 'max:64', 'regex:'.ExtensionBuilder::namePattern($type)],
            'type' => ['required', 'string', Rule::in(array_keys(ExtensionBuilder::types()))],
        ], [
            'name.regex' => sprintf(
                'Only a-z, 0-9 and %s characters are allowed, and separators cannot be at the beginning or end.',
                $separator,
            ),
            'type.in' => 'The selected package type is not available.',
        ]);

        $archive = $builder->create($data['name'], $data['type']);

        return response()->download($archive, $data['name'].'.zip', [
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ])->deleteFileAfterSend(true);
    }
}
