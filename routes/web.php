<?php

use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HonorariosController;

// Route::get('/', function () {
//     return view('welcome');
// });
//HONORARIOS
Route::get('/', [HonorariosController::class,'indexForm'])->name('honorario.indexForm');
Route::get('/create', [HonorariosController::class,'create'])->name('honorario.create');
Route::post('/preview', [HonorariosController::class,'preview'])->name('honorario.preview');
Route::post('/honorario', [HonorariosController::class,'store'])->name('honorario.store');

//USER FUNCIONARIOS
Route::get('/funcionario/create', [FuncionarioController::class,'create'])->name('funcionario.create');
Route::post('/funcionario', [FuncionarioController::class,'store'])->name('funcionario.store');

//PDF VIEW
use App\Http\Controllers\PdfController;
Route::get('ver-pdf/{id}', [PdfController::class, 'ver'])->name('ver.pdf');



