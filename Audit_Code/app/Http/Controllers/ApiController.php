<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function test_api(){
        $response = Http::withoutVerifying()->get('https://api.coincap.io/v2/assets/bitcoin');

        if ($response->successful()) {
            $data = $response->json();
            //dd($data);
           
            return view('test_api',[
                'data'=>$data
            ]);
    
        } else {
            dd("Not found");
            // Handle error, e.g., log it or return an error message
        }
    }
}
