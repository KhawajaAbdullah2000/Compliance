<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class QualitativeAssetRiskSourcesGLobal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('qualitative_asset_based_risk_sources')->insert([
        [ 'global_risk_source' => 'Cyber terrorists, cyber militias'],
        [ 'global_risk_source' => 'Cyber-hacktivists, interest groups, sects'],
        [ 'global_risk_source' => 'Cyber-mercenary” profile with IT capacities that are generally high from a technical standpoint'],
        [ 'global_risk_source' => 'Script kiddies with the capacity of use the attack kits that are available online'],
        [ 'global_risk_source' => 'Attacker with motivations of acute vengeance or a feeling of injustice (e.g. employee dismissed for serious fault, discontented service provider following a contract that was not renewed, etc.)'],
        [ 'global_risk_source' => 'Pathological attacker e.g. unfair competitor, dishonest client, scammer, and fraudster.']


        ]);
    }
    
}
