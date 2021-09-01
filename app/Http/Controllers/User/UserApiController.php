<?php

namespace App\Http\Controllers\User;

use App\Models\Study;
use App\Models\Sponsor;
use App\Models\Protocol;
use App\Models\Subject;
use App\Http\Resources\StudyResource;
use App\Http\Resources\StudyCollection;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

use App\Services\SubjectEnrollment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UserApiController extends Controller
{
    use ApiResponse;
     /**
      * @return json {list of sponsor for user}
      */
      public function indexSponsor(Request $request)
      {
          $sponsorsAll = collect([]);
          $userModel = $this->api_user($request);
          if ($userModel->profile) { // admin user - all sponsors
            $sponsorsAll = DB::table('sponsors')->orderBy('name', 'asc')->get();
          } else { // show assigned sponsors
            $sponsorsAll = DB::table('sponsors')->select('sponsors.*')
              ->leftJoin('sponsor_user_profiles', 'sponsor_user_profiles.sponsor_id', '=', 'sponsors.id')
              ->where('sponsor_user_profiles.user_id', $userModel->id)
              ->orderBy('name', 'asc')
              ->get();
          }
          $total = $sponsorsAll->count();
          $meta = $this->getMetaData($request, $total, 'id');
          $sponsors = collect([]);
          // pagination: Apply offset and limit on collection
          if ($meta['sort'] == 'asc') {
            $sponsors = $sponsorsAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
          } else {
            $sponsors = $sponsorsAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
          }
          $resData['data'] = $sponsors->toArray();
          $resData['meta'] = $meta;
          return $this->api_success($resData);
      }
    /**
      * @return json {list of studies for a sponsor}
      */
    public function indexStudy(Request $request, $sponsor_id)
    {
        $studiesAll = collect([]);
        $userModel = $this->api_user($request);
        if ($userModel->profile) { // admin user - all studies
          $studiesAll = DB::table('studies')
            ->select('studies.*', 'protocols.code as protocol_code', 'sponsors.name as sponsor_name')
            ->join('protocols', 'protocols.id', '=', 'studies.protocol_id')
            ->join('sponsors', 'sponsors.id', '=', 'protocols.sponsor_id')
            ->where('protocols.sponsor_id', '=', $sponsor_id)->get();
        } else { // show assigned studies
          $studiesAll = DB::table('studies')
            ->select('studies.*', 'protocols.code as protocol_code', 'sponsors.name as sponsor_name')  
            ->join('protocols', 'protocols.id', '=', 'studies.protocol_id')
            ->join('sponsors', 'sponsors.id', '=', 'protocols.sponsor_id')
            ->join('study_user_profiles', 'studies.id', '=', 'study_user_profiles.study_id')
            ->where('study_user_profiles.user_id', '=', $userModel->id)->get();
        }
        $total = $studiesAll->count();
        $meta = $this->getMetaData($request, $total, 'id');
        $studies = collect([]);
        // pagination: Apply offset and limit on collection
        if ($meta['sort'] == 'asc') {
          $studies = $studiesAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
        } else {
          $studies = $studiesAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
        }
        $studiesArray = $studies->toArray();
        // convert date time on server as per user tz
        /*$dts = new \DateTime();
        $dte = new \DateTime();
        foreach ($studiesArray as $key=>$value) {
          $studiesArray[$key]['period'] = $dts->format('m/d/Y') . ' - ' . $dte->format('m/d/Y');
        }*/
        $resData['data'] = $studiesArray;
        $resData['meta'] = $meta;
        return $this->api_success($resData);
    }
     /**
      * @return json {list of sites for a study}
      */
      public function indexSite(Request $request, $study_id)
      {
          $sitesAll = collect([]);
          $userModel = $this->api_user($request);
          if ($userModel->profile) { // admin user - all sites
            $sitesAll = DB::table('study_sites')
              ->select('study_sites.*')
              ->where('study_sites.study_id', '=', $study_id)->get();
          } else { // show check profile for access to sites
            $sitesAll = DB::table('study_sites')
              ->select('study_sites.*')
              ->where('study_sites.study_id', '=', $study_id)->get();
          }
          $total = $sitesAll->count();
          $meta = $this->getMetaData($request, $total, 'id');
          $sites = collect([]);
          // pagination: Apply offset and limit on collection
          if ($meta['sort'] == 'asc') {
            $sites = $sitesAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
          } else {
            $sites = $sitesAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
          }
          $resData['data'] = $sites->toArray();
          $resData['meta'] = $meta;
          return $this->api_success($resData);
      }
     /**
      * @return json {list of sites for a study}
      */
      public function indexSubject(Request $request, $study_id)
      {
          $subjectsAll = collect([]);
          $userModel = $this->api_user($request);
          if ($userModel->profile) { // admin user - all sites
            $subjectsAll = DB::table('subjects')
              ->select('subjects.*')
              ->where('subjects.study_id', '=', $study_id)->get();
          } else { // show check profile for access to sites
            $subjectsAll = DB::table('subjects')
              ->select('subjects.*')
              ->where('subjects.study_id', '=', $study_id)->get();
          }
          $total = $subjectsAll->count();
          $meta = $this->getMetaData($request, $total, 'id');
          $subjects = collect([]);
          // pagination: Apply offset and limit on collection
          if ($meta['sort'] == 'asc') {
            $subjects = $subjectsAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
          } else {
            $subjects = $subjectsAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
          }
          $resData['data'] = $subjects->toArray();
          $resData['meta'] = $meta;
          return $this->api_success($resData);
      }
      public function subjectCreate(Request $request) 
      {
          $msg = '';
          $request->validate([
            'code' => 'string|max:64',
            'initials' => 'string|max:64',
          ]);
          $study_id = $request->input('study_id', 0);
          if ($study_id) {
            $study = Study::where('id', '=', $study_id)->first();
          } else { // error study_id required
            return $this->error('Valid study is required', 400);
          }
          $id = $request->input('id', 0);
          if ($id) {
            $subject = Subject::where('id', '=', $id)->first();
            $msg = 'Updated subject';
          } else { // create
            $subject = new Subject();
            $msg = 'Added subject';
          }
          $subject->uuid = Str::uuid()->toString();
          //$subject->uuid = Str::orderedUuid()->toString();
          $subject->study_id = $study_id;
          $subject->site_id = $request->input('site_id');
          $subject->code = $request->input('code');
          $subject->initials = $request->input('initials');
          $subject->gender = $request->input('gender');
          $subject->subject_status_id = $request->input('status');
          //$subject->enrolled_at = $request->input('enrolled_at');
          if ($subject->id) { //  update
            $subject->save();
          } else { // add
            $subject->save();
            SubjectEnrollment::addProtocolVisitForms($subject, $study);
          }
          
          return $this->success($msg);
      }
     /**
      * @return json {list of visits for a subject}
      */
      public function indexSubjectVisit(Request $request, $subject_id)
      {
          $visitsAll = collect([]);
          $userModel = $this->api_user($request);
          if ($userModel->profile) { // admin user - all sites
            $visitsAll = DB::table('subject_visits')
              ->select('subject_visits.*')
              ->where('subject_visits.subject_id', '=', $subject_id)->get();
          } else { // show check profile for access to sites
            $visitsAll = DB::table('subject_visits')
              ->select('subject_visits.*')
              ->where('subject_visits.subject_id', '=', $subject_id)->get();
          }
          $total = $visitsAll->count();
          $meta = $this->getMetaData($request, $total, 'id');
          $visits = collect([]);
          // pagination: Apply offset and limit on collection
          if ($meta['sort'] == 'asc') {
            $visits = $visitsAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
          } else {
            $visits = $visitsAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
          }
          $resData['data'] = $visits->toArray();
          $resData['meta'] = $meta;
          return $this->api_success($resData);
      }
    /**
      * @return json {list of forms for a subject/visit}
      */
      public function indexSubjectVisitForm(Request $request, $visit_id)
      {
          $formsAll = collect([]);
          $userModel = $this->api_user($request);
          if ($userModel->profile) { // admin user - all forms
            $formsAll = DB::table('subject_visit_forms')
              ->select('subject_visit_forms.*')
              ->where('subject_visit_forms.subject_visit_id', '=', $visit_id)->get();
          } else { // show check profile for access to sites
            $formsAll = DB::table('subject_visit_forms')
              ->select('subject_visit_forms.*')
              ->where('subject_visit_forms.subject_visit_id', '=', $visit_id)->get();
          }
          $total = $formsAll->count();
          $meta = $this->getMetaData($request, $total, 'id');
          $forms = collect([]);
          // pagination: Apply offset and limit on collection
          if ($meta['sort'] == 'asc') {
            $forms = $formsAll->slice($meta['offset'], $meta['perpage'])->sortBy($meta['field']);
          } else {
            $forms = $formsAll->slice($meta['offset'], $meta['perpage'])->sortByDesc($meta['field']);
          }
          $resData['data'] = $forms->toArray();
          $resData['meta'] = $meta;
          return $this->api_success($resData);
      }
}
