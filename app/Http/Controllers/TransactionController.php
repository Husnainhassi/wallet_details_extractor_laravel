<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        return view('token.transactions');
    }

    public function fetch(Request $request)
    {
        $validated = $request->validate([
            'token_address' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time'
        ]);

        // Convert dates to timestamps
        $start = strtotime($validated['start_time']);
        $end = strtotime($validated['end_time']);

        // Get transactions
        $transactions = $this->getTokenTransactions(
            $validated['token_address'],
            $start,
            $end
        );
        dd($transactions);

        return view('token.transactions', ['transactions' => $transactions]);
    }

    public function getTokenTransactions()
    {
      // dd('dasdda');
        // $url = "https://public-api.birdeye.so/defi/txs/token";
        // $url = "https://public-api.birdeye.so/public/transactions/token";
        // $address = 'CZaZBxNZvag6tDCmNmL5i8WphCfU53X2ZP7Kp6zppump';
        // dd($address);
        $limit = 50;
        // $url = 'https://graphql.bitquery.io';
        // $url = 'https://streaming.bitquery.io/graphql';
        // $url = 'https://api.helius.xyz/v0';

      //   $response = Http::withHeaders([
      //       'Accept' => '*/*',
      //   ])->withBasicAuth(
      //     env('HELIUS_API_USERNAME'),
      //     env('HELIUS_API_PASSWORD')
      // )->get('https://api.helius.xyz/v0/addresses/ATQjQtEnfrarToJ3nXUenmNXHhE8gV1sLKAfG2GRpump/transactions', [
      //   'api-key' => env('HELIUS_API_KEY'),
      //   'limit' => 10
      // ]);

      $response = Http::withHeaders([
        'accept' => 'application/json',
        'accept-encoding' => 'gzip, deflate, br, zstd',
        'accept-language' => 'en-US,en;q=0.9',
        'origin' => 'https://birdeye.so',
        'referer' => 'https://birdeye.so/',
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36',
        'content-type' => 'application/json',
        'agent-id' => 'f3fe63d6-de8e-4925-b321-9b920e82e3b9',
        'page' => 'find-trades'
    ])->post('https://multichain-api.birdeye.so/solana/amm/v2/txs/token', [
        'offset' => 15,
        'limit' => 15,
        'export' => false,
        'query' => [
            [
                'keyword' => 'side',
                'operator' => 'term',
                'value' => 'trade',
            ],
            [
                'keyword' => 'blockUnixTime',
                'operator' => 'gte',
                'value' => 1745341200,
            ]
        ],
        'sort_by' => '',
        'sort_type' => '',
        'address' => 'F14hCmEKjcaXobNE2fMdRX9EcetC2oNuiZVjpce1iohE',
        'latest_id' => '6807e2e1e3c8181707e823bc',
    ]);
        return $response;
        dd($response);
        
        $transactions = collect($response->json())
        ->filter(function ($tx) use ($start, $end) {
            return isset($tx['timestamp']) && $tx['timestamp'] >= $start && $tx['timestamp'] <= $end;
        })
        ->flatMap(function ($tx) {
            return collect($tx['tokenTransfers'] ?? [])->map(function ($transfer) use ($tx) {
                return [
                    'time' => date('Y-m-d H:i:s', $tx['timestamp']),
                    'type' => $transfer['fromUserAccount'] === 'YOUR_WALLET_ADDRESS' ? 'Send' : 'Receive',
                    'amount' => $transfer['tokenAmount'] / (10 ** $transfer['decimals']),
                    'address' => $transfer['fromUserAccount'],
                    'to' => $transfer['toUserAccount'],
                    'token' => $transfer['mint'],
                    'tx_signature' => $tx['signature']
                ];
            });
        });
    
        return $transactions->values();
    }
}
