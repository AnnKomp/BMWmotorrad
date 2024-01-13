<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class PackController extends Controller
{

    /**
     * Display information about a specific pack.
     */
    public function info(Request $request): View
    {
        $idpack = $request->input('id');

        $idmoto = Pack::select('idmoto')->where('idpack', $idpack)->first();
        $idmotoValue = $idmoto ? $idmoto->idmoto : null;

        $pack = Pack::where('idpack', '=', $idpack)->get();

        session(['lastUsedView' => 'pack']);

        $options = Option::join('secompose', 'option.idoption', '=', 'secompose.idoption')
            ->where('secompose.idpack', '=', $idpack)->get();

        return view("pack", ['options' => $options, 'pack' => $pack, 'idmoto' => $idmotoValue, 'idpack' => $idpack]);
    }

    /**
     * Display the index of packs.
     */
    public function index(): View
    {
        return view("packs", ['packs' => Pack::all()]);
    }

    /**
     * Display packs for a specific moto.
     */
    public function store(Request $request): View
    {
        $idmoto = $request->input('id');

        $packs = Pack::select('*')->where('idmoto', '=', $idmoto)->get();

        return view("packs", ['packs' => $packs, 'idmoto' => $idmoto]);
    }

    /**
     * Get packs based on selected pack IDs.
     */
    public function getPacks(array $selectedPacks)
    {
        return Pack::whereIn('idpack', $selectedPacks)->get();
    }

    /**
     * Display the form for selecting packs.
     *
     * @param Request $request
     * @return View
     */
    public function showPacksForm(Request $request): View
    {
        $idmoto = $request->input('id');
        $packs = Pack::select('*')->where('idmoto', "=", $idmoto)->get();

        return view('moto-pack', ['packs' => $packs, 'idmoto' => $idmoto]);
    }

    /**
     * Process the selected packs form.
     */
    public function processPacksForm(Request $request): RedirectResponse
    {
        $idmoto = $request->input('id');
        $selectedPacks = $request->input('packs', []);
        session(['selectedPacks' => $selectedPacks]);

        return redirect('/options?id=' . $idmoto);
    }


    /**
     * Display the form for adding a pack.
     */
    public function showAddingPack(Request $request): View
    {
        $idmoto = $request->input('idmoto');

        return view('add-pack', ['idmoto' => $idmoto]);
    }

    /**
     * Add a new pack.
     */
    public function addPack(Request $request): RedirectResponse
    {
        try {
            $idmoto = $request->input('idmoto');

            $pack = new Pack([
                'idmoto' => $idmoto,
                'nompack' => $request->input('nompack'),
                'descriptionpack' => $request->input('descriptionpack'),
                'photopack' => $request->input('photopack'),
                'prixpack' => $request->input('prixpack'),
            ]);

            $pack->save();

            return redirect()->route('update.result', ['result' => 'negative']);
        } catch (\Exception $e) {
            return redirect()->route('update.result', ['result' => 'pack-nom']);
        }
    }
}
