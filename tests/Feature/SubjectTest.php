<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Study;
use App\Models\Subject;
use app\Models\Protocol;
use app\Models\ProtocolVisit;
use app\Models\ProtocolVisitForm;
use app\Models\SubjectVisit;
use app\Models\SubjectVisitForm;
use App\Services\SubjectEnrollment;

use Tests\TestCase;

class SubjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        /*$user = User::where('email', '=', 'ajay@hotmail.com')->first();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/user/subject/index');
        $response->assertStatus(200);*/

        $studyID = 1; $subjectID = 1;
        $study = Study::where('id', '=', $studyID)->first();
        $subject = Subject::where('id', '=', $subjectID)->first();
        SubjectEnrollment::addProtocolVisitForms($subject, $study);
    }
}
