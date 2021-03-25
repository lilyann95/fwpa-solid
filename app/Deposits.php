<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposits extends Model
{
    protected $fillable = [
        'name',
        'total_amount',
        'Expected_savings',
        'Arrears',
        'loan_offered',
        'months_taken',
        'loan_return',
        'last_paymentdate'
    ];

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function savings() {
        return $this->hasMany("App\Savings");
    }

    public function payouts() {
        return $this->hasOne("App\Payouts");
    }

    public function expense() {
        return $this->hasMany("App\Expenses");
    }
}
