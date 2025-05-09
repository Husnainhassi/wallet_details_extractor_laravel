<?php

namespace App\Http\Controllers;

use App\Imports\WalletsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GoodWallet;
use App\Imports\WalletDataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WalletData;

class DefaultController extends Controller
{
    public function goodWallet(Request $request) 
    {
        $query = GoodWallet::query();

        if ($request->filled('winrate_min') && is_numeric($request->winrate_min)) {
            $query->where('win_rate', '>=', (float)$request->winrate_min);
        }

        if ($request->filled('roi_min') && is_numeric($request->roi_min)) {
            $query->where('roi', '>=', (float)$request->roi_min);
        }else{
            $query->where('roi', '>=', 0);
        }

        // dd($query->toSql(), $query->getBindings());
        // Get paginated results
        $wallets = $query->paginate(10);
        
        return view('results', [
            'wallets' => $wallets,
            'filter' => $request->all()
        ]);
    }

    public function list(Request $request) 
    {
        $query = WalletData::query();

        if ($request->filled('winrate_min') && is_numeric($request->winrate_min)) {
            $query->where('win_rate', '>=', (float)$request->winrate_min);
        }

        if ($request->filled('roi_min') && is_numeric($request->roi_min)) {
            $query->where('roi', '>=', (float)$request->roi_min);
        }

        if ($request->has('status')) {
            switch ($request->get('status')) {
                case 'in-review':
                    $query->where('in_review', '=', '1');
                    break;
                case 'disqualified':
                    $query->where('is_disqualified', '1');
                    break;
                default:
                    $query->where('is_disqualified', 0);
                    break;
            }
        } else {
            $query->where('is_disqualified', 0);
             $query->where('in_review', '=', '0');
        }

        $goodWallets = GoodWallet::pluck('wallet_address')->toArray();
        $query->whereNotIn('wallet_address', $goodWallets);

        $wallets = $query->paginate(10);
        
        return view('results', [
            'wallets' => $wallets,
            'filter' => $request->all() 
        ]);
    }

    public function excelImport(Request $request) 
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new WalletDataImport, $request->file('excel_file'));
            return back()->with('success', 'Wallet data imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function excelImportForm()
    {
        return view('import-excel');
    }

    public function addGoodWallet(Request $request)
    {
        $wallet = new GoodWallet();
        $wallet->wallet_address = $request->wallet_address;
        $wallet->roi = $request->roi;
        $wallet->win_rate = $request->win_rate;

        // Try to save the wallet to the database
        if ($wallet->save()) {
            return response()->json(['success' => true]);
        }

        // Return failure response if something goes wrong
        return response()->json(['success' => false]);
    }

    public function updateWalletStatus(Request $request)
    {

        $id = $request->input('id');
        $status = $request->input('status');

        $wallet = WalletData::find($id);
        if (!$wallet) {
            return response()->json(['success' => false]);
        }

        switch ($status) {
            case 'in-review':
                $wallet->in_review = '1';
                break;
            default:
                $wallet->in_review = '0';
                break;
        }

        $wallet->save();
        return response()->json(['success' => true]);
    }
    
    public function disqualify(Request $request)
    {

        $id = $request->input('id');

        $wallet = WalletData::find($id);

        if ($wallet) {
            $wallet->is_disqualified = true;
            $wallet->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
