<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CropController extends Controller
{
    
    private $cropData = [
        'rice' => [
            'name' => 'Aman / Boro Rice (ধান)',
            'season' => 'Kharif / Rabi',
            'soil' => 'Clayey or Clayey-Loam (ধোঁয়াশ ও এটেল মাটি)',
            'base_n' => 60,  
            'base_p' => 20,  
            'base_k' => 40,  
            'expected_yield' => '2.5 Tons per Acre'
        ],
        'wheat' => [
            'name' => 'Wheat (গম)',
            'season' => 'Rabi (Winter)',
            'soil' => 'Loam / Sandy-Loam (সুনিষ্কাশিত দোআঁশ মাটি)',
            'base_n' => 50,
            'base_p' => 28,
            'base_k' => 35,
            'expected_yield' => '1.8 Tons per Acre'
        ],
        'potato' => [
            'name' => 'Potato (আলু)',
            'season' => 'Rabi (Winter)',
            'soil' => 'Loose Sandy-Loam (উর্বর হালকা বেলে-দোআঁশ)',
            'base_n' => 90,
            'base_p' => 65,
            'base_k' => 100,
            'expected_yield' => '12 Tons per Acre'
        ]
    ];

    public function index()
    {
        $crops = $this->cropData;
        return view('crop.hub', compact('crops'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'crop_type' => 'required|in:rice,wheat,potato',
            'land_size' => 'required|numeric|min:0.1',
        ]);

        $cropKey = $request->crop_type;
        $landSize = $request->land_size;
        $selectedCrop = $this->cropData[$cropKey];

        
        $calculatedN = $selectedCrop['base_n'] * $landSize;
        $calculatedP = $selectedCrop['base_p'] * $landSize;
        $calculatedK = $selectedCrop['base_k'] * $landSize;

        $results = [
            'crop_name' => $selectedCrop['name'],
            'land_size' => $landSize,
            'urea' => round($calculatedN, 2),
            'tsp' => round($calculatedP, 2),
            'mop' => round($calculatedK, 2),
        ];

        return redirect()->route('crophub.index')
            ->with('calc_results', $results)
            ->withInput();
    }
}