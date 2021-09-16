<?php

use App\Http\Controllers\MeterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MeterController::class, 'createAGraph']);
Route::get('/graph-display', [MeterController::class, 'graphDisplay'])->name('graph.display');
