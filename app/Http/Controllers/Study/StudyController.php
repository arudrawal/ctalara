<?php

namespace App\Http\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Models\Study;
use App\Models\Sponsor;
use App\Models\Protocol;
use App\Providers\RouteServiceProvider;
//use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $studies = null;
        $selected_sponser_id = Session::get('sponsor_id', 0);
        if ($selected_sponser_id) {
            //$studies = Study::with(['protocol'])->where('protocols.sponsor_id', $selected_sponser_id)->get();
            $studies = DB::table('studies')
                ->join('protocols', 'protocols.id', '=', 'studies.protocol_id')
                ->where('protocols.sponsor_id', '=', $selected_sponser_id)->get();
        } else {
            //$sponsor = new Sponsor();
        }
        return view('study.study-index', [
                    'studies'=> $studies,
                    ]);
    }
}
