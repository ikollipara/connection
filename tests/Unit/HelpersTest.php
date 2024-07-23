<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function test_literal_helper()
    {
        $name = "John Doe";
        $email = "john.doe@example.com";
        $literal = literal([
            "name" => $name,
            "email" => $email,
        ]);

        $this->assertIsObject($literal);
        $this->assertObjectHasProperty("name", $literal);
        $this->assertObjectHasProperty("email", $literal);
    }
}
