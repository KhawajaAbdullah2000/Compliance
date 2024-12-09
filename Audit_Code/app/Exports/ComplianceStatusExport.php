<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ComplianceStatusExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $formattedResults;
    protected $columnTotals;

    public function __construct(array $formattedResults, array $columnTotals)
    {
        $this->formattedResults = $formattedResults;
        $this->columnTotals = $columnTotals;
    }

    public function headings(): array
    {
        return [
            'Service',
            'Asset Component',
            'In Place',
            'Not In Place',
            'Not Applicable',
            'Not Tested',
            'Partial',
            'Total',
        ];
    }

    public function array(): array
    {
        $rows = [];

        // Add service and component rows
        foreach ($this->formattedResults as $service => $components) {
            foreach ($components as $component => $statuses) {
                $rows[] = [
                    $service,
                    $component,
                    (string) ($statuses['yes'] ?? '0'),
                (string) ($statuses['no'] ?? '0'),
                (string) ($statuses['not_applicable'] ?? '0'),
                (string) ($statuses['not_tested'] ?? '0'),
                (string) ($statuses['partial'] ?? '0'),
                (string) ($statuses['total'] ?? '0'),
                ];
            }
        }

        // Add the totals row
        $rows[] = [
            'Total',
            '', // Empty column for "Asset Component"
            (string) ($this->columnTotals['yes'] ?? '0'),
            (string) ($this->columnTotals['no'] ?? '0'),
            (string) ($this->columnTotals['not_applicable'] ?? '0'),
            (string) ($this->columnTotals['not_tested'] ?? '0'),
            (string) ($this->columnTotals['partial'] ?? '0'),
            (string) ($this->columnTotals['total'] ?? '0'),
        ];

        return $rows;
    }
}
