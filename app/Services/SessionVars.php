<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class SessionVars implements SessionVarsInterface {
    public function selectSponsor($sponsor_id) {
        Session::put('sponsor_id', $sponsor_id);
        Session::forget(['study_id', 'site_id', 'subject_id', 'visit_id', 'visit_form_id']);
    }
    public function selectStudy($study_id) {
        Session::put('study_id', $study_id);
        Session::forget(['site_id', 'subject_id', 'visit_id', 'visit_form_id']);
    }
    public function selectSite($site_id) {
        Session::put('site_id', $site_id);
        Session::forget(['subject_id', 'visit_id', 'visit_form_id']);
    }
    public function selectSubject($subject_id) {
        Session::put('subject_id', $site_id);
        Session::forget(['visit_id', 'visit_form_id']);
    }
    public function selectVisit($visit_id) {
        Session::put('visit_id', $visit_id);
        Session::forget(['visit_form_id']);
    }
    public function selectForm($visit_form_id) {
        Session::put('visit_form_id', $visit_id);  
    }   
}

