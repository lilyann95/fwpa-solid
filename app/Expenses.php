<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = [
        'desc',
        'budget',
        'status',
        'reason',
        'months_taken'
    ];

    public function user() {
        return $this->belongsTo("App\User");
    }
    public function savings() {
        return $this->hasMany("App\savings");
    }
    public function loans(){
        return $this->hasMany("App\Loans");
    }

}
