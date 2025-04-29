<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletAnalyzerController extends Controller
{
    public function index() {
        return view('wallet.analyze');
    }

    public function analyze(Request $request) {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx',
        ]);

        // Store file
        $file = $request->file('csv_file');
        $path = $file->store('csv_files');

        // Process CSV
        $wallets = [];
        if (($handle = fopen(storage_path('app/' . $path), 'r')) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $wallets[] = $data[0]; // Assuming wallet addresses are in first column
            }
            fclose($handle);
        }
        dd($wallets);

        // Analyze wallets
        $qualifiedWallets = [];
        foreach ($wallets as $wallet) {
            $response = Http::get("https://gmgn.ai/sol/address/{$wallet}");
            
            // Parse response (you'll need to inspect actual API response structure)
            $roi = $this->extractROI($response->body());
            $winrate = $this->extractWinrate($response->body());

            if ($roi >= 30 && $winrate >= 60) {
                $qualifiedWallets[] = [
                    'address' => $wallet,
                    'roi' => $roi,
                    'winrate' => $winrate
                ];
            }
        }

        return view('results', ['wallets' => $qualifiedWallets]);
    }

    private function extractROI($html) {
        // Implement actual parsing logic based on GMGN's HTML structure
        // Example using regex (adjust according to actual content):
        preg_match('/ROI:\s*([\d.]+)%/', $html, $matches);
        return $matches[1] ?? 0;
    }

    private function extractWinrate($html) {
        // Implement actual parsing logic
        preg_match('/Win Rate:\s*([\d.]+)%/', $html, $matches);
        return $matches[1] ?? 0;
    }
}
