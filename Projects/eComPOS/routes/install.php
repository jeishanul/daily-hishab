<?php

use App\Http\Controllers\InstallController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('install/database', [InstallController::class, 'database'])->name('LaravelInstaller::database');
Route::post('install/environment/save', [InstallController::class, 'configSetup'])->name('LaravelInstaller::environmentSaveWizard');
Route::post('install/environment/saveClassic', [InstallController::class, 'saveClassic'])->name('LaravelInstaller::environmentSaveClassic');

