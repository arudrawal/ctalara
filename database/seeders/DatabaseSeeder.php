<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Sponsor;
use App\Models\SponsorContact;
use App\Models\Protocol;
use App\Models\ProtocolVisit;
use App\Models\ProtocolVisitForm;
use App\Models\SponsorProfile;
use App\Models\SponsorProfilePermission;
use App\Models\Study;
use App\Models\StudySite;
use App\Models\Subject;
use App\Models\SponsorUserProfile;
use App\Models\StudyUserProfile;

use App\Constants\SecureModel;
use App\Constants\VisitType;
use App\Constants\VisitRangeUnit;
use App\Constants\AdminForm;
use App\Constants\StudyStatus;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::truncate();
        // Software developer - admin
        $userAjay = User::create(['email'=>'ajay@hotmail.com', 'name'=>'Ajay Rudrawal',
                        'password'=>Hash::make('password'), 'profile'=> 1]);
        // Sponsor level - admin
        $userSponsor = User::create(['email'=>'sponsor@hotmail.com', 'name'=>'Sponsor Super User',
            'password'=>Hash::make('password')]);

        $userDoc1 = User::create(['email'=>'doctor1@hotmail.com', 'name'=>'Dr. Doctor1',
                        'password'=>Hash::make('password1')]);
        $userDoc2 = User::create(['email'=>'doctor2@hotmail.com', 'name'=>'Dr. Doctor2',
                        'password'=>Hash::make('password2')]);

        $userRev1 = User::create(['email'=>'reviewer1@hotmail.com', 'name'=>'Reviewer1',
                        'password'=>Hash::make('password1')]);
        $userRev2 = User::create(['email'=>'reviewer2@hotmail.com', 'name'=>'Reviewer2',
                        'password'=>Hash::make('password2')]);

        $userMon1 = User::create(['email'=>'monitor1@hotmail.com', 'name'=>'Monitor1',
                        'password'=>Hash::make('password1')]);
        $userMon2 = User::create(['email'=>'monitor2@hotmail.com', 'name'=>'Monitor2',
                        'password'=>Hash::make('password2')]);

        $userStaff1 = User::create(['email'=>'staff1@hotmail.com', 'name'=>'Staff1',
                        'password'=>Hash::make('password1')]);
        $userStaff2 = User::create(['email'=>'staff2@hotmail.com', 'name'=>'Staff2',
                        'password'=>Hash::make('password2')]);
        Sponsor::truncate();
        SponsorContact::truncate();
        // 30 Sponsors each has 2 contacts - to test pagination
        Sponsor::factory()->count(30)->hasContacts(2)->create();
        
        // Collect sponsor keys - first 2
        $sponsors = Sponsor::orderBy('name', 'asc')->limit(2)->get();
        // Sponsor security profiles
        SponsorProfilePermission::truncate();
        SponsorProfile::truncate();
        Protocol::truncate();
        ProtocolVisit::truncate();
        ProtocolVisitForm::truncate();
        Study::truncate();
        StudySite::truncate();
        Subject::truncate();
        SponsorUserProfile::truncate();
        StudyUserProfile::truncate();
        foreach ($sponsors as $sponsor) {
            // sponsor level - super user (full access)
            $pofileSuper = SponsorProfile::create(['sponsor_id'=> $sponsor->id, 
                            'name'=> 'Super User', 'description'=>'Sponsor admin']);
            // full access to each activity
            foreach (SecureModel::all() as $modelId=>$details) {
                SponsorProfilePermission::create([
                    'sponsor_profile_id' => $pofileSuper->id,
                    'secure_model_id' => $modelId,
                    'view'=> 1,
                    'update' => 1,
                    'delete' => 1,
                ]);
            }
            // Sponsor level super user profiles (access to sponsor/contacts, protocols, studies)
            SponsorUserProfile::create(['sponsor_id'=>$sponsor->id,  'user_id' => $userSponsor->id, 'sponsor_profile_id' =>$pofileSuper->id]);

            $pofileDoctor = SponsorProfile::create(['sponsor_id'=> $sponsor->id, 
                    'name'=> 'Doctor(Investigator) Profile', 'description'=>'Invstigator Access']);
            // doctor specific access
            foreach (SecureModel::all() as $modelId=>$modelDetails) {
                $activity = new SponsorProfilePermission();
                $activity->sponsor_profile_id = $pofileDoctor->id;
                $activity->secure_model_id = $modelId;
                switch ($modelId) {
                    case SecureModel::SUBJECT:
                    case SecureModel::SUBJECT_VISIT:
                    case SecureModel::SUBJECT_FORM_DATA:
                    case SecureModel::SUBJECT_FORM_MEDIA:
                    case SecureModel::SUBJECT_FORM_REPLY:
                    case SecureModel::SUBJECT_FORM_AUDIT:
                        $activity->view = 1;
                        $activity->update = 1;
                        $activity->delete = 1;
                        break;
                }
                $activity->save();
            }
            // staff - doctors assitant - read only version of doctor
            // Allowed clerical work: adding/changing subjects/visits
            // no medial work with subject (read and verify all for investigator)
            $pofileStaff = SponsorProfile::create(['sponsor_id'=> $sponsor->id, 
                    'name'=> 'Staff', 'description'=>'Staff']);
            foreach (SecureModel::all() as $modelId=>$modelDetails) {
                $activity = new SponsorProfilePermission();
                $activity->sponsor_profile_id = $pofileStaff->id;
                $activity->secure_model_id = $modelId;
                switch ($modelId) {
                    case SecureModel::SUBJECT: 
                    case SecureModel::SUBJECT_VISIT:
                        $activity->view = 1;
                        $activity->update = 1;
                        $activity->delete = 1;
                        break;
                    case SecureModel::SUBJECT_FORM_DATA:
                    case SecureModel::SUBJECT_FORM_MEDIA:
                    case SecureModel::SUBJECT_FORM_REPLY:
                    case SecureModel::SUBJECT_FORM_AUDIT:
                        $activity->view = 1;
                        break;
                }
                $activity->save();
            }

            // reviewer read-only access (can ask questions)
            $pofileReviewer = SponsorProfile::create(['sponsor_id'=> $sponsor->id, 
                    'name'=> 'Reviewer', 'description'=>'Reviewer']);
            foreach (SecureModel::all() as $modelId=>$modelDetails) {
                $activity = new SponsorProfilePermission();
                $activity->sponsor_profile_id = $pofileReviewer->id;
                $activity->secure_model_id = $modelId;
                switch ($modelId) {
                    case SecureModel::SUBJECT:
                    case SecureModel::SUBJECT_VISIT:
                    case SecureModel::SUBJECT_FORM_DATA:
                    case SecureModel::SUBJECT_FORM_MEDIA:
                    case SecureModel::SUBJECT_FORM_REPLY:
                    case SecureModel::SUBJECT_FORM_AUDIT:
                        $activity->view = 1;
                        break;
                    case SecureModel::SUBJECT_FORM_QUERY:
                    case SecureModel::SUBJECT_FORM_REVIEW:
                        $activity->view = 1;
                        $activity->update = 1;
                        $activity->delete = 1;
                        break;
                }
                $activity->save();
            }
            // monitor
            $pofileMonitor = SponsorProfile::create(['sponsor_id'=> $sponsor->id, 
                    'name'=> 'Monitor', 'description'=>'Monitor']);
            foreach (SecureModel::all() as $modelId=>$modelDetails) {
                $activity = new SponsorProfilePermission();
                $activity->sponsor_profile_id = $pofileMonitor->id;
                $activity->secure_model_id = $modelId;
                    switch ($modelId) {
                    case SecureModel::SUBJECT:
                    case SecureModel::SUBJECT_VISIT:
                    case SecureModel::SUBJECT_FORM_DATA:
                    case SecureModel::SUBJECT_FORM_MEDIA:
                    case SecureModel::SUBJECT_FORM_REPLY:
                    case SecureModel::SUBJECT_FORM_AUDIT:
                    case SecureModel::SUBJECT_FORM_QUERY:
                    case SecureModel::SUBJECT_FORM_REVIEW:
                        $activity->view = 1;
                        break;
                    case SecureModel::SUBJECT_FORM_MONITOR:
                        $activity->view = 1;
                        $activity->update = 1;
                        $activity->delete = 1;
                        break;
                }
                $activity->save();
            }
            // Protocols for sponsor
            $dtNow = new \DateTime('now');
            $protocol = Protocol::create(['sponsor_id'=> $sponsor->id, 
                'code'=> 'RVP-30-003', 'rev' => 3,
                'description'=>'Assess the Safety and Efficacy of RP5063 in Subjects with an Acute Exacerbation of Schizophrenia',
                'phase' => 'Phase-3', 'product' => 'RP5063 Tablets','drafted_at'=>$dtNow->format('m/d/Y')]);
            //-- Protocol Visit: 1
            $visit1 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>1, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Screening', 
                'description'=> 'First visit', 'ref_visit_id'=> null, 
                'range_start' => 0, 'range_end'=> 0, 'range_unit'=> VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 1 forms:2
            $form_count = 0;
            foreach (AdminForm::all() as $form) {
                if ($form_count < 2) {
                    ProtocolVisitForm::create(['visit_id'=>$visit1->id,
                        'form_id'=> $form['id'], 'order'=>$form_count+1, 'optional'=>0,
                        'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                    ]);
                    $form_count++;
                } else {
                    break;
                }
            }
            //-- Protocol Visit: 2 (7 days after first)
            $visit2 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>2, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Baseline Day 1 pre-dose', 
                'description'=> 'Second visit', 'ref_visit_id'=> $visit1->id, 
                'range_start' => 7, 'range_end'=> 7, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 2 forms: 6
            $form_count = 0;
            foreach (AdminForm::all() as $form) {
                if ($form_count < 6) {
                    ProtocolVisitForm::create(['visit_id'=>$visit2->id,
                        'form_id'=> $form['id'], 'order'=>$form_count+1, 'optional'=>0,
                        'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                    ]);
                    $form_count++;
                } else {
                    break;
                }
            }
            //-- Protocol Visit: 3 (post dose same day as visit 2)
            $visit3 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>3, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Day 1 Post-dose', 
                'description'=> 'Third visit', 'ref_visit_id'=> $visit2->id, 
                'range_start' => 0, 'range_end'=> 0, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 3 forms: 1(PANSS)
            ProtocolVisitForm::create(['visit_id'=>$visit3->id,
                'form_id'=> AdminForm::PANSS, 'order'=>1, 'optional'=>0,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            //-- Protocol Visit: 4 (day-8, fourth visit)
            $visit4 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>4, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Day 8', 
                'description'=> 'Fourth visit', 'ref_visit_id'=> $visit2->id,
                'range_start' => 7, 'range_end'=> 0, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 4 forms: (PANSS)
            $forms = [AdminForm::PANSS, AdminForm::CSSRS,AdminForm::CGI,AdminForm::NSA];
            $order = 1;
            foreach($forms  as $formID) {
                ProtocolVisitForm::create(['visit_id'=>$visit4->id,
                    'form_id'=> $formID, 'order'=>$order, 'optional'=>0,
                    'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                ]);
                $order++;
            }
            //-- Protocol Visit: 5 (day-15, fifth visit)
            $visit5 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>5, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Day 15', 
                'description'=> 'Fifth visit', 'ref_visit_id'=> $visit2->id,
                'range_start' => 14, 'range_end'=> 0, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 5 forms
            $forms = [AdminForm::MINI,AdminForm::PANSS, AdminForm::CSSRS,AdminForm::CGI];
            $order = 1;
            foreach($forms  as $formID) {
                ProtocolVisitForm::create(['visit_id'=>$visit5->id,
                    'form_id'=> $formID, 'order'=>$order, 'optional'=>0,
                    'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                ]);
                $order++;
            }
            //-- Protocol Visit: 6 (Day 21+2, Sixth visit),
            $visit6 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>6, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Day 21+2',
                'description'=> 'Sixth visit', 'ref_visit_id'=> $visit2->id,
                'range_start' => 20, 'range_end'=> 22, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 6 forms
            $forms = [AdminForm::PANSS, AdminForm::CSSRS, AdminForm::CGI,AdminForm::CDSS, AdminForm::NSA];
            $order = 1;
            foreach($forms  as $formID) {
                ProtocolVisitForm::create(['visit_id'=>$visit6->id,
                    'form_id'=> $formID, 'order'=>$order, 'optional'=>0,
                    'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                ]);
                $order++;
            }
            //-- Protocol Visit: 7 (Day 28+5(EOT), Seventh visit),
            $visit7 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>7, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Day 28+5',
                'description'=> 'Seventh visit', 'ref_visit_id'=> $visit2->id,
                'range_start' => 28, 'range_end'=> 33, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 7 forms
            $forms = [AdminForm::MINI,AdminForm::PANSS, AdminForm::CSSRS, AdminForm::CGI,AdminForm::CDSS];
            $order = 1;
            foreach($forms  as $formID) {
                ProtocolVisitForm::create(['visit_id'=>$visit7->id,
                    'form_id'=> $formID, 'order'=>$order, 'optional'=>0,
                    'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                ]);
                $order++;
            }
            //-- Protocol Visit: 8 (Day 42-+5(EOS), Eighth visit
            $visit8 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>8, 'visit_type'=> VisitType::PROTOCOL, 'name'=>'Day 42-+5',
                'description'=> 'Eighth visit', 'ref_visit_id'=> $visit2->id,
                'range_start' => 37, 'range_end'=> 47, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 8 forms
            $forms = [AdminForm::MINI,AdminForm::PANSS];
            $order = 1;
            foreach($forms  as $formID) {
                ProtocolVisitForm::create(['visit_id'=>$visit8->id,
                    'form_id'=> $formID, 'order'=>$order, 'optional'=>0,
                    'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                ]);
                $order++;
            }
            //-- Protocol Visit: 9 (Subject Closure, period unknown - can happen anytime)
            $visit9 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>9, 'visit_type'=> VisitType::CLOSURE, 'name'=>'Subject Closure',
                'description'=> 'Unknown', 'ref_visit_id'=> $visit2->id,
                'range_start' => 0, 'range_end'=> 0, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 9 forms
            $forms = [AdminForm::CLOSURE];
            ProtocolVisitForm::create(['visit_id'=>$visit9->id,
                'form_id'=> AdminForm::CLOSURE, 'order'=>$order, 'optional'=>0,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            //-- Protocol Visit: 10 (Unplanned/emergency, could happen anytime)
            $visit10 = ProtocolVisit::create(['protocol_id'=>$protocol->id, 
                'order'=>10, 'visit_type'=> VisitType::UNPLANNED, 'name'=>'Unplanned',
                'description'=> 'Unknown', 'ref_visit_id'=> $visit2->id,
                'range_start' => 0, 'range_end'=> 0, 'range_unit'=>VisitRangeUnit::DAY,
                'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // visit: 10 forms. All forms as optional
            $forms = [AdminForm::MINI,AdminForm::PANSS, AdminForm::CSSRS, AdminForm::CGI,AdminForm::CDSS];
            $order = 1;
            foreach($forms  as $formID) {
                ProtocolVisitForm::create(['visit_id'=>$visit10->id,
                    'form_id'=> $formID, 'order'=>$order, 'optional'=>1,
                    'created_at'=> time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
                ]);
                $order++;
            }
            // study
            $dt = new \DateTime('now');
            $dt->add(new \DateInterval('P1Y'));
            $study = Study::create(['protocol_id'=>$protocol->id, 'status_id'=>StudyStatus::ACTIVE,
                'name'=> 'RVP30-001','code'=>'RVP30-001', 'num'=>$protocol->id,
                'description'=>'Double blinded study for CNS',
                'start_at'=>time(), 'end_at'=> $dt->getTimestamp(), 
                'created_at'=>time(), 'created_by'=>null, 'updated_at'=>time(), 'updated_by'=>null
            ]);
            // study sites.
            $site1 = StudySite::create(['study_id'=>$study->id, 'code'=>'BLR',
                'name'=> 'BLR-PSY-01', 'department'=>'PSY', 
                'address'=> '1010 Outer Ring Road', 
                'city'=>'Bangalore', 'state'=>'Karnataka', 'country'=>'India',
                'contact'=> 'Dr. VS', 'phone'=>'+91-80-345-7868', 'email'=> 'psy@gmail.com'
            ]);
            $site2 = StudySite::create(['study_id'=>$study->id, 'code'=>'PUNE',
                'name'=> 'PUNE-JM-01', 'department'=>'PSY', 
                'address'=> '111 MG Road', 'city'=>'Pune', 'state'=>'Maharashtra', 'country'=>'India',
                'contact'=> 'Dr. B Goel', 'phone'=>'+91-70-365-7068', 'email'=> 'bgoel@gmail.com'
                ]);
            // Doctor
            StudyUserProfile::create(['user_id' => $userDoc1->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileDoctor->id]);
            StudyUserProfile::create(['user_id' => $userDoc2->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileDoctor->id]);
            // Staff
            StudyUserProfile::create(['user_id' => $userStaff1->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileStaff->id]);
            StudyUserProfile::create(['user_id' => $userStaff2->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileStaff->id]);

            // Monitor
            StudyUserProfile::create(['user_id' => $userMon1->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileMonitor->id]);
            StudyUserProfile::create(['user_id' => $userMon2->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileMonitor->id]);
            // Reviewer
            StudyUserProfile::create(['user_id' => $userRev1->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileReviewer->id]);
            StudyUserProfile::create(['user_id' => $userRev2->id,'study_id'=>$study->id, 'sponsor_profile_id' =>$pofileReviewer->id]);

        } // for-each sponsor
    } // end-run
}
