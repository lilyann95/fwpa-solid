<?php

namespace App\Http\Controllers;

use App\Expenses;
use App\User;
use App\Savings;
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
   
    // public function edit($id, Request $request)
    // {
    //     $this->validate($request, [
    //         "contribution" => "required|numeric",
    //         "latepay" => "required|numeric",
    //         "latemeeting" => "required|numeric",
    //         "absent" => "required|numeric",
    //         "marriage" => "required|numeric",
    //         "birth" => "required|numeric",
    //         "grad" => "required|numeric",
    //         "cons" => "required|numeric",
    //         "sick" => "required|numeric",
    //         "death" => "required|numeric"
    //     ]);
    //     $inputs = $request->all();
    //     $user = User::findOrFail(Auth::user()->id);
    //     try {
    //         $user->savings()->where("id", "=", $id)->update([
    //             "contribution" => $inputs["contribution"],
    //             "latepay" => $inputs["latepay"],
    //             "latemeeting" => $inputs["latemeeting"],
    //             "absent" => $inputs["absent"],
    //             "marriage" => $inputs["marriage"],
    //             "birth" => $inputs["birth"],
    //             "grad" => $inputs["grad"],
    //             "cons" => $inputs["cons"],
    //             "sick" => $inputs["sick"],
    //             "death" => $inputs["death"]
    //         ]);
    //         return response()->json(["msg" => "Operation successfully"]);
    //     } catch (QueryException $th) {
    //         throw $th;
    //     }
    // }
    public function view()
    {
        $users = User::all();
        return view('savings.view')->with("users", $users);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
             "cate" => "required",
            "monthly_contribution" => "required|numeric",
            // "late_payment" => "required|numeric",
            // "late_meeting" => "required|numeric",
            // "absenteeism" => "required|numeric",
            "marriage" => "required|numeric",
            "birth" => "required|numeric",
            "graduation" => "required|numeric",
            "consecration" => "required|numeric",
            "sickness" => "required|numeric",
            "death" => "required|numeric",
        ]);
        // // dateTime
        // $result = mysql_query("SELECT `datetime` FROM `table`");
        // $row = mysql_fetch_row($result);
        // $date = date_create($row[0]);

        // echo date_format($date, 'F Y');

        // // or
        // $datetime = new DateTime($dateTimeString);
        // echo $datetime->format('w');




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
        
            // Auth::user()->products->sum('price');
        $expense = DB::table("expenses")
                    ->where("expenses.user_id", "=", Auth::user()->id)
                    ->where("expenses.status", "=", "Approved")
                    ->latest()->value('expenses.budget');
        
        $saving =  $inputs["monthly_contribution"]-$savings - $expense;
        
        $name_id = DB::table("users")
                    ->where("name", "=", $inputs['cate'])
                    ->value("id");
           
            try {
            
                $user->savings()->save(
                    new Savings([
                        "name_id" => $name_id,
                        "name" => $inputs['cate'],
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
                        "loan_liability" => $expense,
                        "total_amount" => $saving
                    ])
                );
                return response()->json([
                    "msg" => "Savings Stored Successfully"
                ]);
            } catch (QueryException $th) {
                throw $th;
            }
        
        
    }
    // savings/view
    public function fetchsum(Request $request)
    {
        $inputs = $request->all();
        $name_id = DB::table("users")
                    ->where("id", "=", $inputs['cat_id'])->value("id");

        $savingsyear = DB::table('savings')->value("savings.created_at");
         //check if its in the range
        $start_date = $inputs['date'];
        $end_date = Carbon::createFromFormat('Y-m-d', $dates)->addYear()->subMonth();
       
        $date_from_user = Carbon::createFromFormat('Y-m-d H:i:s', $savingsyear);

        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);
        
        if(($user_ts >= $start_ts) && ($user_ts <= $end_ts)){
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
            try {

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
                $amountdue = $sumcontribution - $expenditure;
                $savings = DB::table("savings")
                ->where("savings.name_id", "LIKE", $name_id . "%")
                ->join("users", "savings.name_id", "=", "users.id")
                ->join("expenses", "expenses.user_id", "=", "savings.name_id")
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
                    "savings.loan_liability",
                    "savings.total_amount",
                    "savings.name_id",
                    "savings.name",
                    // "users.userType"
                )
                    ->orderBy("created_at", "desc")->get();
                return response()->json([
                    "savings" => $savings,
                    "totalYear" => $sumcontribution,
                    "Expenditure" => $expenditure,
                    "Amountdue" => $amountdue
                    ]);
            } catch (QueryException $th) {
                throw $th;
            } 
        }  
    }
