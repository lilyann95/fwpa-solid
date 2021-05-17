<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loans;
use App\Savings;
use App\Expenses;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $users = User::all();
       $fruit = Loans::where("user_id", "=", Auth::user()->id)->get("loans.totalamountdue");
    	$veg = Loans::where("user_id", "=", Auth::user()->id)->get("loans.loan_semilimit");;
        $grains = Loans::where("user_id", "=", Auth::user()->id)->get("loans.loan_limit");;
        
        $runningloan = Loans::where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "approved")->get("loans.loanamount");
    	$expectedreturn = Loans::where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "approved")->get("loans.return");
    	$data = [
            "running_loan" => $runningloan,
            "expected_return" => $expectedreturn,
            "fruit_c" => $fruit,
            "veg_c" => $veg,
            "grains_c" => $grains
        ];
        return view('dashboard')->with("users", $users);
    }
    
    public function check()
    {
        return true;
    }
}
