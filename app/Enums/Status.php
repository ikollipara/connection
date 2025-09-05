<?php

declare(strict_types=1);

namespace App\Enums;

use App\Attributes\Legacy;
use Spatie\Enum\Laravel\Enum;

/**
 * \App\Enums\Status
 *
 * @method static self draft()
 * @method static self published()
 * @method static self archived()
 */
#[Legacy()]
class Status extends Enum {}
