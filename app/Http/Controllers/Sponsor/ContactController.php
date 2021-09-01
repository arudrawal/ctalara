<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorContact;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
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
        return view('sponsor.contact-index', [
                    'contacts' => $contacts,
                    ]);
    }
}
