<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialization::create(['name' => 'Infra-Réseau', 'description' => 'Infrastructure réseau et sécurité.']);
        Specialization::create(['name' => 'Développement informatique', 'description' => 'Programmation et développement web.']);
        Specialization::create(['name' => 'Marketing digital', 'description' => 'Stratégies de marketing en ligne.']);
    }
}

