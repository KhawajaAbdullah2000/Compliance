<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class RiskAssessmentExport implements FromCollection, WithHeadings
{
    protected $proj_id;

    public function __construct($proj_id)
    {
        $this->proj_id = $proj_id;
    }

    public function collection()
    {
        $projectName = DB::table('projects')->where('project_id', $this->proj_id)->first()->project_name;
        $reportData = Db::table('iso_sec_2_1')->join('iso_sec_2_3_1','iso_sec_2_1.assessment_id','iso_sec_2_3_1.asset_id')
        ->where('iso_sec_2_1.project_id', $this->proj_id)->orderBy('asset_id','asc')->orderBy('control_num','asc')
        ->get(
            [
                'g_name', 'name', 'c_name', 'owner_dept', 'physical_loc',
                'logical_loc', 's_name','control_num','applicability','asset_value','control_compliance',
                'vulnerability','threat','risk_level'
            ]
        );

        $transformedData = $reportData->map(function ($item) use ($projectName) {
            // Prepend a single quote to control_num to ensure it's treated as text
            $item->control_num = "'".$item->control_num."'";
            
            $rowData = collect($item)->toArray();
            array_unshift($rowData, $projectName); // Add project name as first column
            return $rowData;
        });

        return $transformedData;
    }

    public function headings(): array
    {
        // Adjust these headings to match your actual column names
        return [
            'Project Name',
            'Asset Group Name',
            'Asset Name',
            'Asset Component Name',
            'Asset Owner Dept',
            'Asset Physical Location',
            'Asset Logical Location',
            'Service Name for which it is an underlying asset',
            'Control Num',
            'Applicability',
            'Asset Value',
            'Control Compliance',
            'Vulnerability',
            'Threat',
            'Risk Level'

        ];
    }
}
