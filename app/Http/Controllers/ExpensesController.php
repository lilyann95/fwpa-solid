<?php

namespace App\Http\Controllers;

use App\Expenses;
use App\User;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ExpensesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('welcome');
    }
    public function allExpenses()
    {
        return view("expenses.index");
    }

    public function fetchAll(Request $request){
        $inputs = $request->all();
        try {
            $monthTotal = Expenses::where("created_at", "LIKE", $inputs['date']."-%")
                    ->where("status", "=", "approved")->sum('budget');
            $yearTotal = Expenses::where("created_at", "LIKE", explode("-", $inputs['date'])[0] . "-%")
                ->where("status", "=", "approved")->sum('budget');
            $expenses = DB::table("expenses")
            ->where("expenses.created_at", "LIKE", "{$inputs['date']}%")
            ->join("users", "expenses.user_id", "=", "users.id")
            ->where("expenses.status", "=", "approved")
            ->select(
                "expenses.id",
                "expenses.desc",
                "expenses.created_at",
                "expenses.budget",
                "expenses.status",
                "expenses.user_id",
                "users.name",
                "users.userType"
            )
                ->orderBy("created_at", "desc")->get();
            return response()->json([
                "expenses" => $expenses,
                "totalYear" => $yearTotal,
                "totalMonth" => $monthTotal
                ]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function pending()
    {
        return view("expenses.pending");
    }

    public function fetchPending(Request $request)
    {
        $inputs = $request->all();
        try {
            $expenses = DB::table("expenses")
            ->where("expenses.created_at", "LIKE", "{$inputs['date']}-%")
            ->where("expenses.status", "=", "pending")
                ->join("users", "expenses.user_id", "=", "users.id")
                ->select(
                    "expenses.id",
                    "expenses.desc",
                    "expenses.created_at",
                    "expenses.budget",
                    "expenses.status",
                    "expenses.user_id",
                    "expenses.reason",
                    "users.name",
                    "users.userType"
                )
                ->orderBy("created_at", "desc")->get();
            return response()->json($expenses);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function recommended()
    {
        return view("expenses.recommend");
    }

    public function fertchReco(Request $request)
    {
        $inputs = $request->all();
        try {
            $expenses = DB::table("expenses")
            ->where("expenses.created_at", "LIKE", "{$inputs['date']}-%")
            ->where("expenses.status", "=", "recommend")
            ->join("users", "expenses.user_id", "=", "users.id")
            ->select(
                "expenses.id",
                "expenses.desc",
                "expenses.created_at",
                "expenses.budget",
                "expenses.status",
                "expenses.user_id",
                "expenses.reason",
                "users.name",
                "users.userType"
            )
                ->orderBy("created_at", "desc")->get();
            return response()->json($expenses);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function fetch(Request $request)
    {
        $inputs = $request->all();
        try {
            $expenses = DB::table("expenses")
                ->where("expenses.created_at", "LIKE", "{$inputs['date']}-%")
                ->where("user_id", "=", Auth::user()->id)
                ->join("users", "expenses.user_id", "=", "users.id")
                ->select(
                    "expenses.id",
                    "expenses.desc",
                    "expenses.created_at",
                    "expenses.budget",
                    "expenses.status",
                    "expenses.reason",
                    "expenses.user_id",
                    "users.name",
                    "users.userType"
                )
                ->orderBy("created_at", "desc")->get();
            return response()->json($expenses);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "desc" => "required",
            "budget" => "required|numeric",
            "months_taken" => "required|numeric"
        ]);
        $user = User::findOrFail(Auth::user()->id);
        $inputs = $request->all();
        try {
            $user->expense()->save(
                new Expenses([
                    "desc" => $inputs["desc"],
                    "budget" => $inputs["budget"],
                    "status" => "pending",
                    "months_taken" => $inputs["months_taken"],
                    "reason" => "not cancelled"
                ])
            );
            return response()->json([
                "msg" => "Expense Saved Successfully"
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
                "budget" => $inputs['budget']
            ]);
            return response()->json(["msg" => "Operation successfully"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function destroy(Request $request)
    {
        $inputs = $request->all();
        $user = User::findOrFail(Auth::user()->id);
        try {
            $user->expense()->where("id", "=", $inputs['id'])->delete();
            return response()->json(["msg"=> "Deleted Successfully"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function action(Request $request)
    {
        $inputs = $request->all();
        try {
            Expenses::where("id", "=", $inputs['id'])->update([
                "status" => $inputs['action'],
                "reason" => $inputs['reason']
            ]);
            return response()->json(["msg" => "Operation Successfull"]);
        } catch (QueryException $th) {
            throw $th;
        }
    }

    public function retrievePdf(Request $request){
        $inputs = $request->all();
        try {
            $yearTotal = Expenses::where("created_at", "LIKE", $inputs['year'] . "-%")
                ->where("status", "=", "approved")->sum('budget');
                $collection = collect();
            for ($i=1; $i <= 12; $i++) {
                if ($i<10) {
                    $yearMonth = $inputs['year'].'-0'.$i;
                    $monthTotal = Expenses::where("created_at", "LIKE", $yearMonth . "%")
                    ->where("status", "=", "approved")->sum('budget');
                    $expenses = DB::table("expenses")
                    ->where("expenses.created_at", "LIKE", "{$yearMonth}%")
                    ->where("expenses.status", "=", "approved")
                    ->join("users", "expenses.user_id", "=", "users.id")
                    ->select(
                        "expenses.id",
                        "expenses.desc",
                        "expenses.created_at",
                        "expenses.budget",
                        "expenses.status",
                        "expenses.user_id",
                        "users.name",
                        "users.userType"
                    )->orderBy("created_at", "desc")->get();
                    if (!$expenses->isEmpty()) {
                        $collection->push((object)[
                            "month" => "0".$i,
                            "monthTotal"=>$monthTotal,
                            "expenses" => $expenses
                        ]);
                    }
                }
                else{
                    $yearMonth = $inputs['year'] . '-' . $i;
                    $monthTotal = Expenses::where("created_at", "LIKE", $yearMonth ."%")
                    ->where("status", "=", "approved")->sum('budget');
                    $expenses = DB::table("expenses")
                    ->where("expenses.created_at", "LIKE", "{$yearMonth}%")
                    ->where("expenses.status", "=", "approved")
                    ->join("users", "expenses.user_id", "=", "users.id")
                    ->select(
                        "expenses.id",
                        "expenses.desc",
                        "expenses.created_at",
                        "expenses.budget",
                        "expenses.status",
                        "expenses.user_id",
                        "users.name",
                        "users.userType"
                    )->orderBy("created_at", "desc")->get();
                    if(!$expenses->isEmpty()){
                        $collection->push((object)[
                            "month"=>$i,
                            "monthTotal"=>$monthTotal,
                            "expenses"=>$expenses
                        ]);
                    }
                    
                }
            }
                $pdf = PDF::loadView(
                    "expenses.expensesPdf",
                    [
                        "collection" => $collection,
                        "yearTotal" => $yearTotal,
                        "year" => $inputs['year']
                    ]
                );
            // return view(
            //     "expenses.expensesPdf",
            //     [
            //         "collection" => $collection, 
            //         "yearTotal" => $yearTotal, 
            //         "year" => $inputs['year']
            //     ]
            // );
            // return $pdf->download("fwpassociation-expenses.pdf");
            return $pdf->stream('fwpassociation-expenses.pdf');
        } catch (QueryException $th) {
            throw $th;
        }
    }
}
