<?php

declare(strict_types=1);

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
use InvalidArgumentException;

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
            ! is_null($this->user->yearly_survey_sent_at) and
            $this->user->yearly_survey_sent_at->diffInYears(now()) < 1
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

    /**
     *
     * @param self::CT_CAST|self::SCALES $survey_type
     * @return string
     */
    private function buildUrl($survey_type): string
    {
        return match ($survey_type) {
            self::SCALES => "https://unlcorexmuw.qualtrics.com/jfe/form/SV_9srNvEgI4qtTNYO?userId={$this->user->id}",
            self::CT_CAST => "https://unlcorexmuw.qualtrics.com/jfe/form/SV_77fiKxeee2WFRVs?userId={$this->user->id}",
        };
    }
}
