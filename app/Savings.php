<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    protected $fillable = [
        'name_id',
        'name',
        'monthly_contribution',
        'late_payment',
        'late_meeting',
        'absenteeism',
        'marriage',
        'birth',
        'graduation',
        'consecration',
        'sickness',
        'death',
        'loan_liability',
        'total_amount'
    ];

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function expense() {
        return $this->hasOne("App\Expenses");
    }

    public function deposits() {
        return $this->hasOne("App\Deposits");
    }

    public function payouts() {
        return $this->hasOne("App\Payouts");
    }
} 

