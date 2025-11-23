<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MandatoryActionPlan implements FromArray, WithHeadings
{
    protected $mandatory_action_plan;
    protected $frameworkRows;
    protected $frameworkHeader;

    public function __construct($mandatory_action_plan, array $frameworkRows = [], ?array $frameworkHeader = null)
    {
        $this->mandatory_action_plan = $mandatory_action_plan;
        $this->frameworkRows         = $frameworkRows;
        $this->frameworkHeader       = $frameworkHeader;
    }

    public function headings(): array
    {
        // Excel header row for mapping file:
        // [0] => Domain No
        // [1] => Domain Name
        // [2] => Subdomain No
        // [3] => Subdomain Name
        // [4] => Req No
        // [5] => Control Name
        $h = $this->frameworkHeader ?: [];

        return [
            $h[0] ?? 'Domain No',
            $h[1] ?? 'Domain Name',
            $h[2] ?? 'Sub-Domain No',
            $h[3] ?? 'Sub-Domain Name',
            $h[4] ?? 'Req No',
            $h[5] ?? 'Control',

            // Your existing + new columns
            'Compliance Status',
            'Action',
            'Target Date',
            'Completion Date',
            'Actual Acceptance Date',
            'Responsibility for Treatment',
            'Attachment', // Yes/No
        ];
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->mandatory_action_plan as $mand) {
            // DB values
            $domain    = strval($mand->title_num);   // domain number
            $subdomain = strval($mand->subdomain);   // subdomain number
            $subreq    = strval($mand->sub_req);     // requirement number

            // Find matching row from framework Excel
            $match = collect($this->frameworkRows)->first(function ($row) use ($domain, $subdomain, $subreq) {
                // Excel columns:
                // 0 => domain no
                // 1 => domain name
                // 2 => subdomain no
                // 3 => subdomain name
                // 4 => sub req no
                // 5 => control name (or number + name)
                return strval($row[0]) === $domain
                    && strval($row[2]) === $subdomain
                    && strval($row[4]) === $subreq;
            });

            $domainNo      = $match[0] ?? $domain;
            $domainName    = $match[1] ?? '';
            $subdomainNo   = $match[2] ?? $subdomain;
            $subdomainName = $match[3] ?? '';
            $subReqNo      = $match[4] ?? $subreq;
            $controlName   = $match[5] ?? '';

            // Attachment flag Yes/No
            $attachmentFlag = !empty($mand->attachment) ? 'Yes' : 'No';

            $rows[] = [
                $domainNo,
                $domainName,
                $subdomainNo,
                $subdomainName,
                $subReqNo,
                $controlName,

                // Compliance + action data
                $mand->comp_status,
                $mand->treatment_action,
                $mand->treatment_target_date,
                $mand->treatment_comp_date,
                $mand->acceptance_actual_date,
                trim(($mand->first_name ?? '') . ' ' . ($mand->last_name ?? '')),
                $attachmentFlag,
            ];
        }

        return $rows;
    }
}
