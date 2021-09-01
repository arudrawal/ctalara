<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Study;
use App\Models\StudySite;
use App\Models\Subject;
use App\Models\SubjectVisit;
use App\Models\SubjectVisitForm;
use App\Providers\RouteServiceProvider;
use App\Constants\SubjectGender;
use App\Constants\SubjectStatus;
use App\Constants\AdminForm;

use App\Services\SessionVars;
use App\Services\SessionVarsInterface;

//use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    /**
     * Display the user home view.
     *
     * @return \Illuminate\View\View
     */
    public function homeIndex(Request $request)
    {
        return view('user.user-index', []);
    }
    /**
     * Handle select study (sponsor) request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sponsorSelect(Request $request, SessionVars $svar)
    {	
        // deselect - study/site/subject/visit/form
        $sponsor_id = $request->input('id', 0);
        if (!$sponsor_id) {
            $sponsor_id = $request->input('sponsor_id', 0);
        }
        if ($sponsor_id) {
            $sponsor = DB::table('sponsors')->where('id', '=', $sponsor_id)->first();
            if ($sponsor->id) {
                $svar->selectSponsor($sponsor->id);
                return redirect()->route('user.study.index');
                //$request->app->SessionVars->selectSponsor($sponsor->id);
                //App::SessionVars->selectSponsor($sponsor->id);
                //Session::put('sponsor_id', $sponsor->id);
            }
        }
        //return redirect(RouteServiceProvider::HOME);
        // if access to multiple sites - redirect to site selection else auto select site.
        return redirect()->route('user.home');
    }

    /**
     * Display the user study view.
     *
     * @return \Illuminate\View\View
     */
    public function studyIndex(Request $request)
    {
        return view('user.user-study-index', []);
    }
    /**
     * Handle select study (sponsor) request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function studySelect(Request $request)
    {	
        $id = $request->input('id', 0);
        if ($id) {
            $study = DB::table('studies')
                ->select('studies.id', 'protocols.sponsor_id')  
                ->leftJoin('protocols', 'protocols.id', '=', 'studies.protocol_id')
                ->where('studies.id', '=', $id)->first();
            if ($study->id) {
                Session::put('sponsor_id', $study->sponsor_id);
                Session::put('study_id', $study->id);
            }
        }
        //return redirect(RouteServiceProvider::HOME);
        // if access to multiple sites - redirect to site selection else auto select site.

        return redirect()->route('user.site.index');
    }

    /**
     * Display the user sites view.
     *
     * @return \Illuminate\View\View
     */
    public function siteIndex(Request $request)
    {
        return view('user.user-site-index', []);
    }
    /**
     * Handle select site request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function siteSelect(Request $request)
    {	
        $site_id = $request->input('id', 0); // post data
        $userModel = Auth::user();
        // ?? Check user has access to site ??
        if ($site_id) {
            $site = DB::table('study_sites')
                ->where('id', '=', $site_id)->first();
            if ($site->id) {
                Session::put('site_id', $site->id);
            }
        }
        // if access to multiple subjects - redirect to subject selection else auto select subject.
        return redirect()->route('user.subject.index');
    }
    /**
     * Display the user subject view.
     *
     * @return \Illuminate\View\View
     */
    public function subjectIndex(Request $request)
    {
        $study_id = Session::get('study_id', 0);
        $study_sites = StudySite::where('study_id', $study_id)->get();
        return view('user.user-subject-index', [
            'gender_options' => SubjectGender::SUBJECT_GENDER,
            'status_options' => SubjectStatus::SUBJECT_STATUS,
            'study_sites' => $study_sites]
            );
    }
    /**
     * Handle select subject request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subjectSelect(Request $request)
    {	
        $subject_id = $request->input('id', 0); // post data
        $userModel = Auth::user();
        // ?? Check user has access to site ??
        if ($subject_id) {
            $subject = DB::table('subjects')
                ->where('id', '=', $subject_id)->first();
            if ($subject->id) {
                Session::put('subject_id', $subject->id);
            }
        }
        // if access to multiple visits - redirect to visit selection else auto select visit.
        return redirect()->route('user.subject.visit.index');
    }
    /**
     * Display the user visits view.
     *
     * @return \Illuminate\View\View
     */
    public function visitIndex(Request $request)
    {
        $subject_id = Session::get('subject_id', 0);
        $subject_visits = SubjectVisit::where('subject_id', $subject_id)->get();
        return view('user.user-subject-visit-index', [
            'gender_options' => SubjectGender::SUBJECT_GENDER,
            'status_options' => SubjectStatus::SUBJECT_STATUS,
            'subject_visits' => $subject_visits]
            );
        //return view('user.user-study-index', []);
    }
    /**
     * Handle select subject request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subjectVisitSelect(Request $request)
    {	
        $visit_id = $request->input('id', 0); // post data
        $userModel = Auth::user();
        // ?? Check user has access to site ??
        if ($visit_id) {
            $visit = DB::table('subject_visits')
                ->where('id', '=', $visit_id)->first();
            if ($visit->id) {
                Session::put('subject_visit_id', $visit->id);
            }
        }
        // if access to multiple visits - redirect to visit selection else auto select visit.
        return redirect()->route('user.subject.visit.form.index');
    }
    /**
     * Display the user forms view.
     *
     * @return \Illuminate\View\View
     */
    public function subjectFormIndex(Request $request)
    {
        //return view('user.user-study-index', []);
        $visit_id = Session::get('subject_visit_id', 0);
        $subject_forms = SubjectVisitForm::where('subject_visit_id', $visit_id)->get();
        return view('user.user-subject-visit-form-index', [
            'gender_options' => SubjectGender::SUBJECT_GENDER,
            'status_options' => SubjectStatus::SUBJECT_STATUS,
            'subject_forms' => $subject_forms]
            );
    }
    /**
     * Handle select subject/visit/form request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subjectVisitFormSelect(Request $request)
    {	
        $visit_form_row_id = $request->input('id', 0); // post data
        $visit_form_row = SubjectVisitForm::where('id', $visit_form_row_id)->first();
        if ($visit_form_row) {
            //die($visit_form_row);
            if (AdminForm::isValid($visit_form_row->form_id)) {
                Session::put('subject_visit_form_id', $visit_form_row_id);
                // form data.
                return redirect()->route('user.subject.visit.form.data.index');
            }
        }
        // invalid selection
        return redirect()->route('user.subject.visit.form.index');
    }
    /**
     * Display the user form data view.
     *
     * @return \Illuminate\View\View
     */
    public function subjectFormDataIndex(Request $request)
    {
        $visit_form_row_id = Session::get('subject_visit_form_id', 0); // post data
        $form_row = SubjectVisitForm::where('id', $visit_form_row_id)->first();
        if ($form_row) {
            if (AdminForm::isValid($form_row->form_id)) {
                // Serve various forms
                if ($form_row->form_id == AdminForm::MINI) {
                    $form_section = $request->get('form_section', 0);
                } elseif ($form_row->form_id == AdminForm::PANSS) {

                } elseif ($form_row->form_id == AdminForm::CSSRS) {
                
                } elseif ($form_row->form_id == AdminForm::CGI) {

                } elseif ($form_row->form_id == AdminForm::CDSS) {

                } elseif ($form_row->form_id == AdminForm::NSA) {

                } elseif ($form_row->form_id == AdminForm::RANDOMIZE) {

                } else {
                    // select form
                    return redirect()->route('user.subject.visit.form.index');
                }
            }
        }
        return view('user.user-form-data-blank', []);
    }
}
