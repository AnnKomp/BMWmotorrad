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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnonController;
use App\Http\Controllers\GammeController;
use App\Http\Controllers\RGPDController;
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


Route::get("/option",[OptionController::class, "info" ]);

Route::get("/accessoire",[AccessoireController::class, "info" ]);



Route::get("/motos",[MotoController::class, "index" ]);
Route::get("/moto",[MotoController::class, "detail" ]);
Route::get("/motos-filtered",[MotoController::class, "filter" ]);
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
    $typecompte = auth()->user()->typecompte;
    if($typecompte == 1){
        return view('commercialdashboard');
    }
    if($typecompte == 2){
        return view('dpodashboard');
    }
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
    //Controller for the action available
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/commands', [ProfileController::class, 'commands'])->name('profile.commands');
    Route::get('/profile/commands/detail', [ProfileController::class, 'command_detail'])->name('profile.commands.detail');
    Route::delete('/annuler-commande/{id_commande}/{id_equipement}/{id_taille}/{id_coloris}/{quantite}', [ProfileController::class, 'annulerCommande'])->name('annuler_commande');
    Route::post('/profile', [ProfileController::class, 'updateadress'])->name('adress.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/anonymize', [ProfileController::class, 'anonymize'])->name('profile.anonymize');
    //Controller for the Phone verification
    Route::get('/login/phoneverification', [PhoneVerificationController::class, 'create'])->name('phoneverification');
    Route::post('/login/phoneverification', [PhoneVerificationController::class, 'store'])->name('phoneverification');
    //Controller for the orders
    // Stripe payment
    Route::get('/panier/commandestripe', [CommandeController::class, 'createstripe']);
    Route::post('/panier/commandestripe', [CommandeController::class, 'paystripe'])->name('paymentstripe');
    Route::get('/panier/commande/success', [CommandeController::class, 'success'])->name('commandesuccess');
    // CB payment
    Route::get('/panier/commandecb', [CommandeController::class, 'createcb']);
    Route::post('/panier/commandecb', [CommandeController::class, 'paycb'])->name('paymentcb');
    // Client data
    Route::get('/profiledata', [ProfileController::class, 'indexPDF'])->name('profile.clientdata');
    Route::post('/profiledata', [ProfileController::class, 'generatePDF'])->name('profile.clientdownload');
});


Route::middleware(['auth', 'checkAdminType'])->group(function () {
    //Controller for the intern possibilities
    Route::get('/fraislivraison', [AdminController::class, 'deliveringFees'])->name('delivering-fees');
    Route::post('/fraislivraison', [AdminController::class, 'updateDeliveringFees']);

    Route::get('/motos-commercial', [AdminController::class, 'motolistCom'])->name('motos-com');

    Route::get('/motos-commercial', [AdminController::class, 'motolistCom'])->name('motos-com');


    ////////////////////////////  ADDING MOTOS     /////////////////////////////

    Route::get('/add/gamme', [GammeController::class, 'index'])->name('addGammeCom');
    Route::post('/add-gamme', [GammeController::class, 'addGamme']);
    Route::get('/add/moto', [MotoController::class,'motoAdd'])->name('addMotoBouton');
    Route::post('/add-moto', [MotoController::class,'addmoto'])->name('addMoto');
    Route::get('/add/moto/characteristic', [CaracteristiqueController::class,'showAddingCarac'])->name('showCarac');
    Route::post('/add-moto-caracteristic', [CaracteristiqueController::class, 'addCarac'])->name('addCaracteristic');
    Route::get('add/moto/option', [OptionController::class,'showAddingOptions'])->name('showOption');
    Route::post('/add-moto-option', [OptionController::class,'addOption'])->name('addOption');
    Route::get('add/moto/accessoire', [AccessoireController::class,'showAddingAcc'])->name('showAcc');
    Route::post('/add-moto-accessoire', [AccessoireController::class,'addAcc'])->name('addAccessoire');
    Route::get('/add/photo', [MotoController::class,'showAddPhoto'])->name('showAddPhoto');
    Route::post('/add-photo', [MotoController::class,'addphoto'])->name('addPhoto');
    Route::get('/add/moto/pack', [PackController::class,'showAddingPack'])->name('showPack');
    Route::post('/add-moto-pack', [PackController::class, 'addPack'])->name('addPack');


    //////////////////////////      EDITING MOTOS      ///////////////////////////////

    Route::get('/moto-commercial', [MotoController::class, 'showMotoCommercial'])->name('showMotoCommercial');
    Route::get('/edit-caracteristique', [MotoController::class, 'showEditCaracteristique'])->name('editCaracteristic');
    Route::post('/update-caracteristique', [MotoController::class, 'UpdateCaracteristique'])->name('update-caracteristique');
    Route::get('/edit-option', [MotoController::class, 'showEditOption'])->name('editOption');
    Route::post('/update-option', [MotoController::class, 'updateOption'])->name('updateOption');
    Route::get('/edit-accessoire', [MotoController::class, 'showEditAccessoire'])->name('editAccessoire');
    Route::post('/update-accessoire', [MotoController::class, 'updateAccessoire'])->name('updateAccessoire');
    Route::get('/edit-pack', [MotoController::class, 'showEditPack'])->name('editPack');
    Route::post('/update-pack', [MotoController::class, 'updatePack'])->name('updatePack');
    Route::post('/add-pack-option', [MotoController::class, 'addOptionPack'])->name('addOptionPack');

    //////////////////////////     DELETING MOTOS    /////////////////////////////////////

    Route::get('/delete-option', [MotoController::class, 'deleteOption'])->name('deleteOption');
    Route::get('/delete-accessoire', [MotoController::class, 'deleteAccessoire'])->name('deleteAccessoire');
    Route::get('/delete-pack', [MotoController::class, 'deletePack'])->name('deletePack');
    Route::get('/delete-option-pack', [MotoController::class, 'deleteOptPack'])->name('deleteOptPack');


    //////////////////////////     EDITING EQUIPMENTS    /////////////////////////////////////

    Route::get('/modifequipment', [AdminController::class, 'modifequipment'])->name('modifequipment');
    Route::post('/modify-equipment', [AdminController::class, 'showEquipmentModificationForm'])->name('equipment.modify');
    Route::post('/update-equipment', [AdminController::class, 'updateEquipment'])->name('equipment.update');
    Route::post('/add-coloris-equipment', [AdminController::class, 'addColorisEquipement'])->name('equipement.coloris.add');
    Route::get('/update-result/{result}', [AdminController::class, 'showUpdateResult'])->name('update.result');



});

Route::get('/anonymisation', [AnonController::class, 'create'])->name('dpoanon');
Route::post('/anonymisation', [AnonController::class, 'execute'])->name('anon.execute');



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
Route::get("/moto/color",[MotoController::class, "color" ]);
Route::post('/moto/color', [ColorController::class,'processColorsForm'])->name('processColors');

///fin de config
Route::get('/moto-config',  [MotoController::class, 'showMotoConfig']);

///téléchargement PDF
Route::post('/download-pdf', [MotoController::class, 'downloadPDF'])->name('moto-download-pdf');
Route::post('download-pdf', [PDFController::class, 'generatePdf'])->name('pdf-download');
///////////////////////////////////////////////////////////////////////////

Route::get('/cookies', [RGPDController::class, 'createcookies'])->name('cookies');
Route::get('/confidentialite', [RGPDCONTROLLER::class, 'createconfidentialite'])->name('confidentialite');

