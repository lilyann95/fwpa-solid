<?php

namespace App\Http\Controllers;

use App\Expenses;
use App\Loans;
use App\User;
use App\Savings;
use App\Guarantors;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;


class SavingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
     {
        $users = User::all();
        return view('savings.index')->with('users', $users);
        
    }
   
    public function view()
    {
        
        $users =DB::table("users")->where("users.fwpnumber", "!=", "NONE_CP")->where("users.fwpnumber", "!=", "NONE_TR")->get();
        $savings = Savings::all();
        $sumcontribution = Savings::sum('monthly_contribution');
        $sumlatepayment = Savings::sum('late_payment');
        $sumlatemeeting = Savings::sum('late_meeting');
        $sumabsenteeism = Savings::sum('absenteeism');
        $summarriage = Savings::sum('marriage');
        $sumbirth = Savings::sum('birth');
        $sumgraduation = Savings::sum('graduation');
        $sumconsecration = Savings::sum('consecration');
        $sumsickness = Savings::sum('sickness');
        $sumdeath = Savings::sum('death');
        $expenses = Expenses::where("status", "=", "approved")->sum("budget");
        $expenditure = collect([
                                $sumlatepayment,
                                $sumlatemeeting,
                                $sumabsenteeism,
                                $summarriage,
                                $sumbirth,
                                $sumgraduation,
                                $sumconsecration,
                                $sumsickness,
                                $sumdeath
                            ])->sum();
        $loangivenout = Loans::where("loans.status", "=", "approved")->sum('loanamount');                        
        $amountdue = $sumcontribution - ($expenditure + $expenses + $loangivenout);
        
        $Expected_savings = 10200000;
        $Arrears = -($Expected_savings - $amountdue);
        $percentage = 90;
        $percent_of_expected = ($percentage / 100) * $Expected_savings;
        $payout_amount = $Arrears + $percent_of_expected;
        $loanclearguarmine = Loans::where("loans.status", "=", "approved")
                    ->join("users", "loans.quarantor", "=", "users.id")
                ->orderBy('loans.id', 'desc')->get("loans.g_amount")->first(); 
        $loan = Loans::where("loans.status", "=", "approved")->sum('loanamount') ?? '';
                   
        $loanreturn = Loans::where("loans.status", "=", "approved")->sum('return') ?? '';
                  
                            
        if($loan){
            $guarantor = $loanclearguarmine; 
            $budget = $loan;
            $budgetreturn = $loanreturn;
        }else{
            $budget = 0;
            $budgetreturn = 0;
            $guarantor = 0;
        }          
      
        $data = [
            "users" => $users,
            "savings" => $savings,
            "expendit" => $expenditure,
            "loan" => $budget,
            "loanreturn" => $budgetreturn,
            "guarantor" => $guarantor,
            "amount" =>  $amountdue,
            "Expected" =>  $Expected_savings,
            "percent" => $percent_of_expected,
            "Arrears" => $Arrears,
            "Payout" => $payout_amount
        ];
        return view('savings.view')->with("data", $data);
    }
    public function create(Request $request)
    { 
        $this->validate($request, [
             "savingscate" => "required",
             "month" => "required",
            "monthly_contribution" => "required|numeric",
            "late_payment" => "required|numeric",
            "late_meeting" => "required|numeric",
            "absenteeism" => "required|numeric",
            "marriage" => "required|numeric",
            "birth" => "required|numeric",
            "graduation" => "required|numeric",
            "consecration" => "required|numeric",
            "sickness" => "required|numeric",
            "death" => "required|numeric",
        ]);
       
        $user = User::findOrFail(Auth::user()->id);
        $inputs = $request->all();
        $savings = collect([
                $inputs["late_payment"],
                $inputs["late_meeting"],
                $inputs["absenteeism"],
                $inputs["marriage"],
                $inputs["birth"],
                $inputs["graduation"],
                $inputs["consecration"],
                $inputs["sickness"],
                $inputs["death"]
            ])->sum();
        
        $userObject = User::findOrFail($inputs["savingscate"]);
        $loan = Loans::where("loans.user_id", "=", $inputs["savingscate"])
                    ->join("users", "loans.user_id", "=", "users.id")
                    ->where("loans.status", "=", "Approved")
                   ->orderBy('loans.id', 'desc')->get("loans.loanamount")->first() ?? '';
        if($loan){
            $budget = $loan->loanamount;
        }else{
            $budget = 0;
        }          
        $saving =  $inputs["monthly_contribution"]-$savings - $budget;     
           

       
            try {
            
                $user->savings()->save(
                    new Savings([
                        "name_id" => $userObject->id,
                        "name" => $inputs['savingscate'],
                        "date" => $inputs['month'],
                        "monthly_contribution" => $inputs["monthly_contribution"],
                        "late_payment" => $inputs["late_payment"],
                        "late_meeting" =>  $inputs["late_meeting"],
                        "absenteeism" => $inputs["absenteeism"],
                        "marriage" => $inputs["marriage"],
                        "birth" => $inputs["birth"],
                        "graduation" => $inputs["graduation"],
                        "consecration" => $inputs["consecration"],
                        "sickness" => $inputs["sickness"],
                        "death" => $inputs["death"],
                        // "loan_liability" => $budget,
                        "total_amount" => $saving,
                        "month_payment" => $inputs["month"]
                    ])
                );
                return response()->json([
                    "msg" => "Savings Stored Successfully"
                ]);
            } catch (QueryException $th) {
                throw $th;
            }
    }
    public function fill(Request $request)
    {
        $inputs = $request->all();
        $userObject = User::findOrFail($inputs["savingscate"]);
        $currentyear = date("Y");
        $currentmonth = date("m");
        try {
            $savings = DB::table("savings")
                ->where("savings.name_id", "=", $inputs["savingscate"])
                ->whereYear('date', $currentyear)
                ->whereMonth('date', $currentmonth)
                ->join("users", "savings.name_id", "=", "users.id")
                ->select(
                    "savings.id",
                    "savings.monthly_contribution",
                    "savings.created_at",
                    "savings.late_payment",
                    "savings.late_meeting",
                    "savings.absenteeism",
                    "savings.marriage",
                    "savings.birth",
                    "savings.graduation",
                    "savings.consecration",
                    "savings.sickness",
                    "savings.death",
                    "savings.total_amount",
                    "savings.name_id",
                    "users.name"
                )->orderBy("created_at", "desc")->get();
            return response()->json([
                "savings" =>  $savings
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function edit($id, Request $request)
    {
        $this->validate($request, [
            "desc" => "required",
            "budget" => "required|numeric"
           
        ]);
        $inputs = $request->all();
        $user = User::findOrFail(Auth::user()->id);
        try {
            $user->expense()->where("id", "=", $id)->update([
                "desc" => $inputs['desc'],
                "budget" => $inputs['budget'],
            ]);
            return response()->json(["msg" => "Operation successfully"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    
    // fetching depending on year
    public function fetchByYear(Request $request)
    {
        $startYear = date(explode("-", $request->selectedYear)["0"]."-04-10");
        $endYear = date(explode("-", $request->selectedYear)["1"]."-06-10");
        $inputs = $request->all();

        try { 
            $sumcontribution = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['cat_id'])->sum('monthly_contribution');
            $sumlatepayment = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['cat_id'])->sum('late_payment');
            $sumlatemeeting = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['cat_id'])->sum('late_meeting');
            $sumabsenteeism = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['cat_id'])->sum('absenteeism');
            $summarriage = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['cat_id'])->sum('marriage');
            $sumbirth = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", $inputs['cat_id'])->sum('birth');
            $sumgraduation = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['cat_id'])->sum('graduation');
            $sumconsecration = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['cat_id'])->sum('consecration');
            $sumsickness = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['cat_id'])->sum('sickness');
            $sumdeath = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", $inputs['cat_id'])->sum('death');
            $loan = Loans::where("loans.user_id", "=", $inputs["cat_id"])
                                ->whereBetween('loans.created_at', [$startYear, $endYear])
                                ->join("users", "loans.user_id", "=", "users.id")
                                ->where("loans.status", "=", "approved")
                            ->orderBy('loans.id', 'desc')->get("loans.loanamount")->first();
            $loanbudget = Loans::where("loans.user_id", "=", $inputs["cat_id"])
                               ->whereBetween('loans.created_at', [$startYear, $endYear])
                                ->join("users", "loans.user_id", "=", "users.id")
                                ->where("loans.status", "=", "approved")
                            ->orderBy('loans.id', 'desc')->get("loans.return")->first();
            $loanapproveguarmine = Loans::where("loans.quarantor", "=", $inputs["cat_id"])
                                ->whereBetween('loans.created_at', [$startYear, $endYear])
                                ->join("users", "loans.quarantor", "=", "users.id")
                                ->where("loans.status", "=", "approved")
                            ->orderBy('loans.id', 'desc')->get("loans.g_amount")->first(); 
            $loancleared = Loans::where("loans.user_id", "=", $inputs["cat_id"])
                           ->whereBetween('loans.created_at', [$startYear, $endYear])
                            ->join("users", "loans.user_id", "=", "users.id")
                            ->where("loans.status", "=", "cleared")
                            ->orderBy('loans.id', 'desc')->get("loans.return")->first();
                            // ->sum("return");   
            $loanclearedNo = Loans::where("loans.user_id", "=", $inputs["cat_id"])
                           ->whereBetween('loans.created_at', [$startYear, $endYear])
                            ->join("users", "loans.user_id", "=", "users.id")
                            ->where("loans.status", "=", "cleared")
                            ->where("loans.seize", "=", "NO")
                            ->sum("return"); 
            $loanclearedYes = Loans::where("loans.user_id", "=", $inputs["cat_id"])
                           ->whereBetween('loans.created_at', [$startYear, $endYear])
                            ->join("users", "loans.user_id", "=", "users.id")
                            ->where("loans.status", "=", "cleared")
                            ->where("loans.seize", "=", "YES")
                            // ->orderBy('loans.id', 'desc')->get("loans.return")->first();
                            ->sum("return"); 
            $guarid =Loans::whereBetween('loans.created_at', [$startYear, $endYear])
                            ->where("loans.status", "=", "cleared")
                            ->where("loans.seize", "=", "YES") 
                            ->orderBy('loans.id', 'desc')->get();
            // $meguar = Loans::whereBetween('loans.created_at', [$startYear, $endYear])
            //                 ->where("loans.status", "=", "cleared")
            //                 ->where("loans.seize", "=", "YES") 
            //                 ->orderBy('loans.id', 'desc')->get("loans.quarantor");
            $meguar = Loans::whereBetween('loans.created_at', [$startYear, $endYear])
                            ->where("loans.status", "=", "cleared")
                            ->where("loans.seize", "=", "YES")
                            ->orderBy('loans.id', 'desc')->get("loans.quarantor");                
            $guarloancleared = Loans::where("loans.user_id", "=", $inputs["cat_id"])
                        ->whereBetween('loans.created_at', [$startYear, $endYear])
                        ->join("users", "loans.user_id", "=", "users.id")
                        ->where("loans.status", "=", "cleared")
                        ->where("loans.seize", "=", "YES")
                        // ->orderBy('loans.id', 'desc')->get("loans.g_amount")->first();
                        ->sum("g_amount");
            
            // $seizeloancleared = Loans::where("loans.user_id", "=", $inputs["cat_id"])
            //             ->whereBetween('loans.created_at', [$startYear, $endYear])
            //             ->join("users", "loans.user_id", "=", "users.id")
            //             ->where("loans.status", "=", "cleared")
            //         ->orderBy('loans.id', 'desc')->get("loans.seize")->first();
            $amguarloancleared =  Loans::where("loans.quarantor", "=", $inputs["cat_id"])
                    ->whereBetween('loans.created_at', [$startYear, $endYear])
                    ->join("users", "loans.quarantor", "=", "users.id")
                    ->where("loans.status", "=", "cleared")
                    ->where("loans.seize", "=", "YES")
                    // ->orderBy('loans.id', 'desc')->get("loans.g_amount")->first();
                    ->sum("g_amount"); 
                          
             //running guarantor loan         
            if ($loanapproveguarmine) {
               
                $approveguarmine = $loanapproveguarmine->g_amount;
            } else {
                $approveguarmine = 0;
            }
            //running loan 
            if($loan){
               
                $budget = $loan->loanamount;
                $loanreturn = $loanbudget->return;
               
            }else{
                $budget = 0;
                $loanreturn = 0;
            } 
            
            if($loancleared){
                // $seize = $seizeloancleared->seize;
            //     if ($guarid) {
            //         $budgetguar = $guarloancleared;
            //         $budgetmidclear = $loanclearedYes;
            //         $budgetclear = $loanclearedNo + $budgetmidclear - ($budgetguar);
                    
            //    } else {
            //     $budgetclear = $loancleared->return;
            //     $clearguarmine = 0;
            //    }
               $budgetclear = $loancleared->return;
                $clearguarmine = 0;
            } else{
                $budgetclear = 0;
                $clearguarmine = 0;
            }
            // $seize = $seizeloancleared->seize;
            // $budgetguar = $guarloancleared->g_amount;
            // $budgetmidclear = $loancleared->return;
            // if(($loancleared)&&($seize == "YES")){
            //     // $budgetguar = $loanclearguar->g_amount;
            //     // $budgetmidclear = $loanclear->return;
            //     $budgetclear = $budgetmidclear - ($budgetguar);
            //     // $budgetclear = $loanclear;
            //     $clearguarmine = $amguarloancleared;
            // } 
            // else {
            //     $budgetclear = $loancleared;
            //     $clearguarmine = 0;
            // }
            
            $expenditure = collect([
                                    $sumlatepayment,
                                    $sumlatemeeting,
                                    $sumabsenteeism,
                                    $summarriage,
                                    $sumbirth,
                                    $sumgraduation,
                                    $sumconsecration,
                                    $sumsickness,
                                    $sumdeath
                                ])->sum(); //loan liability
            $amountdue = $sumcontribution - ($expenditure + $budgetclear + $clearguarmine);
            
            $financialStartYear = date(explode("-", $request->selectedYear)["0"]);
            $financialEndYear = date(explode("-", $request->selectedYear)["1"]);
            $currentYear = date("Y");
            if ($financialEndYear == $currentYear || $financialStartYear == $currentYear){
                $financialEndYear = date("Y-m-d");
                $start = Carbon::createFromFormat('Y-m-d H:s:i',  $financialStartYear.'-04-01 00:00:00');
                $end = Carbon::createFromFormat('Y-m-d H:s:i',   $financialEndYear.' 00:00:00');
                $diff_in_months = $start->diffInMonths($end)+1;
            }else{
                $financialEndYear = $financialEndYear."-06-31";
                $start = Carbon::createFromFormat('Y-m-d H:s:i',  $financialStartYear.'-04-01 00:00:00');
                $end = Carbon::createFromFormat('Y-m-d H:s:i',   $financialEndYear.' 00:00:00');
                $diff_in_months = $start->diffInMonths($end);
               
            }
            $Expected_savings = $diff_in_months*300000;
            // - $amountdue
            $Arrears = $Expected_savings - $amountdue;
            $percentage = 90;
            $percent_of_expected = ($percentage / 100) * $Expected_savings;
            
            if($Arrears < 0){
                $payout_amount = -($Arrears) + $percent_of_expected;
            }else{
                $percentage = 90;
                $payout_amount = ($percentage / 100) * $amountdue;
            }
            $savings = DB::table("savings")
                ->whereBetween('savings.date', [$startYear, $endYear])
                ->where("savings.name_id", "=", $inputs['cat_id'])
                ->join("users", "savings.name_id", "=", "users.id")
                ->select(
                    "savings.id",
                    "savings.monthly_contribution",
                    "savings.created_at",
                    "savings.late_payment",
                    "savings.late_meeting",
                    "savings.absenteeism",
                    "savings.marriage",
                    "savings.birth",
                    "savings.graduation",
                    "savings.consecration",
                    "savings.sickness",
                    "savings.death",
                    "savings.total_amount",
                    "savings.name_id",
                    "users.name"
                )
                ->orderBy("created_at", "desc")->distinct()->get();
            return response()->json([
                "savings" => $savings,
                "loan" => $budget,
                "loanreturn" => $loanreturn,
                "guarantor" => $approveguarmine,
                "Expenditure" =>  $expenditure,
                "Amountdue" => $amountdue,
                "Expected" =>  $Expected_savings,
                "percent" => $percent_of_expected,
                "Arrears" => $Arrears,
                "Payout" => $payout_amount
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
   
    // savings/view
    public function fetch(Request $request)
    {
        $inputs = $request->all();
        try {
            $savings = DB::table("savings")
                ->where("savings.name_id", "=", $inputs['cat_id'])
                ->join("users", "savings.name_id", "=", "users.id")
                ->select(
                    "savings.id",
                    "savings.monthly_contribution",
                    "savings.created_at",
                    "savings.late_payment",
                    "savings.late_meeting",
                    "savings.absenteeism",
                    "savings.marriage",
                    "savings.birth",
                    "savings.graduation",
                    "savings.consecration",
                    "savings.sickness",
                    "savings.death",
                    "savings.total_amount",
                    "savings.name_id",
                    "users.name"
                )
                ->orderBy("created_at", "desc")->distinct()->get();
            return response()->json($savings);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function fetchname(Request $request)
    {
        $inputs = $request->all();
        try {
            $mainuser = User::where("users.id", "=", $inputs['category'])->pluck("name");
            $usernames = DB::table("users")
                ->where("users.id", "=", $inputs['category'])
                ->select(
                    "users.name",
                    "users.userType",
                    "users.fwpnumber"
                )
                ->orderBy("created_at", "desc")->distinct()->get();
            return response()->json([
                  "allusernames" => $usernames,
                  "username" =>$mainuser
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function fetchnamemodal(Request $request)
    {
        $inputs = $request->all();
        try {
            $mainuser = User::where("users.id", "=", $inputs['cate'])->pluck("name");
            $usernames = DB::table("users")
                ->where("users.id", "=", $inputs['cate'])
                ->select(
                    "users.name",
                    "users.userType",
                    "users.fwpnumber"
                )
                ->orderBy("created_at", "desc")->distinct()->get();
            return response()->json([
                  "allusernames" => $usernames,
                  "username" =>$mainuser
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function fetchmembername(Request $request)
    {
        $inputs = $request->all();
        try {
            $mainuser = User::where("users.id", "=", $inputs['savingscate'])->pluck("name");
            $usernames = DB::table("users")
                ->where("users.id", "=", $inputs['savingscate'])
                ->select(
                    "users.name",
                    "users.userType",
                    "users.fwpnumber"
                )
                ->orderBy("created_at", "desc")->distinct()->get();
            return response()->json([
                  "allusernames" => $usernames,
                  "username" =>$mainuser
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
 
    public function retrievePdf(Request $request){
        $inputs = $request->all();
        $startDate = $inputs["month1"];
        $endDate = $inputs["month2"];
        try {
            $mainuser = $inputs["fwpnamemodal"];
            $fwpnumber = User::where("users.id", "=", $inputs['cate'])->value("fwpnumber");
            $yearTotal =Savings::whereBetween('savings.created_at', [$startDate, $endDate])
                        ->where("savings.name_id", "=", $inputs['cate'])->sum('monthly_contribution');
            $savings = DB::table("savings")
                        ->whereBetween("savings.created_at", [$startDate, $endDate])
                        ->where("savings.name_id", "=", $inputs['cate'])
                        ->join("users", "savings.name_id", "=", "users.id")
                        ->select(
                            "savings.id",
                            "savings.monthly_contribution",
                            "savings.created_at",
                            "savings.late_payment",
                            "savings.late_meeting",
                            "savings.absenteeism",
                            "savings.marriage",
                            "savings.birth",
                            "savings.date",
                            "savings.graduation",
                            "savings.consecration",
                            "savings.sickness",
                            "savings.death",
                            "savings.total_amount",
                            "savings.user_id",
                            "users.name",
                            "users.fwpnumber",
                        )->orderBy("created_at", "desc")->get();
            $pdf = PDF::loadView(
                "savings.savingsPdf",
                [
                    "savings_collection" =>  $savings,
                    "yearTotal" => $yearTotal,
                    "year1" => $inputs["month1"],
                    "year2" => $inputs["month2"],
                    "name" => $mainuser,
                    "fwpnumber" => $fwpnumber
                ]
            );
        return $pdf->stream('fwpassociation-savings.pdf');
        } catch (QueryException $th) {
            throw $th;
        }
        
    }

    public function fetchAreasnot(Request $request){
        $startYear = date("2018-04-10");
        $endYear = date("Y-06-10");
        $inputs = $request->all();
        try {
            $sumcontribution = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['savingscate'])->sum('monthly_contribution');
            $sumlatepayment = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['savingscate'])->sum('late_payment');
            $sumlatemeeting = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['savingscate'])->sum('late_meeting');
            $sumabsenteeism = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['savingscate'])->sum('absenteeism');
            $summarriage = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['savingscate'])->sum('marriage');
            $sumbirth = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", $inputs['savingscate'])->sum('birth');
            $sumgraduation = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['savingscate'])->sum('graduation');
            $sumconsecration = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['savingscate'])->sum('consecration');
            $sumsickness = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['savingscate'])->sum('sickness');
            $sumdeath = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", $inputs['savingscate'])->sum('death');
            $loan = Loans::where("loans.user_id", "=", $inputs["savingscate"])
                                ->join("users", "loans.user_id", "=", "users.id")
                                ->where("loans.status", "=", "Approved")
                            ->orderBy('loans.id', 'desc')->get("loans.loanamount")->first();
            if($loan){
                
                $budget = $loan->loanamount;
               
            }else{
                $budget = 0;
            } 
                        
    
            $expenditure = collect([
                                    $sumlatepayment,
                                    $sumlatemeeting,
                                    $sumabsenteeism,
                                    $summarriage,
                                    $sumbirth,
                                    $sumgraduation,
                                    $sumconsecration,
                                    $sumsickness,
                                    $sumdeath
                                ])->sum(); //loan liability

            $amountdue = $sumcontribution - ($expenditure + $budget);
            $financialStartYear = date(2018);
            $financialEndYear = date("Y");
            $currentYear = date("Y");
            if ($financialEndYear == $currentYear || $financialStartYear == $currentYear){
                $financialEndYear = date("Y-m-d");
                $start = Carbon::createFromFormat('Y-m-d H:s:i',  $financialStartYear.'-04-01 00:00:00');
                $end = Carbon::createFromFormat('Y-m-d H:s:i',   $financialEndYear.' 00:00:00');
                $diff_in_months = $start->diffInMonths($end)+1;
            }else{
                $financialEndYear = $financialEndYear."-06-31";
                $start = Carbon::createFromFormat('Y-m-d H:s:i',  $financialStartYear.'-04-01 00:00:00');
                $end = Carbon::createFromFormat('Y-m-d H:s:i',   $financialEndYear.' 00:00:00');
                $diff_in_months = $start->diffInMonths($end);
               
            }
            $Expected_savings = $diff_in_months*300000;
            
            $Arrears = $Expected_savings - $amountdue;
            $percentage = 90;
            $percent_of_expected = ($percentage / 100) * $Expected_savings;
            if($Arrears < 0){
                $payout_amount = -($Arrears) + $percent_of_expected;
            }else{
                $payout_amount = $percent_of_expected - $Arrears;
            }
            return response()->json([
                "Arrears" => $Arrears,
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
}
