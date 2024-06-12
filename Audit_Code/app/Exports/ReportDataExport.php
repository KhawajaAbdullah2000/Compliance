<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ReportDataExport implements FromCollection, WithHeadings
{
    protected $proj_id;

    public function __construct($proj_id)
    {
        $this->proj_id = $proj_id;
    }

    public function collection()
    {
        $projectName = DB::table('projects')->where('project_id', $this->proj_id)->first()->project_name;
        $reportData = DB::table('iso_sec_2_1')->where('project_id', $this->proj_id)->get(
            ['s_name','g_name','name','c_name','owner_dept','physical_loc',
        'logical_loc']
        );

        // Prepending the project name to each row
        $transformedData = $reportData->map(function ($item) use ($projectName) {
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
            'Service Name for which it is an underlying asset',
            'Asset Group Name',
            'Asset Name',
            'Asset Component Name',
            'Asset Owner Dept',
            'Asset Physical Location',
            'Asset Logical Location'
        ];
    }
}
