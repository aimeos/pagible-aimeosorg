<?php

use Aimeos\Cms\Controllers\ExtensionController;
use Aimeos\Cms\Http\Middleware\Origin;
use Illuminate\Support\Facades\Route;

$options = config('cms.multidomain') ? ['domain' => '{domain}'] : [];
$options['middleware'] = Origin::class;

Route::group($options, function () {
    Route::post('cmsapi/extension-builder', [ExtensionController::class, 'download'])
        ->middleware(['web', 'throttle:aimeos-extension-builder'])
        ->name('aimeos.api.extension-builder');
});
