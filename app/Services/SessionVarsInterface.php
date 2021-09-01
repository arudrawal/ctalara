<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

Interface SessionVarsInterface {
    public function selectSponsor($sponsor_id);
    public function selectStudy($study_id);
    public function selectSite($site_id);
    public function selectSubject($subject_id);
    public function selectVisit($visit_id);
    public function selectForm($visit_form_id);
}
