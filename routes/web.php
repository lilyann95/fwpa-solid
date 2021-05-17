<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkUserTre;
use App\Http\Middleware\checkUser;
use App\Http\Middleware\PreventBackHistory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("home");
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get("/check", "HomeController@check")->name("checking");
Route::middleware([PreventBackHistory::class])->group(function() {
    Auth::routes();

    Route::get("/home", "HomeController@index")->name("home");
    Route::post("/reset", "UserController@resetPassword")->name("reset");
    Route::get("/profile", "UserController@index")->name('profile');
    Route::post("/edit/profile", "UserController@edit")->name("editUser");
    Route::get("/members", "UserController@members")->name("members");
    Route::post("/status/actions", "UserController@status")->name("status");

    Route::get("/savings", "SavingsController@index")->name("savings");
    Route::post("/savings/create", "SavingsController@create")->name("createSavings")->middleware("treasurer");
    Route::post("/savings/fetch", "SavingsController@fetch")->name("fetchSavings");
    Route::post("/savings/fetchname", "SavingsController@fetchname")->name("fetchname");
    Route::post("/savings/fetchnamemodal", "SavingsController@fetchnamemodal");
    Route::post("/savings/fetchmembername", "SavingsController@fetchmembername");
    Route::post("/savings/fetch/year", "SavingsController@fetchByYear")->name("fetchByYear");
    // Route::post("/savings/edit/{id}", "SavingsController@edit")->name("editSavings")->middleware("treasurer");
    Route::get("/savings/view", "SavingsController@view")->name("view_savings");
    Route::post("/fetchareas", "SavingsController@fetchAreas");
    // Route::post("/fetch/autofill", "SavingsController@fill");

    Route::post("/savings/fetchnotarears", "SavingsController@fetchAreasnot");
    Route::post("/pdf/datasaving", "SavingsController@retrievePdf")->name("pdfsaving");


    Route::get("/loans", "LoansController@index")->name("loans");
    Route::post("/loans/fetchnameloanmodal", "SavingsController@fetchnameloanmodal");
    Route::post("/fetch/totalamountdue", "LoansController@fetchamount");
    Route::post("/fetch/fetchsubmem", "LoansController@fetchsubmem");
    Route::post("/loans/create", "LoansController@create");
    Route::get("/loans/pending", "LoansController@pending")->name("pendingloan")->middleware("treasurer");
    Route::post("/loans/fetch", "LoansController@fetch")->name("fetchpending");
    Route::post("/loans/edit/{id}", "LoansController@edit")->name("editLoans");
    Route::post("/loans/delete", "LoansController@destroy")->name("deleteLoan");
    Route::post("/loans/fetchactions", "LoansController@loanaction")->name("LoanAction");
    Route::post("/loans/fetch/pendingloan", "LoansController@fetchpending")->name("fetchpending");
    Route::get("/loans/recommend", "LoansController@recommend")->name("recommendedloan")->middleware("chairman");
    Route::post("/loans/admin/decline", "LoansController@admindecline")->name("admindecline")->middleware("chairman");
    Route::post("/loans/fetchRecoLoan", "LoansController@fetchRecoLoan")->name("fetchRecommendedLoan")->middleware("chairman");
    Route::get("/loans/allLoans", "LoansController@allLoans")->name("allLoans");
    Route::post("loans/fetch/loans", "LoansController@fetchAll")->name("fetchAll");
    Route::post("/loans/fetchguarantors", "LoansController@fetchguarantors");
    Route::post("/guarantor/decline", "LoansController@guarantordecline")->name("declineLoan");
    Route::post("/guarantor/approve", "LoansController@guarantorapprove")->name("guarantorapprove");
    Route::post("/loans/cleared", "LoansController@clearloan")->name("clearedloan");
    Route::get("/loans/cleared", "LoansController@cleared")->name("ClearedLoans");
    Route::post("loans/fetch/cleared", "LoansController@fetchCleared")->name("fetchCleared");

    Route::post("/pdf/loandata", "LoansController@print")->name("loanpdf");
    Route::post("/pdf/approveddata", "LoansController@printApproved")->name("Approvedloanpdf");


    Route::get("/allExpenses", "ExpensesController@allExpenses")->name("allExpenses");
    Route::post("/fetch/expenses", "ExpensesController@fetchAll")->name("fetchAll");
    Route::get("/dashboardExpense", "ExpensesController@index")->name("welcome");
    Route::post("/expense", "ExpensesController@create")->name("createExpense");
    Route::post("/expenses/fetch", "ExpensesController@fetch")->name("fetchExpenses");
    Route::post("/expenses/edit/{id}", "ExpensesController@edit")->name("editExpenses");
    Route::post("/expenses/delete", "ExpensesController@destroy")->name("deleteExpense");
    Route::post("/expenses/actions", "ExpensesController@action")->name("expenseAction");
    Route::get("/expenses/pending", "ExpensesController@pending")->name("pending")->middleware("treasurer");
    Route::post("/expenses/fetch/pending", "ExpensesController@fetchPending")->name("fetchPending")->middleware("treasurer");
    Route::get("/expenses/recommended", "ExpensesController@recommended")->name("recommended")->middleware("chairman");
    Route::post("/expenses/fetchReco", "ExpensesController@fertchReco")->name("fetchRecommended")->middleware("chairman");

    Route::post("/dashboardvalues", "ExpensesController@values")->name("values");

    
    Route::post("/pdf/data", "ExpensesController@retrievePdf")->name("pdf");
});