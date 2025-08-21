<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClosuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtenir la date d'aujourd'hui en utilisant Carbon
        $startDate = Carbon::now()->toDateString();
        
        // Calculer la date de fin en ajoutant 30 jours
        $endDate = Carbon::now()->addDays(30)->toDateString();

        // Insérer un enregistrement dans la table 'closures'
        DB::table('closures')->insert([
            'starting_date' => $startDate,
            'ending_date' => $endDate,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
