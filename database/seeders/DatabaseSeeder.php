<?php

namespace Database\Seeders;

use App\Models\Signature;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Signature::factory()
            ->times(10000)
            ->create();
    }
}
