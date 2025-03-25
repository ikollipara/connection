<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

interface Viewable
{
    public function views(): int;

    public function isViewedBy(User $user): bool;

    public function view(User $user): void;
}