// savings/view
    public function fetch(Request $request)
    {
        $inputs = $request->all();
        $name_id = DB::table("users")
                      ->where("id", "=", $inputs['cat_id'])->value("id");
       
        try {
            $savings = DB::table("savings")
                ->where("savings.name_id", "LIKE", $name_id . "%")
                ->join("users", "savings.name_id", "=", "users.id")
                ->join("expenses", "expenses.user_id", "=", "savings.name_id")
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
                    "savings.loan_liability",
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
    //expected deposits in the sidebar
    public function expected_deposits()
    {
        return view('savings.ExpectedDeposits');
    }
    public function createdeposits()
    {
        
        $user = User::findOrFail(Auth::user()->id);
        $inputs = $request->all();
        $Expected_savings = 10200000;

        $expense = DB::table("expenses")
                    ->where("expenses.user_id", "=", Auth::user()->id)
                    ->where("expenses.status", "=", "Approved")
                    ->latest()->value('expenses.budget');
        $months_taken = DB::table("expenses")
                    ->where("expenses.user_id", "=", Auth::user()->id)
                    ->where("expenses.status", "=", "Approved")
                    ->latest()->value('expenses.months_taken');
        $loan_return = $expense * pow(1.05, $months_taken);
        $saving = DB::table("savings")
                    ->where("savings.name_id", "=", Auth::user()->id)
                    ->value('savings.total_amount');

        $arrears = $Expected_savings - $saving;

        function add_months($months, DateTime $dateObject) 
            {
                $next = new DateTime($dateObject->format('Y-m-d'));
                $next->modify('last day of +'.$months.' month');

                if($dateObject->format('d') > $next->format('d')) {
                    return $dateObject->diff($next);
                } else {
                    return new DateInterval('P'.$months.'M');
                }
            }

        function endCycle($d1, $months)
            {
                $date = new DateTime($d1);

                // call second function to add the months
                $newDate = $date->add(add_months($months, $date));

                // goes back 1 day from date, remove if you want same day of month
                $newDate->sub(new DateInterval('P1D')); 

                //formats final date to Y-m-d form
                $dateReturned = $newDate->format('Y-m-d'); 

                return $dateReturned;
            }
        $startDate = DB::table("expenses")
                        ->where("expenses.created_at", "LIKE", "{$inputs['date']}-%")
                        ->where("expenses.user_id", "=", Auth::user()->id)
                        ->where("expenses.status", "=", "Approved")
                        ->latest()->value('expenses.created_at'); // select date in Y-m-d format
        $nMonths = $months_taken; // choose how many months you want to move ahead
        $final = endCycle($startDate, $nMonths); // output: 2014-07-02

        try {
            $user->deposits()->save(
                new Deposits([
                    "total_amount" => $saving,
                    "Expected_savings" =>  $Expected_savings,
                    "Arrears" =>  $arrears,
                    "loan_offered" => $expense,
                    "months_taken" => $months_taken,
                    "loan_return" => $loan_return,
                    "late_paymentdate" => $final
                ])
            );
            return response()->json([
                "msg" => "Deposits Stored Successfully"
            ]);
        } catch (QueryException $th) {
            throw $th;
        }

    }
    public function fetchdeposits()
    {
        $user = User::findOrFail(Auth::user()->id);
       
        $inputs = $request->all();
        try {
            $deposits = DB::table("deposits")
            // ->where("deposits.created_at", "LIKE", "{$inputs['date']}-%")
            ->join("savings", "savings.name_id", "=", "users.id")
            ->join("users", "user_id", "=", Auth::user()->id)
            ->select(
                    "deposits.user_id",
                    "deposits.total_amount",
                    "deposits.Expected_savings",
                    "deposits.Arrears",
                    "deposits.loan_offered",
                    "deposits.months_taken",
                    "deposits.loan_return",
                    "deposits.late_paymentdate",
                    "users.name"
                )
                ->orderBy("created_at", "desc")->get();
            return response()->json($deposits);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    
    public function payout()
    {
        return view('savings.payout');
    }
    public function createpayout()
    {
        $user = User::findOrFail(Auth::user()->id);
        $inputs = $request->all();

        $percentage = 90;
        $Expected_savings = DB::table("deposits")
                ->where("deposits.user_id", "=", Auth::user()->id)
                ->value('deposits.Expected_savings');

        
        $amountdue = ($percentage / 100) * $Expected_savings;
        $Arrears = DB::table("deposits")
                ->where("deposits.user_id", "=", Auth::user()->id)
                ->value('deposits.Arrears');
        $loan_offered = DB::table("deposits")
                ->where("deposits.user_id", "=", Auth::user()->id)
                ->value('deposits.loan_offered');
        $payout_amount = $amountdue + $Arrears;
        try {
            $user->payouts()->save(
                new Payouts([
                    'amount_due' => $Expected_savings,
                    'Exact_amount' => $amountdue,
                    'Arrears' => $Arrears,
                    'loan_offered' => $loan_offered,
                    'payout_amount' => $payout_amount
                   
                ])
            );
            return response()->json([
                "msg" => "Payouts Stored Successfully"
            ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }
    // per year
    public function fetchpayout()
    {
        $user = User::findOrFail(Auth::user()->id);
        $inputs = $request->all();
        try {
            $payouts = DB::table("payouts")
            // ->where("payouts.user_id", "LIKE", Auth::user()->id)
            ->join("users", "payouts.user_id", "=", "users.id")
            ->select(
                "payouts.id",
                'payouts.amount_due',
                'payouts.Exact_amount',
                'payouts.Arrears',
                'payouts.loan_offered',
                'payouts.payout_amount',
                "users.name"
            )
                ->orderBy("created_at", "desc")->get();
            return response()->json($payouts);
        } catch (QueryException $th) {
            throw $th;
        }

        
    }
    public function retrievePdf(Request $request){
        $inputs = $request->all();
        try {
            $dates = implode(range('2016', date('Y')));
            $yearTotal = Savings::where("created_at", "LIKE", "%{$dates}%")
                ->sum('monthly_contribution');
                $collection = collect();
            for ($i=1; $i <= 12; $i++) {
                if ($i<10) {
                    $yearMonth = $dates.'-0'.$i;
                    $monthTotal = Savings::where("created_at", "LIKE", $yearMonth . "%")
                    ->sum('monthly_contribution');
                    $savings = DB::table("savings")
                    ->where("savings.created_at", "LIKE", "{$yearMonth}%")
                    ->join("users", "savings.user_id", "=", "users.id")
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
                        "savings.loan_liability",
                        "savings.total_amount",
                        "savings.user_id",
                        "users.name",
                        )->orderBy("created_at", "desc")->get();
                    if (!$savings->isEmpty()) {
                        $collection->push((object)[
                            "month" => "0".$i,
                            "monthTotal"=>$monthTotal,
                            "savings" => $savings
                        ]);
                    }
                }else{
                    $yearMonth = $dates . '-' . $i;
                    $monthTotal = Savings::where("created_at", "LIKE", $yearMonth ."%")
                    ->sum('monthly_contribution');
                    $savingss = DB::table("savings")
                    ->where("savings.created_at", "LIKE", "{$yearMonth}%")
                    ->join("users", "savings.user_id", "=", "users.id")
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
                        "savings.loan_liability",
                        "savings.total_amount",
                        "savings.user_id",
                        "users.name",
                    )->orderBy("created_at", "desc")->get();
                    if(!$savings->isEmpty()){
                        $collection->push((object)[
                            "month"=>$i,
                            "monthTotal"=>$monthTotal,
                            "savings"=>$savings
                        ]);
                    }
                    
                }
            }
                $pdf = PDF::loadView(
                    "savings.savingsPdf",
                    [
                        "collection" => $collection,
                        "yearTotal" => $yearTotal,
                        "year" =>  $dates
                    ]
                );
            return $pdf->stream('fwpassociation-savings.pdf');
        } catch (QueryException $th) {
            throw $th;
        }
    }
}
