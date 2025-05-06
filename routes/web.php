<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\appiController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[appiController::class, "index"] )->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/procesar-imagen',[appiController::class, "procesarImagen"] )->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/formulario", [appiController::class, "index"])->name("formulario.index");
Route::post("/formulario", [appiController::class, "store"])->name("formulario.store");

require __DIR__.'/auth.php';
