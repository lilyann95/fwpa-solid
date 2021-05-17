<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    protected $fillable =[
        'name',
        'totalamountdue',
        'loan_semilimit',
        'loan_limit',
        'loanamount',
        'processingfee',
        'monthstaken',
        'desc',
        'status',
        'quarantor',
        'name_quarantor',
        'g_amount',
        'guarantorstatus',
        'last_payment',
        'seize',
        'return',
        'reason'
    ];
    public function user() {
        return $this->belongsTo("App\User");
    }
    public function expense() {
        return $this->hasMany("App\Expenses");
    }

    public function savings()
    {
        return $this->hasMany("App\Savings");
    }

    public function guarantors()
    {
        return $this->hasMany("App\Guarantors");
    }
}
