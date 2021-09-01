<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorContact;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SponsorController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $contacts = null;
        $selected_sponser_id = Session::get('sponsor_id', 0);
        if ($selected_sponser_id) {
            $contacts = SponsorContact::where('sponsor_id', $selected_sponser_id)->get();
        }
        return view('sponsor.sponsor-index', [
                    'contacts' => $contacts,
                    ]);
    }

    /**
     * Handle an incoming select sponsor request via web client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function select(Request $request)
    {	
        $id = $request->input('id', 0);
        $redirectTo = $request->input('redirect', '/sponsor/index');
        if ($id) {
          $sponsor = Sponsor::where('id', '=', $id)->first();
          if ($sponsor->id) {
            Session::put('sponsor_id', $sponsor->id);
          }
        }
        return redirect($redirectTo);
    }
}
