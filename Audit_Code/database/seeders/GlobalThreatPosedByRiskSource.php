<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalThreatPosedByRiskSource extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('global_threat_posed_by_risk_source')->insert([
            ['global_threat_posed' => 'Physical Threats'],
            ['global_threat_posed' => 'Natural Threats'],
            ['global_threat_posed' => 'Infrastructure Failures'],
            ['global_threat_posed' => 'Technical Failures'],
            ['global_threat_posed' => 'Human Actions'],
            ['global_threat_posed' => 'Service Compromise'],
            ['global_threat_posed' => 'Organizational Threats'],
           
          
        ]);
    }
}
