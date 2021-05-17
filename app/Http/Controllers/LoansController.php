<?php

namespace App\Http\Controllers;

use App\Savings;
use App\User;
use App\Loans;
use App\Expenses;
use App\Guarantors;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::all();
        return view('Loans.loanrequest')->with("users", $users);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchamount(Request $request)
    {
        $startYear = date("2018-04-10");
        $endYear = date("Y-06-10");
        $inputs = $request->all();
        try {
            $sumcontribution = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", Auth::user()->id)->sum('monthly_contribution');
            $sumlatepayment = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", Auth::user()->id)->sum('late_payment');
            $sumlatemeeting = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", Auth::user()->id)->sum('late_meeting');
            $sumabsenteeism = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", Auth::user()->id)->sum('absenteeism');
            $summarriage = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", Auth::user()->id)->sum('marriage');
            $sumbirth = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", Auth::user()->id)->sum('birth');
            $sumgraduation = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", Auth::user()->id)->sum('graduation');
            $sumconsecration = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", Auth::user()->id)->sum('consecration');
            $sumsickness = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", Auth::user()->id)->sum('sickness');
            $sumdeath = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", Auth::user()->id)->sum('death');
            $loan = Loans::where("loans.user_id", "=", Auth::user()->id)
                                ->join("users", "loans.user_id", "=", "users.id")
                                ->where("loans.status", "=", "Approved")
                            ->orderBy('loans.id', 'desc')->get("loans.loanamount")->first();
            $loancleared = Loans::where("loans.user_id", "=", Auth::user()->id)
                            ->whereBetween('loans.created_at', [$startYear, $endYear])
                             ->join("users", "loans.user_id", "=", "users.id")
                             ->where("loans.status", "=", "cleared")
                            //  ->orderBy('loans.id', 'desc')->get("loans.return")->first();
                             ->sum("return");                  
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

            $amountdue = $sumcontribution - ($expenditure + $loancleared);
            return response()->json([
                "total_amount" => $amountdue,
            ]);
            } catch (QueryException $th) {
                throw $th;
            }
    }
    public function fetchsubmem(Request $request)
    {
        $startYear = date("2018-04-10");
        $endYear = date("Y-06-10");
        $inputs = $request->all();
        try {
            $sumcontribution = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['submem'])->sum('monthly_contribution');
            $sumlatepayment = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['submem'])->sum('late_payment');
            $sumlatemeeting = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['submem'])->sum('late_meeting');
            $sumabsenteeism = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['submem'])->sum('absenteeism');
            $summarriage = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['submem'])->sum('marriage');
            $sumbirth = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", $inputs['submem'])->sum('birth');
            $sumgraduation = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['submem'])->sum('graduation');
            $sumconsecration = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                        ->where("savings.name_id", "=", $inputs['submem'])->sum('consecration');
            $sumsickness = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                    ->where("savings.name_id", "=", $inputs['submem'])->sum('sickness');
            $sumdeath = Savings::whereBetween('savings.date', [$startYear, $endYear])
                                ->where("savings.name_id", "=", $inputs['submem'])->sum('death');
            $loan = Loans::where("loans.user_id", "=", $inputs["submem"])
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
            return response()->json([
                "total_amount2" => $amountdue,
        ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            // "mem" => "required",
            "total-amount" => "required|numeric",
            "expected_loan" => "required|numeric",
            "loan_limit" => "required|numeric",
            "loan_amount" => "required|numeric",
            // "submem" => "required",
            "total-amount2" => "required|numeric",
            "expected" => "required|numeric",
            // "g_amount" => "required|numeric",
            "fee" => "required|numeric",
            "months_taken" => "required|numeric",
            "return" => "required|numeric",
            "desc" => "required",
            // "seize" => "accepted"
        ]);
        $inputs = $request->all();
        $user = User::findOrFail(Auth()->user()->id);
        
        $userObject = User::findOrFail(Auth()->user()->id);
        $loanamount = $inputs["loan_amount"];
        $loanlimit = $inputs["expected_loan"];
        $months_taken = $inputs["months_taken"];
        $current = date("Y-m-d");
        $last_payment = Carbon::parse($current)->addMonths($months_taken)->format("Y-m-d");
        
        if ($loanamount < $loanlimit) {
            $userObject2 = "NONE";
            $loanamount2 = 0;
            $g_amount = 0;
            $last_payment2 = 0;
            $lily = "NONE";
            $lily2 = "NONE";
            $gstatus = "NONE";
            $status = "pending";

        }else {
            $userObject = User::findOrFail(Auth()->user()->id);
            $userob = User::findOrFail($inputs["submem"]);
            $userObject2 = $userObject->name;
            $loanamount2 = $inputs["loan_amount"];
            $g_amount = $inputs["g_amount"];
            $last_payment2 =  $last_payment;
            $lily = $userob->id;
            $lily2 =$userob->name;
            $gstatus = "pending";
            $status = "waiting";
        }

       


            try {
                
                $user->loans()->save(
                    new Loans([
                        // "mem" => $inputs["mem"],
                        "name" => $userObject->name,
                        "totalamountdue" => $inputs["total-amount"],
                        "loan_semilimit" => $loanlimit,
                        "loan_limit" => $inputs["loan_limit"],
                        "loanamount" => $loanamount,
                        "processingfee" => $inputs["fee"],
                        "monthstaken" => $months_taken,
                        "return" => $inputs["return"],
                        "desc" => $inputs["desc"],
                        "quarantor" =>$lily,
                        "name_quarantor" =>$lily2,
                        "g_amount" => $g_amount,
                        "last_payment" => $last_payment,
                        "guarantorstatus" => $gstatus,
                        "status" => $status,
                        "seize" => "NO",
                        "reason" => "not cancelled"
                    ])
                );
                
                $user->guarantors()->save(
                    new Guarantors([
                        "name" => $userObject2,
                        "loanamount" => $loanamount2,
                        "quarantor" =>$lily,
                        "total-amount2" => $inputs["total-amount2"],
                        "expected" => $inputs["expected"],
                        "last_payment" => $last_payment2,
                        "g_amount" => $g_amount,
                        "status" => $gstatus
                    ])
                );
                return response()->json([
                    "msg" => "Loan Saved Successfully"
                ]);
            } catch (QueryException $th) {
                throw $th;
            }
    }
    public function pending()
    {
        return view('Loans.pendingloan');
    }
    public function fetch(Request $request)
    {
        $inputs = $request->all();
        try {
            $loans = DB::table("loans")
            ->where("loans.created_at", "LIKE", "{$inputs['date']}-%")
            ->where("user_id", "=", Auth::user()->id)
            ->join("users", "loans.user_id", "=", "users.id")
            ->select(
                "loans.id",
                "loans.desc",
                "loans.created_at",
                "loans.loanamount",
                "loans.totalamountdue",
                "loans.loan_semilimit",
                "loans.loan_limit",
                "loans.monthstaken",
                "loans.processingfee",
                "loans.return",
                "loans.quarantor",
                "loans.name_quarantor",
                "loans.guarantorstatus",
                "loans.g_amount",
                "loans.last_payment",
                "loans.status",
                "loans.seize",
                "loans.user_id",
                "loans.reason",
                "users.name",
                "users.fwpnumber",
                "users.userType"
            )
            ->orderBy("created_at", "desc")->get();
            return response()->json($loans);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function fetchguarantors(Request $request)
    {
        $inputs = $request->all();
        $user = User::findOrFail(Auth::user()->id);
        try {
            $loans = DB::table("guarantors")
            ->where("guarantors.created_at", "LIKE", "{$inputs['date']}-%")
            ->where("quarantor", "=", Auth::user()->id)
            ->where("guarantors.status", "=", "pending")
            ->join("users", "guarantors.quarantor", "=", "users.id")
            ->select(
                "guarantors.id",
                "guarantors.user_id",
                "guarantors.created_at",
                "guarantors.loanamount",
                "guarantors.g_amount",
                "guarantors.last_payment",
                "guarantors.name",
                "guarantors.status",
                // "users.name",
                "users.userType"
            )
            ->orderBy("created_at", "desc")->distinct()->get();
            return response()->json($loans);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    // correct
    public function guarantordecline(Request $request)
    {

        $inputs = $request->all();
        try {
            Guarantors::where("id", "=", $inputs["id"])->update([
                "status" => "declined"
            ]);
            Loans::where("id", "=", $inputs["id"])->update([
                "guarantorstatus" => "declined"
            ]);
            //returning pending Expenses
            return response()->json([
                "msg" => "Decline is Successful"
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    // correct
    public function guarantorapprove(Request $request)
    {
        $inputs = $request->all();
        try {
            Guarantors::where("id", "=", $inputs['id'])->update([
                "status" => $inputs['guarantor-action'],
            ]);
            Loans::where("id", "=", $inputs["id"])->update([
                "guarantorstatus" => $inputs['guarantor-action'],
                "status" => "pending",
            ]);
            return response()->json(["msg" => "Operation Successfull"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function clearloan(Request $request)
    {
        
        $inputs = $request->all();
            try {
                $loan = DB::table("loans")->where("id", "=", $inputs["id"])->update([
                    "monthstaken" => $inputs["updatemonths_taken"],
                    "return" => $inputs["update_return"],
                    // "seize" => $inputs["seize"],
                    "status" => "cleared",
                ]);
            return response()->json(["msg" => "Operation Successfull"]);
        }  catch (QueryException $th) {
            throw $th;
        }
      
       
    }

    public function cleared()
    {
        return view('Loans.cleared');
    }
    public function declineloan(Request $request)
    {
        
        $inputs = $request->all();
        try {
            Loans::where("id", "=", $inputs["id"])->update([
                "status" => "cancelled"
            ]);
            //returning pending loan
            return $this->fetch();
        } catch (QueryException $th) {
            throw $th;
        }
    }

    // correct
    public function edit($id, Request $request)
    {
        $this->validate($request, [
            // "mem" => "required",
            "total-amount" => "required|numeric",
            "expected_loan" => "required|numeric",
            "loan_amount" => "required|numeric",
            // "submem" => "required",
            "total-amount2" => "required|numeric",
            "expected" => "required|numeric",
            // "g_amount" => "required|numeric",
            "fee" => "required|numeric",
            "months_taken" => "required|numeric",
            "return" => "required|numeric",
            "desc" => "required"

        ]);
        $inputs = $request->all();
        $user = User::findOrFail(Auth()->user()->id);
        $userObject = User::findOrFail(Auth()->user()->id);
        $loanamount = $inputs["loan_amount"];
        $loanlimit = $inputs["expected_loan"];
        $months_taken = $inputs["months_taken"];
        $current = date("Y-m-d");
        $last_payment = Carbon::parse($current)->addMonths($months_taken)->format("Y-m-d");
        
        try {

            if ($loanamount < $loanlimit) {
                $userObject2 = "NONE";
                $loanamount2 = 0;
                $g_amount = 0;
                $last_payment2 = 0;
                $lily = "NONE";
                $lily2 = "NONE";
                $gstatus = "NONE";
                $status = "pending";
    
            }else {
                $userObject = User::findOrFail(Auth()->user()->id);
                $userob = User::findOrFail($inputs["submem"]);
                $userObject2 = $userObject->name;
                $loanamount2 = $inputs["loan_amount"];
                $g_amount = $inputs["g_amount"];
                $last_payment2 =  $last_payment;
                $lily = $userob->id;
                $lily2 =$userob->name;
                $gstatus = "pending";
                $status = "waiting";

            }
           
            $user->loans()->where("id", "=", $id)->update([
                // "mem" => $inputs["mem"],
                "name" => $userObject->name,
                "totalamountdue" => $inputs["total-amount"],
                "loan_semilimit" => $loanlimit,
                "loan_limit" => $inputs["loan_limit"],
                "loanamount" => $loanamount,
                "quarantor" => $lily,
                "processingfee" => $inputs["fee"],
                "monthstaken" => $months_taken,
                "return" => $inputs["return"],
                "desc" => $inputs["desc"],
                "quarantor" =>$lily,
                "name_quarantor" =>$lily2,
                "guarantorstatus" => $gstatus,
                "g_amount" => $g_amount,
                "last_payment" => $last_payment,
                "status" => $status,
                "seize" => "NO"
            ]);

            $user->guarantors()->where("id", "=", $id)->update([
                    "name" => $userObject2,
                    "loanamount" => $loanamount2,
                    "quarantor" =>$lily,
                    "total-amount2" => $inputs["total-amount2"],
                    "expected" => $inputs["expected"],
                    "last_payment" => $last_payment2,
                    "g_amount" => $g_amount,
                    "status" => $gstatus

            ]);
            return response()->json(["msg" => "Operation successfully"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    // correct
    public function destroy(Request $request)
    {
        $inputs = $request->all();
        $user = User::findOrFail(Auth::user()->id);
       
            try {
                $user->loans()->where("id", "=", $inputs['id'])->delete();
                $user->guarantors()->where("id", "=", $inputs['id'])->delete();
                return response()->json(["msg"=> "Deleted Successfully"]);
            } catch (QueryException $th) {
                throw $th;
            }
      
    }

    public function loanaction(Request $request)
    {
        $inputs = $request->all();
        try {
            Loans::where("id", "=", $inputs['id'])->update([
                "status" => $inputs['loanaction'],
                "reason" => $inputs['reason']
            ]);
           
            return response()->json(["msg" => "Operation Successfull"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function fetchpending(Request $request)
    {
        $inputs = $request->all();
        $Allexpenses = DB::table("expenses")->where("expenses.status", "=", "approved")->sum("budget");
        $saved = Savings::sum("monthly_contribution");
        $sumlatepayment = Savings::sum("late_payment");
        $sumlatemeeting = Savings::sum("late_meeting");
        $sumabsenteeism = Savings::sum("absenteeism");
        $summarriage = Savings::sum("marriage");
        $sumbirth = Savings::sum("birth");
        $sumgraduation = Savings::sum("graduation");
        $sumconsecration = Savings::sum("consecration");
        $sumsickness = Savings::sum("sickness");
        $sumdeath = Savings::sum("death");
        $total_expenditure = collect([
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
        $runningloan = Loans::where("loans.created_at", "LIKE", "{$inputs['date']}-%")
                            ->where("loans.status", "=", "approved")->sum("loanamount");
                         
        $borrowable = $saved - ($Allexpenses + $total_expenditure + $runningloan + 2000000);                    
        try {

            $loans = Loans::where("loans.status", "=", "pending")
                    ->where(function ($query) {
                        $query->where("loans.guarantorstatus", "=", "NONE");
                        $query->orWhere("loans.guarantorstatus", "=", "approved");
                    })
                    ->where("loans.created_at", "LIKE", "{$inputs['date']}-%")
                    ->join("users", "loans.user_id", "=", "users.id")
                    ->select(
                        "loans.id",
                        "loans.desc",
                        "loans.created_at",
                        "loans.loanamount",
                        "loans.monthstaken",
                        "loans.processingfee",
                        "loans.name_quarantor",
                        "loans.guarantorstatus",
                        "loans.g_amount",
                        "loans.last_payment",
                        "loans.return",
                        "loans.quarantor",
                        "loans.status",
                        "loans.seize",
                        "loans.user_id",
                        "loans.reason",
                        "users.name",
                        "users.fwpnumber",
                        "users.userType"
                    )
                    ->orderBy("created_at", "desc")->get();  
                    return response()->json([
                        "loans" => $loans,
                        "borrow" => $borrowable,
                        "runningloan" => $runningloan,
                        "saved" => $saved
                    ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function recommend()
    {
        return view('Loans.recommendedloan');
    }

    public function fetchRecoLoan(Request $request)
    {
        $inputs = $request->all();
        try {
            $expenses = DB::table("loans")
            ->where("loans.created_at", "LIKE", "{$inputs['date']}-%")
            ->where("loans.status", "=", "recommend")
            ->join("users", "loans.user_id", "=", "users.id")
            ->select(
                "loans.id",
                "loans.desc",
                "loans.created_at",
                "loans.loanamount",
                "loans.monthstaken",
                "loans.processingfee",
                "loans.return",
                "loans.quarantor",
                "loans.name_quarantor",
                "loans.g_amount",
                "loans.last_payment",
                "loans.status",
                "loans.seize",
                "loans.user_id",
                "loans.reason",
                "users.name",
                "users.fwpnumber",
                "users.userType"
            )
                ->orderBy("created_at", "desc")->get();
            return response()->json($expenses);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function allLoans()
    {
        return view('Loans.index');
    }
    
    public function fetchAll(Request $request){
        $inputs = $request->all();
        try {
            $monthTotal = Loans::where("created_at", "LIKE", $inputs['date']."-%")
                    ->where("status", "=", "approved")->sum('loanamount');
            $yearTotal = Loans::where("created_at", "LIKE", explode("-", $inputs['date'])[0] . "-%")
                ->where("status", "=", "approved")->sum('loanamount');
            $loans = DB::table("loans")
            ->where("loans.created_at", "LIKE", "{$inputs['date']}%")
            ->join("users", "loans.user_id", "=", "users.id")
            ->where("loans.status", "=", "approved")
            ->select(
                "loans.id",
                "loans.desc",
                "loans.created_at",
                "loans.loanamount",
                "loans.monthstaken",
                "loans.processingfee",
                "loans.return",
                "loans.quarantor",
                "loans.name_quarantor",
                "loans.g_amount",
                "loans.last_payment",
                "loans.status",
                "loans.user_id",
                "users.name",
                "users.fwpnumber",
                "users.userType"
            )
                ->orderBy("created_at", "desc")->get();
            return response()->json([
                "loans" => $loans,
                "totalYear" => $yearTotal,
                "totalMonth" => $monthTotal
                ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function fetchCleared(Request $request){
        $inputs = $request->all();
        try {
            
            $monthTotal = Loans::where("created_at", "LIKE", $inputs['date']."-%")
                    ->where("status", "=", "cleared")->sum('loanamount');
            $yearTotal = Loans::where("created_at", "LIKE", explode("-", $inputs['date'])[0] . "-%")
                ->where("status", "=", "cleared")->sum('loanamount');
            $loans = DB::table("loans")
            ->where("loans.created_at", "LIKE", "{$inputs['date']}%")
            ->join("users", "loans.user_id", "=", "users.id")
            ->where("loans.status", "=", "cleared")
            ->select(
                "loans.id",
                "loans.desc",
                "loans.created_at",
                "loans.loanamount",
                "loans.monthstaken",
                "loans.processingfee",
                "loans.return",
                "loans.quarantor",
                "loans.name_quarantor",
                "loans.g_amount",
                "loans.status",
                "loans.seize",
                "loans.user_id",
                "users.name",
                "users.fwpnumber",
                "users.userType"
            )
                ->orderBy("created_at", "desc")->get();
            return response()->json([
                "loans" => $loans,
                "totalYear" => $yearTotal,
                "totalMonth" => $monthTotal
                ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function printPdf(Request $request){
        $inputs = $request->all();
        try {
            $yearTotal = Loans::where("created_at", "LIKE", $inputs['year'] . "-%")
                ->where("status", "=", "cleared")->sum('return');
            $yearTotal2 = Loans::where("created_at", "LIKE", $inputs['year'] . "-%")
                ->where("status", "=", "cleared")->sum('loanamount');
            $profityear = $yearTotal - $yearTotal2;    
                $collection = collect();
            for ($i=1; $i <= 12; $i++) {
                if ($i<10) {
                    $yearMonth = $inputs['year'].'-0'.$i;
                    $monthTotal = Loans::where("created_at", "LIKE", $yearMonth . "%")
                    ->where("status", "=", "cleared")->sum('return');
                    $monthTotal2 = Loans::where("created_at", "LIKE", $yearMonth . "%")
                    ->where("status", "=", "cleared")->sum('loanamount');
                    $profit =  $monthTotal - $monthTotal2;
                    $loans = DB::table("loans")
                    ->where("loans.created_at", "LIKE", "{$yearMonth}%")
                    ->where("loans.status", "=", "cleared")
                    ->join("users", "loans.user_id", "=", "users.id")
                    ->select(
                        "loans.id",
                        "loans.desc",
                        "loans.created_at",
                        "loans.loanamount",
                        "loans.monthstaken",
                        "loans.processingfee",
                        "loans.return",
                        "loans.quarantor",
                        "loans.name_quarantor",
                        "loans.g_amount",
                        "loans.status",
                        "loans.seize",
                        "loans.user_id",
                        "users.name",
                        "users.userType"
                    )->orderBy("created_at", "desc")->get();
                    if (!$loans->isEmpty()) {
                        $collection->push((object)[
                            "month" => "0".$i,
                            "monthTotal"=>$monthTotal,
                            "monthTotal2" =>$monthTotal2,
                            "loans" => $loans,
                            "profit" => $profit
                        ]);
                    }
                }
                else{
                    $yearMonth = $inputs['year'] . '-' . $i;
                    $monthTotal = Loans::where("created_at", "LIKE", $yearMonth ."%")
                    ->where("status", "=", "cleared")->sum('return');
                    $monthTotal2 = Loans::where("created_at", "LIKE", $yearMonth . "%")
                    ->where("status", "=", "cleared")->sum('loanamount');
                    $profit =  $monthTotal - $monthTotal2;
                    $loans = DB::table("loans")
                    ->where("loans.created_at", "LIKE", "{$yearMonth}%")
                    ->where("loans.status", "=", "cleared")
                    ->join("users", "loans.user_id", "=", "users.id")
                    ->select(
                        "loans.id",
                        "loans.desc",
                        "loans.created_at",
                        "loans.loanamount",
                        "loans.monthstaken",
                        "loans.processingfee",
                        "loans.return",
                        "loans.quarantor",
                        "loans.name_quarantor",
                        "loans.g_amount",
                        "loans.status",
                        "loans.user_id",
                        "users.name",
                        "users.userType"
                    )->orderBy("created_at", "desc")->get();
                    if(!$loans->isEmpty()){
                        $collection->push((object)[
                            "month"=>$i,
                            "monthTotal"=>$monthTotal,
                            "monthTotal2" =>$monthTotal2,
                            "loans"=>$loans,
                            "profit" => $profit
                        ]);
                    }
                    
                }
            }
                $pdf = PDF::loadView(
                    "loans.loansPdf",
                    [
                        "collection" => $collection,
                        "yearTotal" => $yearTotal,
                        "yearTotal2" => $yearTotal2,
                        "profityear" => $profityear,
                        "year" => $inputs['year']
                    ]
                );
            
            return $pdf->stream('fwpassociation-loans.pdf');
        } catch (QueryException $th) {
            throw $th;
        }
    }
    public function print(Request $request){
        $inputs = $request->all();
        $startDate = $inputs["month1"];
        $endDate = $inputs["month2"];
        
        try {
            $yearTotal = Loans::whereBetween("created_at", [ $startDate, $endDate])
                ->where("status", "=", "cleared")->sum('return');
            $yearTotal2 = Loans::whereBetween("created_at", [$startDate, $endDate])
                ->where("status", "=", "cleared")->sum('loanamount');
            $profityear = $yearTotal - $yearTotal2;
                    $loans = DB::table("loans")
                    ->whereBetween("loans.created_at", [$startDate, $endDate])
                    ->where("loans.status", "=", "cleared")
                    ->join("users", "loans.user_id", "=", "users.id")
                    ->select(
                        "loans.id",
                        "loans.desc",
                        "loans.created_at",
                        "loans.loanamount",
                        "loans.monthstaken",
                        "loans.processingfee",
                        "loans.return",
                        "loans.quarantor",
                        "loans.name_quarantor",
                        "loans.g_amount",
                        "loans.status",
                        "loans.seize",
                        "loans.user_id",
                        "users.name",
                        "users.fwpnumber",
                        "users.userType"
                    )->orderBy("created_at", "desc")->get();
                   
                $pdf = PDF::loadView(
                    "loans.loansPdf",
                    [
                        "loan_collection" =>$loans,
                        "yearTotal" => $yearTotal,
                        "yearTotal2" => $yearTotal2,
                        "profityear" => $profityear,
                        "year1" => $inputs['month1'],
                        "year2" => $inputs['month2']
                    ]
                );
            return $pdf->stream('fwpassociation-loans.pdf');
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function printApproved(Request $request){
        $inputs = $request->all();
        $startDate = $inputs["date1"];
        $endDate = $inputs["date2"];
        
        try {
            $yearTotal = Loans::whereBetween("created_at", [ $startDate, $endDate])
                ->where("status", "=", "approved")->sum('return');
            $yearTotal2 = Loans::whereBetween("created_at", [$startDate, $endDate])
                ->where("status", "=", "approved")->sum('loanamount');
            $profityear = $yearTotal - $yearTotal2;
                    $loans = DB::table("loans")
                    ->whereBetween("loans.created_at", [$startDate, $endDate])
                    ->where("loans.status", "=", "approved")
                    ->join("users", "loans.user_id", "=", "users.id")
                    ->select(
                        "loans.id",
                        "loans.desc",
                        "loans.created_at",
                        "loans.loanamount",
                        "loans.monthstaken",
                        "loans.processingfee",
                        "loans.return",
                        "loans.quarantor",
                        "loans.name_quarantor",
                        "loans.g_amount",
                        "loans.status",
                        "loans.seize",
                        "loans.user_id",
                        "users.name",
                        "users.fwpnumber",
                        "users.userType"
                    )->orderBy("created_at", "desc")->get();
                   
                $pdf = PDF::loadView(
                    "loans.Approvedloanpdf",
                    [
                        "loan_collection" =>$loans,
                        "yearTotal" => $yearTotal,
                        "yearTotal2" => $yearTotal2,
                        "profityear" => $profityear,
                        "year1" => $inputs['date1'],
                        "year2" => $inputs['date2']
                    ]
                );
            return $pdf->stream('fwpassociation-loans.pdf');
        } catch (QueryException $th) {
            throw $th;
        }
    }
   

}
