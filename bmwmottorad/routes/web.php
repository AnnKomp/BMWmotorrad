<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\RegisterSuiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AccessoireController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PDFController;


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


Route::get("/options",[OptionController::class, "optionSelection" ]);
Route::get("/option",[OptionController::class, "info" ]);
Route::post("/options/save", [ OptionController::class, 'save']);

Route::get("/accessoires",[AccessoireController::class, "store" ]);
Route::get("/accessoire",[AccessoireController::class, "info" ]);


Route::post('download-pdf', [PDFController::class, 'generatePdf']);

Route::get("/motos",[MotoController::class, "index" ]);
Route::get("/moto",[MotoController::class, "detail" ]);
Route::get("/motos-filtered",[MotoController::class, "filter" ]);
Route::get("/moto/color",[MotoController::class, "color" ]);
Route::get("/moto/pack",[MotoController::class, "pack" ]);
Route::get("/pack",[PackController::class, "info" ]);




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    //Controller for the second part of the account creation
    Route::get('registersuite', [RegisterSuiteController::class, 'create']);
    Route::post('registersuite', [RegisterSuiteController::class, 'store'])->name('registersuite');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateadress'])->name('adress.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
