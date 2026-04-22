<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $zones = [
            'Cotonou Centre',
            'Cotonou Nord (Akpakpa)',
            'Cotonou Sud (Cadjehoun)',
            'Porto-Novo',
            'Abomey-Calavi',
            'Parakou',
            'Bohicon',
            'Ouidah',
            'Natitingou',
            'Djougou',
            'Kandi',
            'Malanville',
            'Bénin entier',
            'International (Togo, Nigeria, Niger)',
        ];

        foreach ($zones as $name) {
            Zone::updateOrCreate(['name' => $name]);
        }

        $this->command->info('✅ ' . count($zones) . ' zones créées avec succès.');
    }
}
