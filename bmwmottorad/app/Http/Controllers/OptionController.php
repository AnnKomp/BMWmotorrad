<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Accessoire;

use  Illuminate\Support\Facades\DB;


class OptionController extends Controller
{
    /**
     * Display the index view with all available options.
     */
    public function index()
    {
        // Fetch all options from the 'Option' model
        $options = Option::all();

        // Display the view with the list of options
        return view("optionSelection", ['options' => $options]);
    }

    /**
     * Display the info view for a specific option.
     */
    public function info(Request $request)
    {
        // Retrieve input values from the request
        $idoption = $request->input('id');
        $idmoto = $request->input('idmoto');
        $idpack = $request->input('idpack');
        $route = $request->input('route');

        // Retrieve option details from the 'Option' model
        $option = Option::where('idoption', $idoption)->get();

        // Display the view with option information
        return view("option", ['options' => $option, 'idmoto' => $idmoto, 'idpack' => $idpack, 'route' => $route]);
    }

    /**
     * Display the option selection view for a specific motorcycle.
     */
    public function optionSelection(Request $request)
    {
        // Retrieve input values from the request
        $idmoto = $request->input('id');

        // Retrieve options associated with the specified motorcycle from the 'Option' and 'Specifie' models
        $options = Option::join('specifie', 'option.idoption', '=', 'specifie.idoption')
            ->where('specifie.idmoto', '=', $idmoto)
            ->get();

        // Display the view with the option selection for the motorcycle
        return view("optionSelection", ['options' => $options, 'idmoto' => $idmoto]);
    }

    /**
     * Save the selected options.
     */
    public function save(Request $request)
    {
        // Redirect back to the previous page
        return redirect()->back();
    }

    /**
     * Get the selected options.
     */
    public function getOptions(array $selectedOptions)
    {
        // Retrieve options from the 'Option' model based on the selected option IDs
        return Option::whereIn('idoption', $selectedOptions)->get();
    }

    /**
     * Display the selected accessories view.
     */
    public function selectedAccessories(Request $request)
    {
        // Retrieve input values from the request
        $idmoto = $request->input('id');
        $selectedOptions = $request->input('options', []);

        // Retrieve accessories associated with the specified motorcycle from the 'Accessoire' model
        $accessoires = Accessoire::where('idmoto', "=", $idmoto)->get();

        // Display the view with selected accessories
        return view('accessoireSelection', [
            'selectedOptions' => $selectedOptions,
            'idmoto' => $idmoto,
            'accessoires' => $accessoires
        ]);
    }

    /**
     * Show the options form view.
     */
    public function showOptionsForm(Request $request)
    {
        // Retrieve input value for the motorcycle ID
        $idmoto = $request->input('id');

        // Retrieve options associated with the specified motorcycle from the 'Option' and 'Specifie' models
        $options = Option::join('specifie', 'option.idoption', '=', 'specifie.idoption')
            ->where('specifie.idmoto', '=', $idmoto)
            ->get();

        // Display the option selection view
        return view('optionSelection', ['options' => $options, 'idmoto' => $idmoto]);
    }

    /**
     * Process the options form submission.
     */
    public function processOptionsForm(Request $request)
    {
        // Retrieve input values from the request
        $idmoto = $request->input('id');
        $selectedOptions = $request->input('options', []);

        // Store the selected options in the session
        session(['selectedOptions' => $selectedOptions]);

        // Redirect to the accessories page with the motorcycle ID
        return redirect('/accessoires?id=' . $idmoto);
    }

    /**
     * Show the form to add options.
     */
    public function showAddingOptions(Request $request)
    {
        // Retrieve input value for the motorcycle ID
        $idmoto = $request->input('idmoto');

        // Get all existing options from the 'Option' model
        $exOptions = Option::select('*')
            ->get();

        // Display the add-option form view with the motorcycle ID and existing options
        return view('add-option', ['idmoto' => $idmoto, 'exOptions' => $exOptions]);
    }

    /**
     * Add an option for a specific motorcycle and proceed based on the action.
     */
    public function addOption(Request $request)
    {
        try {
            // Retrieve input values from the request
            $idmoto = $request->input('idmoto');
            $action = $request->input('action');
            $idoption = null;

            // Check the action type and proceed accordingly
            if ($action === 'restart' || $action === 'proceedToAccessories') {
                // Check if a new option is being added
                if ($request->has('newOptionName')) {
                    // Retrieve values for the new option
                    $newOptionName = $request->input('newOptionName');
                    $newOptionPrice = $request->input('newOptionPrice');
                    $newOptionDetail = $request->input('newOptionDetail');
                    $newOptionPhotoUrl = $request->input('newOptionPhotoUrl');

                    // Insert the new option into the 'option' table
                    DB::insert('INSERT INTO option(nomoption, prixoption, detailoption, photooption) VALUES (?, ?, ?, ?)',
                        [$newOptionName, $newOptionPrice, $newOptionDetail, $newOptionPhotoUrl]);

                    // Retrieve the last inserted option ID
                    $idoption = DB::getPdo()->lastInsertId();
                } elseif ($request->has('existingOption')) {
                    // Retrieve the ID of the existing option
                    $idoption = $request->input('existingOption');
                }

                // Insert a record into the 'specifie' table to associate the option with the motorcycle
                DB::table('specifie')->insert([
                    'idmoto' => $idmoto,
                    'idoption' => $idoption,
                ]);

                // Redirect based on the action type
                if ($action === 'restart') {
                    return redirect()->route('showOption', ['idmoto' => $idmoto]);
                } elseif ($action === 'proceedToAccessories') {
                    return redirect()->route('showAcc', ['idmoto' => $idmoto]);
                }
            } else {
                return redirect()->route('startPage');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}



