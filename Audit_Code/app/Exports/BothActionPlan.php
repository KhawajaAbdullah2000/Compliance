<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;


class BothActionPlan implements FromArray, WithHeadings
{
    public $treatment_action_plan;
    public $mandatory_action_plan;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($mandatory_action_plan,$treatment_action_plan)
    {
        $this->treatment_action_plan = $treatment_action_plan;
        $this->mandatory_action_plan=$mandatory_action_plan;
    }

    public function headings(): array
    {
        return [
            'Req. No',
            'Action',
            'Target Date',
            'Completion Date',
            'Actual Acceptance Date',
            'Responsibility for Treatment'
        ];
    }

    public function array(): array
{
    $rows = [];

    foreach ($this->mandatory_action_plan as $mand) {
        $rows[] = [
            $mand->sub_req,
            $mand->treatment_action,
            $mand->treatment_target_date,
            $mand->treatment_comp_date,
            $mand->acceptance_actual_date,
            $mand->first_name . ' ' . $mand->last_name
        ];
    }



    foreach ($this->treatment_action_plan as $mand) {
        $rows[] = [
            $mand->control_num,
            $mand->treatment_action,
            $mand->treatment_target_date,
            $mand->treatment_comp_date,
            $mand->acceptance_actual_date,
            $mand->first_name . ' ' . $mand->last_name
        ];
    }

    return $rows;
}

}
