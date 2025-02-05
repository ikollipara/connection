<?php

use App\Enums\StandardGroup;

covers(StandardGroup::class);


it('should validate values', function (StandardGroup $group) {
    expect($group->value)->not->toContain("_");
})->with(StandardGroup::cases());

it('should have valid labels', function () {
    expect(StandardGroup::toLabels())
        ->not->toBeEmpty();
});
