<?php

pest()->group('arch');

arch('PHP Preset')->preset()->php();
arch('Laravel Preset')->preset()->laravel();
arch('Security Preset')->preset()->security();
arch('Relaxed Preset')->preset()->relaxed();
