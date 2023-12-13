<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotoController;
use App\Http\Controllers\RegisterSuiteController;
use App\Http\Controllers\RegisterFinishedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AccessoireController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\EssaiController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\GammeController;
use App\Http\Controllers\CaracteristiqueController;

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
})->name('startPage');


//Route::post("/options",[OptionController::class, "optionSelection" ]);
Route::get("/option",[OptionController::class, "info" ]);

//inutile?
//Route::post("/options/save", [ OptionController::class, 'save']);

//Route::post("/accessoires",[AccessoireController::class, "store" ]);
Route::get("/accessoire",[AccessoireController::class, "info" ]);



Route::get("/motos",[MotoController::class, "index" ]);
Route::get("/moto",[MotoController::class, "detail" ]);
Route::get("/motos-filtered",[MotoController::class, "filter" ]);
Route::get("/moto/color",[MotoController::class, "color" ]);
//Route::get("/moto/pack",[MotoController::class, "pack" ]);
Route::get("/pack",[PackController::class, "info" ]);

Route::get("/moto/essai",[EssaiController::class, "create"]);
Route::post("/moto/essai", [EssaiController::class, "store"])->name('essaipost');
Route::get("/moto/essai/confirmation", [EssaiController::class, "confirm"]);

///////////////////////////  EQUIPEMENT  /////////////////////////////////////
Route::get("/equipements",[EquipementController::class, "index" ]);
Route::post('/equipements', [EquipementController::class, 'index'])->name('equipements.index');

Route::get("/equipement", [EquipementController::class, "detail"]);

Route::post('/fetch-equipment-photos', [EquipementController::class, 'fetchEquipmentPhotos'])
    ->name('fetch-equipment-photos');

Route::get('/equipement-stock/{idequipement}/{idcoloris}/{idtaille}', [EquipementController::class, 'getEquipementStock']);

Route::get('/equipement-photos/{idequipement}/{idcoloris}', [EquipementController::class, 'getEquipementPhotos'])->name('equipement.get-photos');

////////////////////////////    PANIER   /////////////////////////////////////////

/*
Route::get('/panier', [PanierController::class, "info"])->name('panier');
*/
Route::get('/panier', [PanierController::class, "index"])->name('panier');
ROute::post('/panier/add-to-cart/{id}', [PanierController::class,'addToCart'])->name('panier.add-to-cart');
Route::delete('/panier/remove-item/{id}/{index}', [PanierController::class, 'removeItem'])->name('panier.remove-item');
Route::post('/panier/increment/{id}/{index}', [PanierController::class,'incrementQuantity'])->name('panier.increment');
Route::post('/panier/decrement/{id}/{index}', [PanierController::class,'decrementQuantity'])->name('panier.decrement');

///////////////////////////////////////////////////////////////////////////////

Route::post("/moto/config",[MotoController::class, "config" ]);


Route::get('/dashboard', function () {
    if(auth()->user()->iscomplete == false){
        return redirect('registersuite');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --------------------------- Google authentification Routes ----------------------------------------------------

Route::get('/login/google', [AuthenticatedSessionController::class, "redirectToGoogle"]);
Route::get('/login/google/callback', [AuthenticatedSessionController::class, "handleGoogleCallback"]);
// ---------------------------------------------------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    //Controller for the second part of the account creation
    Route::get('registersuite', [RegisterSuiteController::class, 'create']);
    Route::post('registersuite', [RegisterSuiteController::class, 'store'])->name('registersuite');
    //Controller for the redirection page after creating a new account
    Route::get('registerfinished', [RegisterFinishedController::class, 'create'])->name('registerfinished');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/commands', [ProfileController::class, 'commands'])->name('profile.commands');
    Route::get('/profile/commands/detail', [ProfileController::class, 'command_detail'])->name('profile.commands.detail');
    Route::delete('/annuler-commande/{id_commande}/{id_equipement}/{id_taille}/{id_coloris}', [ProfileController::class, 'annulerCommande'])->name('annuler_commande');
    Route::post('/profile', [ProfileController::class, 'updateadress'])->name('adress.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/login/phoneverification', [PhoneVerificationController::class, 'create'])->name('phoneverification');
    Route::post('/login/phoneverification', [PhoneVerificationController::class, 'store'])->name('phoneverification');
    Route::get('/panier/commandestripe', [CommandeController::class, 'createstripe']);
    Route::post('/panier/commandestripe', [CommandeController::class, 'paystripe'])->name('paymentstripe');
    Route::get('/panier/commande/success', [CommandeController::class, 'success'])->name('commandesuccess');
    Route::get('/panier/commandecb', [CommandeController::class, 'createcb']);
    Route::post('/panier/commandecb', [CommandeController::class, 'paycb'])->name('paymentcb');
});

require __DIR__.'/auth.php';


///////////////////////////// CONFIG MOTO //////////////////////////////////
///choix packs
Route::get('/moto/pack',  [MotoController::class, 'showPacksForm']);
Route::post('/moto/pack', [PackController::class,'processPacksForm'])->name('processPacks');

///choix options
Route::get('/options',  [OptionController::class, 'showOptionsForm'])->name('options');
Route::post('/options', [OptionController::class,'processOptionsForm'])->name('processOptions');

///choix accessoires
Route::get('/accessoires',  [AccessoireController::class, 'showAccessoiresForm']);
Route::post('/accessoires', [AccessoireController::class,'processAccessoiresForm'])->name('processAccessoires');

///choix couleurs
Route::get('/colors', [MotoController::class,'showColorsForm']);
Route::post('/colors', [ColorController::class,'processColorsForm'])->name('processColors');

///fin de config
Route::get('/moto-config',  [MotoController::class, 'showMotoConfig']);

Route::post('/download-pdf', [MotoController::class, 'downloadPDF'])->name('moto-download-pdf');
Route::post('download-pdf', [PDFController::class, 'generatePdf'])->name('pdf-download');
///////////////////////////////////////////////////////////////////////////


////////////////////////////  ADDING STUFF     /////////////////////////////

Route::get('/add/gamme', [GammeController::class, 'index']);
Route::post('/add-gamme', [GammeController::class, 'addGamme'] );
Route::get('/add/moto', [MotoController::class,'motoAdd']);
Route::post('/add-moto', [MotoController::class,'addmoto'])->name('addMoto');
Route::get('/add/moto/characteristic', [CaracteristiqueController::class,'showAddingCarac'])->name('showCarac');
Route::post('/add-moto-caracteristic', [CaracteristiqueController::class, 'addCarac'])->name('addCaracteristic');
Route::get('add/moto/option', [OptionController::class,'showAddingOptions'])->name('showOption');
Route::post('/add-moto-option', [OptionController::class,'addOption'])->name('addOption');
Route::get('add/moto/accessoire', [AccessoireController::class,'showAddingAcc'])->name('showAcc');
Route::post('/add-moto-accessoire', [AccessoireController::class,'addAcc'])->name('addAccessoire');
