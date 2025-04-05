<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualitativeAssetTargetObjectRiskSource extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('qualitative_asset_global_target_object_risk_source')->insert([
            [ 'target_objective' => 'Spying','description'=>'Intelligence operation (state-related, economic). In many cases, the attacker aims for a long-term installation in the information system and with total discretion. Weaponry, space, aeronautics, the pharmaceutical sector, energy and certain activities of the State (economics, finance, and foreign affairs) are privileged targets.'],

            ['target_objective' => 'Strategic pre-positioning','description'=>'Pre-positioning generally aimed at an attack over the long term, without the end purpose being clearly established (e.g. compromising telecom operator networks, infiltration of mass information internet sites in order to launch an operation of political or economic influence with a strong echo). Sudden and massive compromising of computers in order to form a botnet can be affiliated with this category.'],

            ['target_objective' => 'Influence','description'=>'Operation aimed at diffusing false information or at altering it, mobilizing opinion leaders on the social networks, destroying reputations, disclosing confidential information, degrading the image of an organization or of a State. The end purpose is generally to destabilize or modify perceptions.'],

            ['target_objective' => 'Obstacle to functioning','description'=>'Sabotage operation aimed for example at making an internet site unavailable, causing information saturation, preventing the use of a digital resource, making a physical installation unavailable. Industrial systems can be particularly exposed and vulnerable through IT networks with which they are interconnected (e.g. sending commands in order to generate hardware damage or a breakdown requiring extensive maintenance). Distributed Denial-of-Service attacks (DDoS) are commonly used techniques for neutralizing digital resources.'],

            
            ['target_objective' => 'Lucrative','description'=>'Operation aiming for a financial gain, either directly or indirectly. Generally linked to organized crime, mention can be made of: fraud on the internet, money laundering, extortion or embezzlement, financial market manipulation, forgery of administrative documents, identity theft, etc.
            Certain operations for profit can make use of a method of attack that is part of the categories hereinabove (e.g. spying and data theft, ransomware in order to neutralize an activity) but the end purpose remains financial.'],

            ['target_objective' => 'Challenge, fun','description'=>'Operation aimed at fulfilling an exploit for the purposes of social recognition, challenge or simply for fun. Although the objective is primarily for fun and without any particular desire to harm, this type of operation can have serious consequences for the victim.']




        ]);
    }
}
