<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotoController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get("/options",[OptionController::class, "store" ]);
Route::get("/option",[OptionController::class, "info" ]);
Route::post("/options/save", [ OptionController::class, 'save']);

Route::get("/accessoires",[AccessoireController::class, "store" ]);
Route::get("/accessoire",[AccessoireController::class, "info" ]);

Route::get("/pack",[PackController::class, "info" ]);
Route::get("/packs",[PackController::class, "store" ]);



Route::get("/motos",[MotoController::class, "index" ]);
Route::get("/moto",[MotoController::class, "detail" ]);
Route::get("/motos-filtered",[MotoController::class, "filter" ]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
