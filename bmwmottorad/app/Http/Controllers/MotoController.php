<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Moto;
use App\Models\Pack;
use App\Models\Option;
use App\Models\Accessoire;
use App\Models\Color;
use App\Models\Gamme;
use App\Models\Media;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class MotoController extends Controller
{
    /**
     * Controller method for fetching and displaying a list of motorcycle ranges and information.
     */
    public function index() {
        // Get all the ranges from the 'Gamme' model
        $ranges = Gamme::select('idgamme', 'libellegamme')
                        ->get()
                        ->toArray();

        // Get information for the motorcycles by joining 'modelemoto' and 'media' tables
        $motos = DB::table('modelemoto')
            ->select('modelemoto.idmoto',
                    'nommoto',
                    'lienmedia',
                    'prixmoto')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('ispresentation', '=', 'TRUE')
            ->get();

        // Display the list of motorcycles
        return view("moto-list", ['motos'=>$motos, 'ranges'=>$ranges]);
    }

    /**
    * Controller method for fetching and displaying detailed information about a specific motorcycle.
    */
    public function detail(Request $request ) {
        // Get the motorcycle's id from the request
        $idmoto = $request->input('id');

        // Get the motorcycle's information by joining 'modelemoto', 'caracteristique', and 'categoriecaracteristique' tables
        $moto_infos = DB::table('modelemoto')
            ->select('nomcatcaracteristique',
                    'nomcaracteristique',
                    'valeurcaracteristique',
                    'nommoto',
                    'descriptifmoto')
            ->join('caracteristique','caracteristique.idmoto','=','modelemoto.idmoto')
            ->join('categoriecaracteristique', 'categoriecaracteristique.idcatcaracteristique','=','caracteristique.idcatcaracteristique')
            ->where('caracteristique.idmoto','=',$idmoto)
            ->get();

        // Get the motorcycle's picture(s) from the 'media' table
        $moto_pics = DB::table('media')
            ->select('lienmedia')
            ->where('idmoto','=',$idmoto)
            ->get();

        // Get the option's information for the motorcycle by joining 'specifie' and 'option' tables
        $moto_options = DB::table('specifie')
            ->select('nomoption',
                    'detailoption')
            ->join('option','option.idoption','=','specifie.idoption')
            ->where('specifie.idmoto','=',$idmoto)
            ->get();

        // Display the detailed information about the motorcycle
        return view("moto", ["infos" => $moto_infos, "moto_pics" => $moto_pics,"moto_options" => $moto_options, "idmoto" => $idmoto]);
    }

    /**
    * Controller method for fetching and displaying a filtered list of motorcycles based on a specified range.
    */
    public function filter(Request $request) {
        // Get the motorcycle's range id from the request
        $moto_range = $request->input('id');

        // Get all the ranges from the 'Gamme' model
        $ranges = Gamme::select('idgamme', 'libellegamme')
                    ->get()
                    ->toArray();

        // Get information for the motorcycles filtered by range by joining 'modelemoto' and 'media' tables
        $motos = DB::table('modelemoto')
            ->select('modelemoto.idmoto',
                'nommoto',
                'lienmedia',
                'prixmoto')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('ispresentation', '=', 'TRUE')
            ->where('modelemoto.idgamme', '=', $moto_range)
            ->get();

        // Display the filtered list of motorcycles by range
        return view("moto-list-filtered", ["motos" => $motos, 'ranges'=>$ranges]);
    }


    /**
     * Controller method for retrieving and displaying motorcycle colors and related information.
     */
    function color(Request $request) {
        // Retrieve input values from the request
        $idmoto = $request->input('idmoto');
        $idcouleur = $request->input('idcouleur');
        $typeselec = $request->input('type');

        // Retrieve motorcycle colors based on idmoto
        $moto_colors = DB::table('couleur')
            ->select('idcouleur',
                    'photocouleur',
                    'nomcouleur',
                    'prixcouleur')
            ->where('idmoto', '=', $idmoto)
            ->get();

        // Retrieve motorcycle information and associated media
        $motos = DB::table('modelemoto')
            ->select('nommoto',
                    'lienmedia')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();

        // Conditionally retrieve source based on typeselec
        if ($typeselec != "style") {
            $source = DB::table('couleur')
                ->select('motocouleur')
                ->where('idcouleur', '=', $idcouleur)
                ->get();

        } else {
            $source = DB::table('style')
                ->select('photomoto')
                ->where('idstyle', '=', $idcouleur)
                ->get();

        }

        // Retrieve styles associated with the motorcycle
        $styles = DB::table('style')
            ->select('idstyle',
                    'photostyle',
                    'nomstyle',
                    'prixstyle')
            ->where('idmoto','=',$idmoto)
            ->get();

        // Return the view with the necessary data
        return view("moto-color", [
            "moto_colors" => $moto_colors,
            "idmoto" => $idmoto,
            "motos" => $motos,
            "source" => $source,
            "idcouleur" => $idcouleur,
            "styles" => $styles,
            "type" => $typeselec
        ]);
    }

    /**
     * Controller method for retrieving and displaying motorcycle packs and related information.
     */
    function pack(Request $request) {
        // Retrieve input value for idmoto
        $idmoto = $request->input('id');

        // Retrieve packs associated with the motorcycle
        $packs = Pack::select('*')->where('idmoto',"=", $idmoto)->get();

        // Retrieve motorcycle information and associated media
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('ispresentation', '=', 'TRUE')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();

        // Return the view with the necessary data
        return view("moto-pack", [
            'packs' => $packs,
            'idmoto' => $idmoto,
            "motos" => $motos
        ]);
    }

    /**
     * Controller method for retrieving and displaying the motorcycle configuration.
     */
    function showMotoConfig(Request $request) {
        // Retrieve input value for idmoto
        $idmoto = $request->input('id');

        // Retrieve selected items from the session
        $selectedPacks = session('selectedPacks', []);
        $selectedOptions = session('selectedOptions', []);
        $selectedAccessoires = session('selectedAccessoires', []);
        $selectedColor = session('selectedColor', []);
        $selectedStyle = session('selectedStyle', []);

        // Retrieve motorcycle details with associated packs, options, accessories, colors, and styles
        $moto = Moto::with(['packs', 'options', 'accessoires', 'couleurs', 'styles'])
            ->where('idmoto', $idmoto)
            ->first();

        // Calculate total price based on selected items
        $totalPrice = $moto->prixmoto
            + $moto->packs->whereIn('idpack', $selectedPacks)->sum('prixpack')
            + $moto->options->whereIn('idoption', $selectedOptions)->sum('prixoption')
            + $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires)->sum('prixaccessoire')
            + $moto->couleurs->whereIn('idcouleur', $selectedColor)->sum('prixcouleur')
            + $moto->styles->whereIn('idstyle', $selectedStyle)->sum('prixstyle');

        // Return the view with the necessary data
        return view('moto-config', [
            'selectedPacks' => $moto->packs->whereIn('idpack', $selectedPacks),
            'idmoto' => $idmoto,
            'moto' => $moto,
            'totalPrice' => $totalPrice,
            'selectedOptions' => $moto->options->whereIn('idoption', $selectedOptions),
            'selectedAccessoires' => $moto->accessoires->whereIn('idaccessoire', $selectedAccessoires),
            'selectedColor' => $moto->couleurs->whereIn('idcouleur', $selectedColor),
            'selectedStyle' => $moto->styles->whereIn('idstyle', $selectedStyle)
        ]);
    }


    /**
     * Controller method for displaying the form to add packs for a specific motorcycle.
     */
    public function showPacksForm(Request $request)
    {
        // Retrieve input value for idmoto
        $idmoto = $request->input('id');

        // Retrieve packs associated with the motorcycle
        $packs = Pack::where('idmoto', $idmoto)->get();

        // Retrieve motorcycle information and associated media
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->where('ispresentation', '=', 'TRUE')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();

        // Return the view with the necessary data
        return view('moto-pack', ['packs' => $packs, 'idmoto' => $idmoto, 'motos' => $motos]);
    }

    /**
     * Controller method for displaying the form to add colors for a specific motorcycle.
     */
    public function showColorsForm(Request $request)
    {
        // Retrieve input value for idmoto
        $idmoto = $request->input('id');

        // Retrieve colors associated with the motorcycle
        $colors = Color::where('idmoto', $idmoto)->get();

        // Retrieve motorcycle information and associated media
        $motos = DB::table('modelemoto')
            ->select('*')
            ->join('media', 'media.idmoto','=','modelemoto.idmoto')
            ->whereColumn('idmediapresentation', 'idmedia')
            ->where('modelemoto.idmoto', '=', $idmoto)
            ->get();

        // Return the view with the necessary data
        return view('moto-color', ['colors' => $colors, 'idmoto' => $idmoto, 'motos' => $motos]);
    }

    /**
     * Controller method for displaying the form to add a motorcycle.
     */
    public function motoAdd()
    {
        // Retrieve all gammes of motorcycles
        $gammes = DB::table('gammemoto')
            ->select('*')
            ->get();

        // Return the view with the necessary data
        return view("add-moto", ['gammes' => $gammes]);
    }

    /**
     * Controller method for adding a new motorcycle to the database.
     */
    public function addMoto(Request $request)
    {
        try {
            // Retrieve input values from the request
            $newMotoGamme = $request->input('motoGamme');
            $newMotoName = $request->input('motoName');
            $newMotoDesc = $request->input('motoDesc');
            $newMotoPrice = $request->input('motoPrice');
            $newMediaLien = $request->input('mediaPresentation');

            // Insert new motorcycle details into the database
            DB::insert('INSERT INTO modelemoto(idgamme, nommoto, descriptifmoto, prixmoto) VALUES (?,?,?,?)' ,
                [$newMotoGamme, $newMotoName, $newMotoDesc, $newMotoPrice]);

            // Retrieve the last inserted id (idmoto)
            $idmoto = DB::getPdo()->lastInsertId();

            // Insert media details for the new motorcycle
            DB::insert('INSERT INTO media(idmoto, lienmedia) VALUES (?,?)', [$idmoto, $newMediaLien]);

            // Retrieve the last inserted id (idmedia)
            $idmedia = DB::getPdo()->lastInsertId();

            // Update modelemoto with the idmediapresentation
            DB::update('UPDATE MODELEMOTO SET idmediapresentation = ' . $idmedia . ' WHERE idmoto = ' . $idmoto);

            // Retrieve category characteristics
            $catcarac = DB::table('categoriecaracteristique')
                ->select('*')
                ->get();

            // Determine the action from the request
            $action = $request->input('action');

            // Redirect based on the selected action
            if ($action === 'finishLater') {
                return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
            } else {
                return redirect()->route('showCarac', ['idmoto' => $idmoto])->with('catcarac', $catcarac);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for displaying the commercial details of a motorcycle.
     */
    public function showMotoCommercial(Request $request)
    {
        // Retrieve input value for idmoto
        $idmoto = $request->input('id');

        // Retrieve motorcycle details
        $motoDetails = DB::table('modelemoto')->where('idmoto', $idmoto)->first();

        // Retrieve characteristics associated with the motorcycle
        $caracteristiques = DB::table('caracteristique as c')
            ->join('categoriecaracteristique as cc', 'c.idcatcaracteristique', '=', 'cc.idcatcaracteristique')
            ->where('c.idmoto', $idmoto)
            ->select('cc.nomcatcaracteristique', 'c.nomcaracteristique', 'c.valeurcaracteristique', 'c.idcaracteristique', 'c.idmoto')
            ->get();

        // Retrieve options associated with the motorcycle
        $options = DB::table('option as o')
            ->join('specifie as s', 'o.idoption', '=', 's.idoption')
            ->where('s.idmoto', $idmoto)
            ->select('o.*', 's.idoption', 's.idmoto')
            ->get();

        // Retrieve accessories associated with the motorcycle
        $accessoires = DB::table('accessoire')
            ->where('idmoto', $idmoto)
            ->get();

        // Retrieve packs associated with the motorcycle
        $packs = Pack::select('*')->where('idmoto', "=", $idmoto)->get();

        // Return the view with the necessary data
        return view('moto-commercial', [
            'motoName' => $motoDetails->nommoto,
            'caracteristiques' => $caracteristiques,
            'options' => $options,
            'accessoires' => $accessoires,
            'idmoto' => $idmoto,
            'packs' => $packs,
        ]);
    }


    /**
     * Controller method for displaying the form to edit a characteristic of a motorcycle.
     */
    public function showEditCaracteristique(Request $request)
    {
        // Retrieve input values for idmoto and idcaracteristique
        $idmoto = $request->input('idmoto');
        $idcaracteristique = $request->input('idcaracteristique');

        // Retrieve characteristic details
        $caracteristique = DB::table('caracteristique')
            ->where('idmoto', $idmoto)
            ->where('idcaracteristique', $idcaracteristique)
            ->first();

        // Retrieve the idcatcaracteristique for the selected characteristic
        $selectedCatId = $caracteristique->idcatcaracteristique;

        // Retrieve category characteristics
        $catcarac = DB::table('categoriecaracteristique')
            ->select('*')
            ->get();

        // Return the view with the necessary data
        return view('caracteristique', [
            'idmoto' => $idmoto,
            'idcaracteristique' => $idcaracteristique,
            'catcarac' => $catcarac,
            'selectedCatId' => $selectedCatId,
            'caracteristique' => $caracteristique,
        ]);
    }

    /**
     * Controller method for updating a characteristic of a motorcycle.
     */
    public function updateCaracteristique(Request $request, $idmoto, $idcaracteristique)
    {
        try {
            // Retrieve input values from the request
            $newCatId = $request->input('carCat');
            $newCarName = $request->input('carName');
            $newCarValue = $request->input('carValue');

            // Update the characteristic details in the database
            DB::table('caracteristique')
                ->where('idmoto', $idmoto)
                ->where('idcaracteristique', $idcaracteristique)
                ->update([
                    'idcatcaracteristique' => $newCatId,
                    'nomcaracteristique' => $newCarName,
                    'valeurcaracteristique' => $newCarValue,
                ]);

            // Retrieve updated characteristics, options, accessories, and motorcycle details
            $caracteristiques = DB::table('caracteristique as c')
                ->join('categoriecaracteristique as cc', 'c.idcatcaracteristique', '=', 'cc.idcatcaracteristique')
                ->where('c.idmoto', $idmoto)
                ->select('cc.nomcatcaracteristique', 'c.nomcaracteristique', 'c.valeurcaracteristique', 'c.idcaracteristique', 'c.idmoto')
                ->get();

            $options = DB::table('option as o')
                ->join('specifie as s', 'o.idoption', '=', 's.idoption')
                ->where('s.idmoto', $idmoto)
                ->select('o.*', 's.idoption', 's.idmoto')
                ->get();

            $accessoires = DB::table('accessoire')
                ->where('idmoto', $idmoto)
                ->get();

            $motoDetails = DB::table('modelemoto')->where('idmoto', $idmoto)->first();

            // Redirect to the commercial details page
            return redirect()->route('showMotoCommercial', ['id' => $idmoto]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for displaying the form to edit an option of a motorcycle.
     */
    public function showEditOption(Request $request)
    {
        // Retrieve input values for idmoto and idoption
        $idmoto = $request->input('idmoto');
        $idoption = $request->input('idoption');

        // Retrieve option details
        $option = DB::table('option as o')
            ->join('specifie as s', 'o.idoption', '=', 's.idoption')
            ->where('s.idmoto', $idmoto)
            ->where('s.idoption', $idoption)
            ->first();

        // Return the view with the necessary data
        return view('option-update', [
            'idmoto' => $idmoto,
            'idoption' => $idoption,
            'option' => $option,
        ]);
    }


    /**
     * Controller method for displaying the form to edit an accessory of a motorcycle.
     */
    public function showEditAccessoire(Request $request)
    {
        // Retrieve input values for idmoto and idaccessoire
        $idmoto = $request->input('idmoto');
        $idaccessoire = $request->input('idaccessoire');

        // Retrieve accessory details
        $accessoire = DB::table('accessoire')
            ->where('idmoto', $idmoto)
            ->where('idaccessoire', $idaccessoire)
            ->first();

        // Return the view with the necessary data
        return view('accessoire-update', [
            'idmoto' => $idmoto,
            'idaccessoire' => $idaccessoire,
            'accessoire' => $accessoire,
        ]);
    }

    /**
     * Controller method for updating an option of a motorcycle.
     */
    public function updateOption(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $idoption = $request->input('idoption');
            $newOptName = $request->input('optName');
            $newOptPrice = $request->input('optPrice');
            $newOptDetail = $request->input('optDetail');
            $newOptPhoto = $request->input('optPhoto');

            // Update the option details in the database
            DB::table('option as o')
                ->join('specifie as s', 'o.idoption', '=', 's.idoption')
                ->where('idmoto', $idmoto)
                ->where('s.idoption', $idoption)
                ->update([
                    'nomoption' => $newOptName,
                    'prixoption' => $newOptPrice,
                    'detailoption' => $newOptDetail,
                    'photooption' => $newOptPhoto,
                ]);

            // Redirect to the commercial details page
            return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for updating an accessory of a motorcycle.
     */
    public function updateAccessoire(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $idaccessoire = $request->input('idaccessoire');
            $newAccName = $request->input('accName');
            $newAccPrice = $request->input('accPrice');
            $newAccDetail = $request->input('accDetail');
            $newAccPhoto = $request->input('accPhoto');

            // Update the accessory details in the database
            DB::table('accessoire')
                ->where('idmoto', $idmoto)
                ->where('idaccessoire', $idaccessoire)
                ->update([
                    'nomaccessoire' => $newAccName,
                    'prixaccessoire' => $newAccPrice,
                    'detailaccessoire' => $newAccDetail,
                    'photoaccessoire' => $newAccPhoto,
                ]);

            // Redirect to the commercial details page
            return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Controller method for deleting an option from a motorcycle.
     */
    public function deleteOption(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $idoption = $request->input('idoption');

            // Delete the specified option
            DB::table('specifie')
                ->where('idmoto', $idmoto)
                ->where('idoption', $idoption)
                ->delete();

            // Redirect to the commercial details page
            return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for deleting an accessory from a motorcycle.
     */
    public function deleteAccessoire(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $idaccessoire = $request->input('idaccessoire');

            // Delete the specified accessory
            DB::table('accessoire')
                ->where('idmoto', $idmoto)
                ->where('idaccessoire', $idaccessoire)
                ->delete();

            // Redirect to the commercial details page
            return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for displaying the form to edit a pack of a motorcycle.
     */
    public function showEditPack(Request $request)
    {
        // Retrieve input values for idmoto and idpack
        $idmoto = $request->input('idmoto');
        $idpack = $request->input('idpack');

        // Retrieve the selected pack
        $pack = DB::table('pack')
            ->where('idmoto', $idmoto)
            ->where('idpack', $idpack)
            ->first();

        // Retrieve options associated with the pack
        $options = DB::table('secompose')
            ->select('*')
            ->join('option', 'secompose.idoption', '=', 'option.idoption')
            ->where('idpack', '=', $idpack)
            ->get();

        // Retrieve all options
        $allOptions = Option::all();

        // Return the view with the necessary data
        return view('pack-update', [
            'idmoto' => $idmoto,
            'idpack' => $idpack,
            'pack' => $pack,
            'options' => $options,
            'alloptions' => $allOptions,
        ]);
    }


    /**
     * Controller method for adding an option to a pack.
     */
    public function addOptionPack(Request $request)
    {
        // Retrieve input values from the request
        $idoption = $request->input('idoption');
        $idpack = $request->idpack;

        // Insert the new option-pack relationship
        DB::table('secompose')->insert([
            'idoption' => $idoption,
            'idpack' => $idpack,
        ]);

        // Redirect to the update result page
        return redirect()->route('update.result', ['result' => 'ajouter']);
    }

    /**
     * Controller method for updating the details of a pack.
     */
    public function updatePack(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $idpack = $request->input('idpack');
            $newPackName = $request->input('packName');
            $newPackPrice = $request->input('packPrice');
            $newPackDetail = $request->input('packDetail');
            $newPackPhoto = $request->input('packPhoto');

            // Check if the pack price is non-negative
            if ($newPackPrice >= 0) {
                // Update the pack details in the database
                DB::table('pack')
                    ->where('idmoto', $idmoto)
                    ->where('idpack', $idpack)
                    ->update([
                        'nompack' => $newPackName,
                        'prixpack' => $newPackPrice,
                        'descriptionpack' => $newPackDetail,
                        'photopack' => $newPackPhoto,
                    ]);

                // Redirect to the commercial details page
                return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
            } else {
                // Redirect to the update result page with a 'negative' result
                return redirect()->route('update.result', ['result' => 'negative']);
            }
        } catch (\Exception $e) {
            // Return a JSON response with the error message for internal server error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for deleting a pack from a motorcycle.
     */
    public function deletePack(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $idpack = $request->input('idpack');

            // Delete the specified pack
            DB::table('pack')
                ->where('idmoto', $idmoto)
                ->where('idpack', $idpack)
                ->delete();

            // Redirect to the commercial details page
            return redirect()->route('showMotoCommercial', ['id' => $idmoto]);
        } catch (\Exception $e) {
            // Return a JSON response with the error message for internal server error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Controller method for showing the add photo view.
     */
    public function showAddPhoto(Request $request)
    {
        // Retrieve input value for idmoto
        $idmoto = $request->input('idmoto');

        // Return the view with the necessary data
        return view('add-photo', ['idmoto' => $idmoto]);
    }

    /**
     * Controller method for adding a photo to a motorcycle.
     */
    public function addPhoto(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $lienmedia = $request->input('lienmedia');

            // Create a new Media instance
            $media = new Media([
                'idequipement' => null,
                'idmoto' => $idmoto,
                'lienmedia' => $lienmedia,
                'idpresentation' => null,
            ]);

            // Save the new Media record
            $media->save();

            // Redirect to the showAddPhoto page with the updated idmoto
            return redirect()->route('showAddPhoto', ['id' => $idmoto]);
        } catch (\Exception $e) {
            // Return a JSON response with the error message for internal server error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Controller method for deleting an option-pack relationship.
     */
    public function deleteOptPack(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idoption = $request->input('idoption');
            $idpack = $request->input('idpack');

            // Delete the specified option-pack relationship
            DB::table('secompose')
                ->where('idoption', $idoption)
                ->where('idpack', $idpack)
                ->delete();

            // Redirect to the update result page with a 'optsuppr' result
            return redirect()->route('update.result', ['result' => 'optsuppr']);
        } catch (\Exception $e) {
            // Return a JSON response with the error message for internal server error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
