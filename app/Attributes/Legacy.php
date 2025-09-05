<?php

namespace App\Attributes;

//------------------------------
// File:        Legacy.php
// Author:      Ian Kollipara
// Created:     2025-09-05
// Description: Legacy Attribute for
//.             Searching and notifying
//------------------------------

#[\Attribute]
class Legacy {

    public function __construct(public string $notice = "")
    {

    }
}
