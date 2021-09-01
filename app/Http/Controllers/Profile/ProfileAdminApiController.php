<?php

namespace App\Http\Controllers\Profile;

use App\Models\SponsorUserProfile;
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

class ProfileAdminApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of protocol visits}
      * Show assignments for single study only
      */
    public function index(Request $request)
    {
      $sponsor_id = Session::get('sponsor_id', 0);
      // [profiles]=>[users]
      $user_profiles = DB::table('sponsor_user_profiles')
        ->select('sponsor_user_profiles.*',
                'sponsor_profiles.name as profile_name', 'sponsor_profiles.description as profile_desciprtion',
                'users.name as user_name', 'users.email as user_email')
        ->leftJoin('users', 'users.id', '=', 'sponsor_user_profiles.user_id')
        ->leftJoin('sponsor_profiles', 'sponsor_user_profiles.sponsor_profile_id', '=', 'sponsor_profiles.id')
        ->where('sponsor_user_profiles.sponsor_id', $sponsor_id)
        ->get();
      $profiles = [];
      foreach ($user_profiles as $user_profile) {
        if (!array_key_exists($user_profile->sponsor_profile_id, $profiles)){
          $profiles[$user_profile->sponsor_profile_id] = [
              'sponsor_profile_id'=> $user_profile->sponsor_profile_id,
              'profile_name'=> $user_profile->profile_name,
              'profile_desciprtion'=> $user_profile->profile_desciprtion,
              'users' => [],
            ];
        }
        if (!array_key_exists($user_profile->user_id, $profiles[$user_profile->sponsor_profile_id]['users'])){
          $profiles[$user_profile->sponsor_profile_id]['users'][] = [
              'user_id' => $user_profile->user_id,
              'user_name' => $user_profile->user_name,
              'user_email' => $user_profile->user_email];
        }
      }
      $total = count($profiles);
      $meta = $this->getMetaData($request, $total, 'profile_name');
      $finalProfiles = [];
      foreach ($profiles as $profile_id => $oneProfile) {
        $finalProfiles[] = $oneProfile;
      }
      $respData = ['meta' => $meta, 'data' => $finalProfiles];
      return $this->api_success($respData);
    }
    
    public function create(Request $request)
    {
    }
    public function delete(Request $request)
    {
    }
}
