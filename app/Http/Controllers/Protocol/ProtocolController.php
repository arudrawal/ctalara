<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Models\Protocol;
use App\Models\ProtocolVisit;
use App\Models\Sponsor;
use App\Models\SponsorContact;
use App\Providers\RouteServiceProvider;
//use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class ProtocolController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $protocols = null;
        $selected_sponser_id = Session::get('sponsor_id', 0);
        if ($selected_sponser_id) {
            $sponsor = Sponsor::where('id', '=', $selected_sponser_id)->first();
            $protocols = Protocol::where('sponsor_id', $selected_sponser_id)->get();
        } else {
            $sponsor = new Sponsor();
        }
        //$this->authorize('view', $protocols->first());
        return view('protocol.protocol-index', [
                    'selectedSponsor'=> $sponsor,
                    'protocols'=> $protocols,
                    ]);
    }
    public function visitIndex(Request $request)
    {
        $protocols = null;
        $selected_sponser_id = Session::get('sponsor_id', 0);
        if ($selected_sponser_id) {
            $protocols = Protocol::where('sponsor_id', $selected_sponser_id)->get();
        }
        return view('protocol.visit-index', [
            'protocols' => $protocols]);
    }
}
