<?php

namespace App\Imports;

use App\Models\WalletData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class WalletDataImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $roi = $this->cleanNumericValue($row['roi'] ?? $row['ROI'] ?? 0);
        $winrate = $this->cleanNumericValue($row['winrate'] ?? $row['Winrate'] ?? 0);
        $wallet = $row['trader'] ?? $row['wallet_address'];

        $existing = WalletData::where('wallet_address', $wallet)->first();

        if ($roi > 20 && $winrate > 50) {
            if ($existing && ($existing->roi != $roi || $existing->win_rate != $winrate)) {
                $existing->update([
                    'roi' => $roi,
                    'win_rate' => $winrate,
                    'is_disqualified' => 0,
                    'updated_at' => now(),
                ]);
            } else {
                WalletData::create([
                    'wallet_address' => $wallet,
                    'roi' => $roi,
                    'win_rate' => $winrate,
                ]);
            }
        }
    
        return null;
    }

    public function rules(): array
    {
        return [
            'Trader' => 'string',
            'ROI' => 'nullable|numeric',
            'Winrate' => 'nullable|numeric',
        ];
    }

    private function cleanNumericValue($value)
    {
        if (is_string($value)) {
            $cleaned = str_replace('%', '', $value);
            return (float)$cleaned;
        }
        
        return (float)$value;
    }
}