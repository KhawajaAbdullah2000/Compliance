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
        $reportData = Db::table('iso_sec_2_2')
        ->where('iso_sec_2_2.project_id', $this->proj_id)->orderBy('title_num','asc')
        ->get(
            [
               'title_num','sub_req','comp_status','comments','attachment'

            ]
        );

        $transformedData = $reportData->map(function ($item) {

           if($item->title_num==11){
            $item->title_num='Appendix A';
           }

            $rowData = collect($item)->toArray();
            return $rowData;
        });

        return $transformedData;
    }

    public function headings(): array
    {
        // Adjust these headings to match your actual column names
        return [
            'Title num',
            'SUb Request',
            'Compliance Status',
            'Comments (optional)',
            'Attachment (Optional)'



        ];
    }
}
