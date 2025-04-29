<?php

namespace App\Http\Controllers;

use App\Imports\WalletsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class WalletAnalyzerController extends Controller
{
    public function index() {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/122.0 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Connection' => 'keep-alive'
        ])->get("https://gmgn.ai/sol/address/Ew3k9YtS63gV29XhWdpKcXN93m9j3MSehyxxXUg9tp7r");
        dd($response->body());
        return view('wallet.analyze');
    }

    public function analyze(Request $request) {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx',
        ]);

        // Store file
        $file = $request->file('csv_file');

        $import = new WalletsImport();
        Excel::import($import, $file);

        $wallets = $import->getWallets();
        dd($wallets);

        $wallets[] = Excel::import(new WalletsImport(),$file);

        // Analyze wallets
        $qualifiedWallets = [];
        foreach ($wallets as $wallet) {
            $response = Http::get("https://gmgn.ai/sol/address/{$wallet}");

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
