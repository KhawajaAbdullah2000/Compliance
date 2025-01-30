<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class RiskRegister implements FromArray, WithHeadings
{
    protected $Results;
    protected $RiskType;

    protected $RiskToData;



    public function __construct(array $results, string $risk_type,string $RiskToData)
    {
        $this->Results = $results;
        $this->RiskType = $risk_type;
        $this->RiskToData=$RiskToData;
     
       
    }

    public function headings(): array
    {
        return [
            'Control Num',
            'Control is Applicable?',
            'Control Compliance %',
            'Vulnerability %',
            'Threat %',
            "Risk to {$this->RiskToData}", 
        ];
    }

    public function array(): array
    {
        $rows = [];

        // Add service and component rows
        foreach ($this->Results as $row) {
         
                $rows[] = [
                  (string)($row->control_num),
                 ($row->applicability),
                 ($row->control_compliance),
                 ($row->vulnerability),
                 ($row->threat),
                 $row->{$this->RiskType}
               
                ];
            }


        return $rows;
    }

}
