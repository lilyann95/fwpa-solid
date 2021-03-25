<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payouts extends Model
{
    protected $fillable = [
        
        'amount_due',
        'Exact_amount',
        'Arrears',
        'loan_offered',
        'payout_amount'
       
    ];

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function deposits() {
        return $this->hasOne("App\Deposits");
    }

    public function savings() {
        return $this->hasOne("App\Savings");
    }

    public function expense() {
        return $this->hasOne("App\Expenses");
    }
}
