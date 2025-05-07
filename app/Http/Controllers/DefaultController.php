<?php

namespace App\Http\Controllers;

use App\Imports\WalletsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Imports\WalletDataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WalletData;

class DefaultController extends Controller
{
   
    public function list(Request $request) 
    {
        $query = WalletData::query();

        // Apply Winrate filter if provided
        if ($request->filled('winrate_min') && is_numeric($request->winrate_min)) {
            $query->where('Winrate', '>=', (float)$request->winrate_min);
        }

        // Apply ROI filter if provided
        if ($request->filled('roi_min') && is_numeric($request->roi_min)) {
            $query->where('ROI', '>=', (float)$request->roi_min);
        }

        // Always exclude negative ROI values
        $query->where('ROI', '>=', 0);
        // dd($query->toSql(), $query->getBindings());
        // Get paginated results
        $wallets = $query->paginate(10);
        
        return view('results', [
            'wallets' => $wallets,
            'filter' => $request->all() // Pass all filters back to view
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

    public function showImportForm()
    {
        return view('import-excel');
    }

}
