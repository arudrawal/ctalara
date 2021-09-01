<?php

namespace App\Http\Controllers\Profile;

use App\Models\SponsorProfile;
use App\Models\SponsorProfilePermission;

use App\Http\Resources\SponsorProfileResource;
use App\Http\Resources\SponsorProfileCollection;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of protocol visits}
      */
    public function index(Request $request)
    {
      // profiles of selected sponsor
      $profiles = null;
      $selected_sponser_id = Session::get('sponsor_id', 0);
      if ($selected_sponser_id) { // only sponsor selected
        $total = SponsorProfile::where('sponsor_id', $selected_sponser_id)->count();
        $meta = $this->getMetaData($request, $total, 'name');
        $profiles = SponsorProfile::where('sponsor_id', $selected_sponser_id)
          ->offset($meta['offset'])->limit($meta['perpage'])
          ->orderBy($meta['field'], $meta['sort'])->get();      
      }
      // pagination:
      $resColl = new SponsorProfileCollection($profiles);
      $resData = $resColl->toArray($request);
      $resData['meta'] = $meta;
      return $this->api_success($resData);
    }
    
    public function create(Request $request)
    {
    }
    public function delete(Request $request)
    {
    }
}
