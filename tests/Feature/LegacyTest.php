<?php

use App\Attributes\Legacy;

arch('Legacy code')->expect('App')->not->toHaveAttribute(Legacy::class, "Marked as Legacy");
