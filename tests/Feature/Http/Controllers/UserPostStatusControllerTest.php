<?php

use App\Enums\Status;
use App\Http\Controllers\UserPostStatusController;
use App\Models\Post;
use App\Models\User;

use function Pest\Laravel\delete;

covers(UserPostStatusController::class);


it('should update the given post\'s status to ', function (string $startingState, Status $status) {
    $user = User::factory()->createOne();
    $post = Post::factory()->{$startingState}()->createOne();
    delete(route('users.posts.status', [$user, $post]), [
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
    $post = Post::factory()->published()->createOne();
    delete(route('users.posts.status', [$user, $post]), [
        'status' => Status::draft(),
    ])->assertRedirect()->assertSessionHas('error');
});
