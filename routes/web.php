<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HandleController;

Route::get('/', [HandleController::class, 'test']);
