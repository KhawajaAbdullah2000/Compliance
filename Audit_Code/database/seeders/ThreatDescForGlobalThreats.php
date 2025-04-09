<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThreatDescForGlobalThreats extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('threat_desc_for_global_threats')->insert([
            ['global_threat' => 1,'threat_description'=>'Fire'],
            ['global_threat' => 1,'threat_description'=>'Water'],
            ['global_threat' => 1,'threat_description'=>'Pollution'],
            ['global_threat' => 1,'threat_description'=>'Harmful Radiation'],
            ['global_threat' => 1,'threat_description'=>'Major Accident'],
            ['global_threat' => 1,'threat_description'=>'Dust'],
            ['global_threat' => 1,'threat_description'=>'Corrosion'],
            ['global_threat' => 1,'threat_description'=>'Freezing'],

            ['global_threat' => 2,'threat_description'=>'Climatic phenomenon'],
            ['global_threat' => 2,'threat_description'=>'Seismic phenomenon'],
            ['global_threat' => 2,'threat_description'=>'Volcanic phenomenon'],
            ['global_threat' => 2,'threat_description'=>'Meteorological phenomenon'],
            ['global_threat' => 2,'threat_description'=>'Flood'],
            ['global_threat' => 2,'threat_description'=>'Pandemic'],
            ['global_threat' => 2,'threat_description'=>'Epidemic phenomenon'],

            ['global_threat' => 3,'threat_description'=>'Failure of a vupply vystem'],
            ['global_threat' => 3,'threat_description'=>'Failure of cooling or ventilation System'],
            ['global_threat' => 3,'threat_description'=>'Loss of power supply'],
            ['global_threat' => 3,'threat_description'=>'Failure of a telecommunications network'],
            ['global_threat' => 3,'threat_description'=>'Failure of a telecommunication equipment'],
            ['global_threat' => 3,'threat_description'=>'Electromagnetic radiation'],
            ['global_threat' => 3,'threat_description'=>'Thermal radiation'],
            ['global_threat' => 3,'threat_description'=>'Electromagnetic pulses'],

            ['global_threat' => 4,'threat_description'=>'Failure of device or system'],
            ['global_threat' => 4,'threat_description'=>'Saturation of the information system'],
            ['global_threat' => 4,'threat_description'=>'Violation of the information system maintainability'],

            ['global_threat' => 5,'threat_description'=>'Terror'],
            ['global_threat' => 5, 'threat_description' => 'Attack'],
            ['global_threat' => 5, 'threat_description' => 'Sabotage'],
            ['global_threat' => 5, 'threat_description' => 'Social Engineering'],
            ['global_threat' => 5, 'threat_description' => 'Interception of radiation of a device'],
            ['global_threat' => 5, 'threat_description' => 'Remote spying'],
            ['global_threat' => 5, 'threat_description' => 'Eavesdropping'],
            ['global_threat' => 5, 'threat_description' => 'Theft of media or documents'],
            ['global_threat' => 5, 'threat_description' => 'Theft of equipment'],
            ['global_threat' => 5, 'threat_description' => 'Theft of digital identity or credentials'],
            ['global_threat' => 5, 'threat_description' => 'Retrieval of recycled or discarded media'],
            ['global_threat' => 5, 'threat_description' => 'Disclosure of information'],
            ['global_threat' => 5, 'threat_description' => 'Data input from untrustworthy sources'],
            ['global_threat' => 5, 'threat_description' => 'Tampering with hardware'],
            ['global_threat' => 5, 'threat_description' => 'Tampering with software'],
            ['global_threat' => 5, 'threat_description' => 'Drive-by-exploits using web-based communication'],
            ['global_threat' => 5, 'threat_description' => 'Replay attack'],
            ['global_threat' => 5, 'threat_description' => 'Man-in-the-middle attack'],
            ['global_threat' => 5, 'threat_description' => 'Unauthorized processing of personal data'],
            ['global_threat' => 5, 'threat_description' => 'Unauthorized entry to facilities'],
            ['global_threat' => 5, 'threat_description' => 'Unauthorized use of devices'],
            ['global_threat' => 5, 'threat_description' => 'Incorrect use of devices'],
            ['global_threat' => 5, 'threat_description' => 'Damaging devices or media'],
            ['global_threat' => 5, 'threat_description' => 'Fraudulent copying of software'],
            ['global_threat' => 5, 'threat_description' => 'Use of counterfeit or copied software'],
            ['global_threat' => 5, 'threat_description' => 'Corruption of data'],
            ['global_threat' => 5, 'threat_description' => 'Illegal processing of data'],
            ['global_threat' => 5, 'threat_description' => 'Sending or distributing of malware'],
            ['global_threat' => 5, 'threat_description' => 'Position detection'],

            ['global_threat' => 6, 'threat_description' => 'Error in use'],
            ['global_threat' => 6, 'threat_description' => 'Abuse of rights or permissions'],
            ['global_threat' => 6, 'threat_description' => 'Forging of rights or permissions'],
            ['global_threat' => 6, 'threat_description' => 'Denial of actions'],

            ['global_threat' => 7, 'threat_description' => 'Lack of staff'],
            ['global_threat' => 7, 'threat_description' => 'Lack of resources'],
            ['global_threat' => 7, 'threat_description' => 'Failure of service providers'],
            ['global_threat' => 7, 'threat_description' => 'Violation of laws or regulations']

            


          
        ]);
    }
}
