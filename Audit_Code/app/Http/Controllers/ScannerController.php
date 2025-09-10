<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ScannerController extends Controller
{
    public function nessus_results($org_id)
    {
        $path = public_path('EPG Scan_zs2snj.csv');

        // Read CSV into array
        $data = Excel::toArray([], $path);

        // $data is multi-dimensional array, first index is sheet 0
        $rows = $data[0];

        // First row as header
        $headers = $rows[0];
        // Remaining rows as data
        $values = array_slice($rows, 1);

        //dd($headers,$values);

        return view('scanner.csv_table', compact('headers', 'values'));
    }

    public function types_of_testing_list($org_id)
    {

        return view('scanner.types_of_testing');
    }

    public function select_tools($org_id, $type_of_test)
    {
        
            return view('scanner.types_of_tools', [
                'type_of_test' => $type_of_test
            ]);
        
    }
}
