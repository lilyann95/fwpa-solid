<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guarantors extends Model
{
    protected $fillable = [
    'name',
    'loanamount',
    'quarantor',
    'total-amount2',
    'expected',
    'g_amount',
    'last_payment',
    'status'
    ];

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function loans(){
        return $this->belongsTo("App\Loans");
    }
}
