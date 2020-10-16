<?php

namespace Database\Seeders;

use Database\Factories\ImmobileFactory;
use Illuminate\Database\Seeder;

class ImmobilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImmobileFactory::times(10)->create();
    }
}
