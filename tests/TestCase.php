<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
<<<<<<< HEAD
    use RefreshDatabase;
    use CreatesApplication;


    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }
}
=======
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }
    use RefreshDatabase;
    use CreatesApplication;
}
>>>>>>> c903443f5b5e73474feb59d6aeb29937b8eb974c
