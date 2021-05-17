<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    protected $fillable = [
        'name_id',
        'date',
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
        'total_amount'
    ];

    public function user() {
        return $this->belongsTo("App\User");
    }

    public function expense() {
        return $this->hasMany("App\Expenses");
    }
    public function loans(){
        return $this->hasMany("App\Loans");
    }
   
} 

