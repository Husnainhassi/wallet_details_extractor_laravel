<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodWallet extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'good_wallets';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'wallet_address',
        'roi',
        'win_rate',
    ];

    public $timestamps = false;

}
