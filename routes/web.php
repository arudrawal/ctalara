<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Sponsor\SponsorController;
use App\Http\Controllers\Sponsor\ContactController;
use App\Http\Controllers\Protocol\ProtocolController;
use App\Http\Controllers\Study\StudyController;
use App\Http\Controllers\Profile\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Test routes
Route::get('/welcome', function () {return view('welcome');	})->name('welcome');
Route::get('/keen', function () {return view('index');})->name('keen');

Route::middleware('auth')->group(function () {

	// Sponsor (General add/delete by sofwtare admin)
	Route::get('/sponsor/index', [SponsorController::class, 'index'])
			->name('sponsor.index');
	Route::post('/sponsor/select', [SponsorController::class, 'select'])
			->name('sponsor.select');
	
	// Specific sponsor: contacts (by sponsor admin) + edit sponsor
	Route::get('/contact/index', [ContactController::class, 'index'])
			->name('contact.index');

	// Protocols
	Route::get('/protocol/index', [ProtocolController::class, 'index'])
			->name('protocol.index');
	Route::get('/protocol/visit/index', [ProtocolController::class, 'visitIndex'])
			->name('protocol.visit.index');
	// Study
	Route::get('/study/index', [StudyController::class, 'index'])
			->name('study.index');
	// Security Profile
	Route::get('/profile/index', [ProfileController::class, 'index'])
			->name('profile.index');
	
	// Security Profile Sponsor Admin Assignment
	Route::get('/profile/admin/index', [ProfileController::class, 'profileAdminIndex'])
			->name('profile.admin.index');

	// Security Profile Study User Assignment
	Route::get('/profile/users/index', [ProfileController::class, 'profileUserIndex'])
			->name('profile.user.index');

	// USER ROUTES
	// User Home (dashboard with alerts and pending items on schedule)
	Route::get('/home', [UserController::class, 'homeIndex'])->name('user.home');
	Route::post('/user/sponsor/select', [UserController::class, 'sponsorSelect'])->name('user.sponsor.select');

	// User Study: all studies user has access to - select only
	Route::get('/user/study/index', [UserController::class, 'studyIndex'])
			->name('user.study.index');
	Route::post('/user/study/select/', [UserController::class, 'studySelect'])
			->name('user.study.select');

	// User Study/Sites: all sites within a study user has access to (select site)
	Route::get('/user/site/index', [UserController::class, 'siteIndex'])
			->name('user.site.index');
	Route::post('/user/site/select', [UserController::class, 'siteSelect'])->name('user.site.select');

	// User Study/Site/Subjects: all subjects within a site user has access to (select subject)
	Route::get('/user/subject/index', [UserController::class, 'subjectIndex'])
			->name('user.subject.index');
	Route::post('/user/subject/select', [UserController::class, 'subjectSelect'])->name('user.subject.select');

	// User Study/Site/Subjects/Visits: all subject-visits user has access to (select visit)
	Route::get('/user/visit/index', [UserController::class, 'visitIndex'])
			->name('user.subject.visit.index');
	Route::post('/user/subject/visit/select', [UserController::class, 'subjectVisitSelect'])->name('user.subject.visit.select');

	// User Study/Site/Subjects/Visit/Forms: subject-visit-forms user has access to (select form)
	Route::get('/user/subject/form/index', [UserController::class, 'subjectFormIndex'])
			->name('user.subject.visit.form.index');
	Route::post('/user/subject/visit/form/select', [UserController::class, 'subjectVisitFormSelect'])
		->name('user.subject.visit.form.select');
	
	// User Study/Site/Subjects/Visit/Form/Data: subject-visit-form-data (view/update form content)
	Route::get('/user/subjec/data/index', [UserController::class, 'subjectFormDataIndex'])
			->name('user.subject.visit.form.data.index');
});

require __DIR__.'/auth.php';
