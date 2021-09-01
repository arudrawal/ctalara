<?php

namespace App\Providers;

use App\Models\Sponsor;
use App\Models\Study;
use App\Models\StudySite;
use App\Models\Subject;
use App\Models\SubjectVisit;
use App\Models\SubjectVisitForm;

use App\Services\SessionVars;

use App\Constants\AdminForm;
use App\Constants\FormStatus;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Session Variable setting interface bound to concrete SessionVars class
        $this->app->bind(App\Services\SessionVars::class, function ($app) {
          return new App\Services\SessionVars();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // session is initialized by middleware after boot
      // set view composer or creator for global data share.
      // die(var_dump(session('email')));
      
      /*View::composer('*', function ($view) {
        View::share('authUser', Auth::user());
      });*/
      View::creator('*', function ($view) {
        //share the data across multiple views
        // current route name - to highlight proper menu item
        View::share('curRouteName', Route::currentRouteName());

        View::share('authUser', Auth::user());
        $sponsors = Sponsor::all();
        View::share('sponsors', $sponsors);
        // Session Spopnsor
        $selected_sponser_id = session('sponsor_id', 0);
        if ($selected_sponser_id) {
          //$sponsor = Sponsor::where('id', '=', $selected_sponser_id)->first();
          $sponsor = $sponsors->firstWhere('id', $selected_sponser_id);
        } else {
          $sponsor = new Sponsor(); // empty
        }
        View::share('selectedSponsor', $sponsor);
        
        // Session Study
        $selected_study_id = session('study_id', 0);
        if ($selected_study_id) {
          $study = Study::where('id', '=', $selected_study_id)->first();
        } else {
          $study = new Study(); // empty
        }
        View::share('selectedStudy', $study);
        // Session Study/Site
        $selected_site_id = session('site_id', 0);
        if ($selected_site_id) {
          $studySite = StudySite::where('id', '=', $selected_site_id)->first();
        } else {
          $studySite = new StudySite(); // empty
        }
        View::share('selectedSite', $studySite);
        // Session Subject
        $selected_subject_id = session('subject_id', 0);
        if ($selected_subject_id) {
          $subject = Subject::where('id', '=', $selected_subject_id)->first();
        } else {
          $subject = new Subject(); // empty
        }
        View::share('selectedSubject', $subject);
        // Session Subject Visit
        $selected_subject_visit_id = session('subject_visit_id', 0);
        if ($selected_subject_visit_id) {
          $subjectVisit = SubjectVisit::where('id', '=', $selected_subject_visit_id)->first();
        } else {
          $subjectVisit = new SubjectVisit(); // empty
        }
        View::share('selectedSubjectVisit', $subjectVisit);
        // Session Subject Visit Form
        $selected_subject_visit_form_id = session('subject_visit_form_id', 0);
        if ($selected_subject_visit_form_id) {
          $subjectVisitForm = SubjectVisitForm::where('id', '=', $selected_subject_visit_form_id)->first();
        } else {
          $subjectVisitForm = new SubjectVisitForm(); // empty
        }
        View::share('selectedSubjectVisitForm', $subjectVisitForm);


        // share constants with javascript
        View::share('jsonForms', AdminForm::FORMS);
        View::share('jsonFormStatus', FormStatus::FORM_STATUS);
      });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
          App\Services\SessionVars::class,
        ];
    }
}
