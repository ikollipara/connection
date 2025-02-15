<?php

use App\Enums\Status;
use App\Http\Controllers\UserContentCollectionStatusController;
use App\Models\ContentCollection;
use App\Models\User;

use function Pest\Laravel\delete;

covers(UserContentCollectionStatusController::class);


it('should update the given ContentCollection\'s status to ', function (string $startingState, Status $status) {
    $user = User::factory()->createOne();
    $collection = ContentCollection::factory()->{$startingState}()->createOne();
    delete(route('users.collections.status', [$user, $collection]), [
        'status' => $status,
    ])->assertRedirect()->assertSessionHas('success');
})->with([
    'draft/published' => ['draft', Status::published()],
    'published/published' => ['published', Status::published()],
    'draft/archived' => ['draft', Status::archived()],
    'published/archived' => ['published', Status::archived()],
]);


it('should fail to set status back to draft', function () {
    $user = User::factory()->createOne();
    $collection = ContentCollection::factory()->published()->createOne();
    delete(route('users.collections.status', [$user, $collection]), [
        'status' => Status::draft(),
    ])->assertRedirect()->assertSessionHas('error');
});
