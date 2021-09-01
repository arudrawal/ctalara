<?php

namespace App\Services;

use App\Constants\VisitStatus;
use App\Constants\FormStatus;

use App\Models\User;
use App\Models\Subject;
use App\Models\Study;
use App\Models\Protocol;
use App\Models\ProtocolVisit;
use App\Models\ProtocolVisitForm;
use App\Models\SubjectVisit;
use App\Models\SubjectVisitForm;
use Illuminate\Support\Str;

class SubjectEnrollment {
    // Populate all visits and forms for the given subject
    // TODO: Make it single tranaction
    public static function addProtocolVisitForms(Subject $subject, Study $study) {
        $qb = ProtocolVisit::where('protocol_id', '=', $study->protocol_id)
                        ->orderBy('order', 'asc');
        //echo $qb->toSql();
        $protocol_visits = $qb->get();
        foreach ($protocol_visits as $protocol_visit) {
            //echo 'visit: ' . $protocol_visit->id . PHP_EOL;
            // Create subject visit.
            $subVisit = new SubjectVisit;
            $subVisit->uuid = Str::uuid()->toString(); // visit_uuid
            $subVisit->subject_id = $subject->id;
            $subVisit->subject_uuid = $subject->uuid;
            $subVisit->order = $protocol_visit->order;
            # sub_order/type varies for emergency visits
            $subVisit->sub_order = $protocol_visit->order; // same order as protocl visits.
            $subVisit->visit_type = $protocol_visit->visit_type; // same type for protocl visits.

            $subVisit->protocol_visit_id = $protocol_visit->id;
            $subVisit->visit_status_id = VisitStatus::SCHEDULED; // default visit status
            $subVisit->form_status_id = FormStatus::EMPTY; // summary of all forms
            $subVisit->save();
            $protocolVisitForms = ProtocolVisitForm::where('visit_id', '=', $protocol_visit->id)->orderBy('order', 'asc')->get();
            // create subject visit from protocol
            foreach ($protocolVisitForms as $protocolForm) {
                $visitForm = new SubjectVisitForm;
                $visitForm->uuid = Str::uuid()->toString();
                $visitForm->subject_id = $subVisit->subject_id;
                $visitForm->subject_uuid = $subVisit->subject_uuid;
                $visitForm->subject_visit_id = $subVisit->id;
                $visitForm->subject_visit_uuid = $subVisit->uuid;

                $visitForm->form_id = $protocolForm->id;
                $visitForm->form_status_id = FormStatus::EMPTY;
                $visitForm->form_order = $protocolForm->order;
                $visitForm->form_sub_order = $protocolForm->order;
                $visitForm->save();
            }
        }
    }    
}

