<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class WalletsImport implements ToCollection
{
    public $wallets = [];
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key > 0) {
                // Skip header row
                $this->wallets[] = $row[0] ?? null;
            }
        }
    }

    public function getWallets()
    {
        return $this->wallets;
    }
}
