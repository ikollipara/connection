<?php

use App\Enums\Standard;
use App\Enums\StandardGroup;

covers(Standard::class);

it('should get all valid groups', function (StandardGroup $group) {
    expect(Standard::getGroup($group))->not->toBeEmpty();
})->with(StandardGroup::cases());
