<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PestReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AgriUtilityController extends Controller
{
    public function index()
    {
        
        $weatherData = null;
        $syncStatus = 'Failed to connect to external api stream';

        try {
           
            $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'current_weather' => true,
                'timezone' => 'Asia/Dhaka'
            ]);

            if ($response->successful()) {
                $weatherData = $response->json()['current_weather'];
                $syncStatus = 'SUCCESSFUL - REST API Synchronization Completed';
                Log::info('Krshi Bondhu Weather Logger API synced successfully at: ' . now());
            }
        } catch (\Exception $e) {
            $syncStatus = 'ERROR - Fallback offline telemetry simulated: ' . $e->getMessage();
        }

        $pastReports = PestReport::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('utilities.index', compact('weatherData', 'syncStatus', 'pastReports'));
    }

    public function storePestReport(Request $request)
    {
        $request->validate([
            'crop_type' => 'required|string|max:255',
            'pest_name' => 'required|string|max:255',
            'severity' => 'required|in:low,medium,critical',
            'description' => 'required|string|min:10',
        ]);

        PestReport::create([
            'user_id' => Auth::id(),
            'crop_type' => $request->crop_type,
            'pest_name' => $request->pest_name,
            'severity' => $request->severity,
            'description' => $request->description,
        ]);

        return redirect()->route('utilities.index')->with('pest_success', 'Pest hazard log recorded. Advisory services notified.');
    }

    public function calculateSeed(Request $request)
    {
        $request->validate([
            'target_crop' => 'required|in:rice,wheat,maize',
            'area_size' => 'required|numeric|min:0.1',
        ]);

        $crop = $request->target_crop;
        $acres = $request->area_size;

        $seedRates = ['rice' => 20, 'wheat' => 45, 'maize' => 10];
        $computedSeedWeight = $seedRates[$crop] * $acres;

        $computedUrea = 55 * $acres;

        $seedResults = [
            'crop' => ucfirst($crop),
            'acres' => $acres,
            'required_seed_kg' => $computedSeedWeight,
            'suggested_urea_kg' => $computedUrea,
        ];

        return redirect()->route('utilities.index')->with('seed_results', $seedResults)->withInput();
    }
}