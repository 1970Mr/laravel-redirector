<?php

use App\Http\Controllers\Redirector\RedirectController;
use Illuminate\Support\Facades\Route;

Route::resource('redirects', RedirectController::class)
    ->names('redirects')
    ->except(['show'])
    ->middleware(['web']);
