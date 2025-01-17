<?php

namespace Tests\Feature\Services;

use App\Mail\Survey;
use App\Models\User;
use App\Services\SurveyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Tests\TestCase;

class SurveyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_survey_once()
    {
        Mail::fake();
        $user = User::factory()->create();
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::ONCE,
        );
        $this->assertTrue($user->sent_week_one_survey);
        Mail::assertQueued(Survey::class);
    }

    public function test_send_survey_yearly()
    {
        Mail::fake();
        $user = User::factory()->create([
            'created_at' => now()->subYears(2),
        ]);
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::YEARLY,
        );
        $this->assertNotNull($user->yearly_survey_sent_at);
        Mail::assertQueued(Survey::class);
    }

    public function test_send_survey_once_twice()
    {
        Mail::fake();
        $user = User::factory()->create();
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::ONCE,
        );
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::ONCE,
        );
        $this->assertTrue($user->sent_week_one_survey);
        Mail::assertQueued(Survey::class, 1);
    }

    public function test_send_survey_yearly_twice()
    {
        Mail::fake();
        $user = User::factory()->create([
            'created_at' => now()->subYears(2),
        ]);
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::YEARLY,
        );
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::YEARLY,
        );
        $this->assertNotNull($user->yearly_survey_sent_at);
        Mail::assertQueued(Survey::class, 1);
    }

    public function test_send_multiple_surveys()
    {
        Mail::fake();
        $user = User::factory()->create();
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST],
            SurveyService::ONCE,
        );
        $surveyService->sendSurvey(
            [SurveyService::CT_CAST, SurveyService::SCALES],
            SurveyService::YEARLY,
        );
        $this->assertTrue($user->sent_week_one_survey);
        $this->assertNotNull($user->yearly_survey_sent_at);
        Mail::assertQueued(Survey::class, 3);
    }

    public function test_send_survey_invalid_frequency()
    {
        $this->expectExceptionMessage('Invalid frequency');
        $user = User::factory()->create();
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey([SurveyService::CT_CAST], 3);
    }

    public function test_send_survey_invalid_survey_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $user = User::factory()->create();
        $surveyService = new SurveyService($user);
        $surveyService->sendSurvey(['invalid'], SurveyService::ONCE);
    }
}
