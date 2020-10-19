<?php

namespace Database\Seeders;

use Database\Factories\ContractFactory;
use Illuminate\Database\Seeder;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractFactory::times(50)
            ->with_immobile()
            ->create();

        ContractFactory::times(50)
            ->with_immobile()
            ->document_entity()
            ->create();
    }
}
