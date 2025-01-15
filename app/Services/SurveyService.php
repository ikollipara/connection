<?php

/**
 * |=============================================================================|
 * | SurveyService.php                                                           |
 * |-----------------------------------------------------------------------------|
 * | This file contains the SurveyService class. This class is used to provide   |
 * | methods sending surveys.                                                    |
 * |=============================================================================| */

namespace App\Services;

use App\Mail\Survey;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SurveyService
{
    public const CT_CAST = 'CT_CAST';

    public const SCALES = 'SCALES';

    public const ONCE = 1;

    public const YEARLY = 2;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function sendSurvey(array $survey_types, int $frequency)
    {
        $this->validateArgs($survey_types, $frequency);
        $urls = collect($survey_types)->map(
            fn($survey_type) => $this->buildUrl($survey_type),
        );
        $this->user->created_at ??= now();
        if ($frequency === static::ONCE) {
            $this->handleOnce($urls);
        }
        if ($frequency === static::YEARLY) {
            $this->handleYearly($urls);
        }

        return $this;
    }

    private function handleOnce(Collection $urls)
    {
        if ($this->user->sent_week_one_survey) {
            return;
        }
        $urls->each(fn($url) => Mail::to($this->user)->queue(new Survey($url)));
        $this->user->sent_week_one_survey = true;
        $this->user->save();
    }

    private function handleYearly(Collection $urls)
    {
        if (
            $this->user->yearly_survey_sent_at and
            $this->user->yearly_survey_sent_at->diffInYears(now()) === 0
        ) {
            return;
        }
        $urls->each(fn($url) => Mail::to($this->user)->queue(new Survey($url)));
        $this->user->yearly_survey_sent_at = now();
        $this->user->save();
    }

    private function validateArgs(array $survey_types, int $frequency)
    {
        if (! in_array($frequency, [static::ONCE, static::YEARLY])) {
            throw new \InvalidArgumentException(
                'Invalid frequency, must be one of: SurveyService::ONCE, SurveyService::YEARLY, SurveyService::BIYEARLY',
            );
        }
        if (
            ! collect($survey_types)
                ->map(
                    fn($survey_type) => in_array($survey_type, [
                        static::CT_CAST,
                        static::SCALES,
                    ]),
                )
                ->reduce(fn($carry, $item) => $carry && $item, true)
        ) {
            throw new \InvalidArgumentException(
                'Invalid survey type, must be one of: SurveyService::CT_CAST, SurveyService::SCALES',
            );
        }
    }

    private function buildUrl(string $survey_type): string
    {
        if ($survey_type == static::CT_CAST) {
            return "https://unlcorexmuw.qualtrics.com/jfe/form/SV_77fiKxeee2WFRVs?userId={$this->user->id}";
        } elseif ($survey_type == static::SCALES) {
            return "https://unlcorexmuw.qualtrics.com/jfe/form/SV_9srNvEgI4qtTNYO?userId={$this->user->id}";
        }
    }
}
