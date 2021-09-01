<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Sponsor\SponsorApiController;
use App\Http\Controllers\Sponsor\SponsorContactApiController;
use App\Http\Controllers\Protocol\ProtocolApiController;
use App\Http\Controllers\Protocol\ProtocolVisitApiController;
use App\Http\Controllers\Study\StudyApiController;
use App\Http\Controllers\Profile\ProfileApiController;
use App\Http\Controllers\Profile\ProfileUserApiController;
use App\Http\Controllers\Profile\ProfileAdminApiController;
use App\Http\Controllers\User\UserApiController;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// unprotecetd 
Route::post('/register', [ApiAuthController::class, 'apiRegister']);
Route::post('/login', [ApiAuthController::class, 'apiLogin']);

// Protecetd: from web/curl (??web: allow Ajax if valid session??)
Route::middleware('auth:sanctum')->group(function () {
    // Retrieve user who created the token through API.
    Route::get('/user/tokenable', function (Request $request) {
        //$user = $request->user(); // does not work for pure API with curl
        $token = $request->bearerToken();
        $tokenModel = PersonalAccessToken::findToken($token);
        $user = User::where('id', $tokenModel->tokenable_id)->first();
        $respData = ['status' => 'Success', 'message' => 'token owner', 'token'=>$token,
            'user_id' => $tokenModel->tokenable_id, 'email' => $user->email];
        return response()->json($respData, 200);
    });

    // Software Admin
    Route::get('/sponsor/index', [SponsorApiController::class, 'index']);
    Route::post('/sponsor/create', [SponsorApiController::class, 'create'])->name('api.sponsor.create');
    Route::post('/sponsor/delete', [SponsorApiController::class, 'delete'])->name('api.sponsor.delete');
    
    // Sponsor contact (by sponsor admin)
    Route::get('/sponsor/contact/index/{sponsor_id}', [SponsorContactApiController::class, 'index']);
    Route::post('/sponsor/contact/create', [SponsorContactApiController::class, 'create']);
    Route::post('/sponsor/contact/edit', [SponsorContactApiController::class, 'create']);
    Route::post('/sponsor/contact/delete', [SponsorContactApiController::class, 'delete']);
    
    // Protocol
    Route::get('/protocol/index/{sponsor_id}', [ProtocolApiController::class, 'index']);
    Route::post('/protocol/create', [ProtocolApiController::class, 'create'])->name('protocol.create');
    Route::post('/protocol/delete', [ProtocolApiController::class, 'delete'])->name('protocol.delete');
    // Protocol Visits
    Route::get('/protocol/visit/index/{protocol_id}', [ProtocolVisitApiController::class, 'index']);
    
    // Studies
    Route::get('/study/index/{sponsor_id}', [StudyApiController::class, 'index']);
    
    // Security Profiles
    Route::get('/profile/index', [ProfileApiController::class, 'index']);
    Route::get('/profile/user/index/{study_id}', [ProfileUserApiController::class, 'index']);
    Route::get('/profile/admin/index', [ProfileAdminApiController::class, 'index']);
    
    //// USER ////
    // User Sponsor
    Route::get('/user/sponsor/index', [UserApiController::class, 'indexSponsor']);
    
    // User study
    Route::get('/user/study/index/{sponsor_id}', [UserApiController::class, 'indexStudy']);
    // User study/sites
    Route::get('/user/site/index/{study_id}', [UserApiController::class, 'indexSite']);
    // User study/subjects - can be filtered by site
    Route::get('/user/subject/index/{study_id}', [UserApiController::class, 'indexSubject']);
    Route::post('/user/subject/create', [UserApiController::class, 'subjectCreate']);
    
    // User study/subject/visits
    Route::get('/user/subject/visit/index/{subject_id}', [UserApiController::class, 'indexSubjectVisit']);
    // User study/subject/visit/forms
    Route::get('/user/subject/visit/form/index/{visit_id}', [UserApiController::class, 'indexSubjectVisitForm']);

});

# auth:api=> cuases problems (should be auth:sanctum)
//Route::middleware('auth:api')->get('/api/user', function (Request $request) {
//    return $request->user();
//});


