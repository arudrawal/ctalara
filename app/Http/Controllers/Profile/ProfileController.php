<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

use App\Models\Sponsor;
use App\Models\Study;
use App\Models\SponsorProfile;
use App\Models\SponsorProfilePermission;

use App\Providers\RouteServiceProvider;
//use Illuminate\Auth\Events\Registered;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('profile.profile-index');
    }
    
    // Sponsor Admin user profile assignment
    public function profileAdminIndex(Request $request)
    {
        return view('profile.profile-admin-index',[]);
    }
    
    // Study specific user profile assignment
    public function profileUserIndex(Request $request)
    {
        $studies = null;
        $sponsor_id = Session::get('sponsor_id', 0);
        $study_id = Session::get('study_id', 0);
        if ($sponsor_id) {
            $studies = DB::table('studies')->select ('studies.*')
                ->join('protocols', 'protocols.id', '=', 'studies.protocol_id')
                ->where ('protocols.sponsor_id', $sponsor_id)->get();
        }
        return view('profile.profile-user-index',[
            'filter_study' => $study_id,
            'studies' => $studies, 
        ]);
    }
}
