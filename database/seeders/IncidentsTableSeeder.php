<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;

class IncidentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Incident::create([
        	'title' => 'Incidencia por defecto',
        	'description' => 'Incidencia por defecto',
        	'severity' => 'N',

        	'category_id' => 2,
        	'project_id' => 1,
        	'level_id' => 1,

        	'client_id' => 2,
        	'support_id' => 3
    	]);
    }
}
