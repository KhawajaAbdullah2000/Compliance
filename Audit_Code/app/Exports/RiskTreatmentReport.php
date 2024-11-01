<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class RiskTreatmentReport implements FromCollection, WithHeadings
{
    protected $proj_id;

    public function __construct($proj_id)
    {
        $this->proj_id = $proj_id;
    }

    public function collection()
    {
        $projectName = DB::table('projects')->where('project_id', $this->proj_id)->first()->project_name;

        $reportData= Db::table('iso_sec_2_1')->join('iso_risk_treatment','iso_sec_2_1.assessment_id','iso_risk_treatment.asset_id')
        ->leftjoin('users','iso_risk_treatment.responsibility_for_treatment','users.id')
        ->where('iso_sec_2_1.project_id', $this->proj_id)->orderBy('asset_id','asc')->orderBy('control_num','asc')
        ->get([
           's_name', 'g_name', 'name', 'c_name',
             'control_num', 'residual_risk_treatment',
            'treatment_action', 'treatment_target_date', 'treatment_comp_date',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as responsibility_for_treatment"),
            'acceptance_justification',
            'acceptance_target_date',
             'acceptance_actual_date'
        ]);



        // Prepending the project name to each row
        // $transformedData = $reportData->map(function ($item) use ($projectName) {
        //     $item->control_num = "'".$item->control_num."'";
        //     $rowData = collect($item)->toArray();
        //     array_unshift($rowData, $projectName); // Add project name as first column
        //     return $rowData;
        // });

        return $reportData;
    }

    public function headings(): array
    {
        // Adjust these headings to match your actual column names
        return [
            'Service Name',
            'Asset Group Name',
            'Asset Name',
            'Asset Component Name',
            'Control Num',
            'Residual Risk Treatment',
            'Treatment Action',
            'Treatment Target Date',
            'Treatment Completion Date',
            'Responsibility for Treatment',
            'Justification for Acceptance',
            'Acceptance Target date',
            'Acceptance Actual date'
        ];
    }
}
