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

    public function deposits() {
        return $this->hasOne("App\Deposits");
    }
    public function payouts() {
        return $this->hasOne("App\Payouts");
    }
    
    // public function scopebudget()
    // {
    //     return response()->json( DB::table("expenses")
    //                 ->where("user_id", "=", Auth::user()->id)
    //                 ->join("users", "expenses.user_id", "=", "users.id")
    //                 ->select("expenses.budget")->get()
    // );
    // }
}
