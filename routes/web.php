<?php

use Illuminate\Support\Facades\Route;

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

// Route::get("/bryan", "UserController@passwords")->name("bryan");

Route::get('/dashboard', function () {
    return view('welcome');
})->name('welcome');

Route::get("/check", "HomeController@check")->name("checking");

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
Route::post("/savings/edit/{id}", "SavingsController@edit")->name("editSavings")->middleware("treasurer");
Route::get("/savings/view", "SavingsController@view")->name("view_savings");
Route::post("/savings/fetchsum", "SavingsController@fetchsum");
Route::get("/expected_deposits", "SavingsController@expected_deposits")->name("expected_deposits");
Route::post("/expected_deposits/create", "SavingsController@createdeposits")->name("createdeposits");
Route::post("/expected_deposits/fetch", "SavingsController@fetchdeposits")->name("fetchdeposits");
Route::get("/payout", "SavingsController@payout")->name("payout");
Route::post("/payout/fetch", "SavingsController@fetchpayout")->name("fetchpayout");

Route::post("/pdf/datasaving", "SavingsController@retrievePdf")->name("pdfsaving");

Route::get("/allExpenses", "ExpensesController@allExpenses")->name("allExpenses");
Route::post("/fetch/expenses", "ExpensesController@fetchAll")->name("fetchAll");
Route::get("/dashboard", "ExpensesController@index")->name("welcome");
Route::post("/expense", "ExpensesController@create")->name("createExpense");
Route::post("/expenses/fetch", "ExpensesController@fetch")->name("fetchExpenses");
Route::post("/expenses/edit/{id}", "ExpensesController@edit")->name("editExpenses");
Route::post("/expenses/delete", "ExpensesController@destroy")->name("deleteExpense");
Route::post("/expenses/actions", "ExpensesController@action")->name("expenseAction");
Route::get("/expenses/pending", "ExpensesController@pending")->name("pending")->middleware("treasurer");
Route::post("/expenses/fetch/pending", "ExpensesController@fetchPending")->name("fetchPending")->middleware("treasurer");
Route::get("/expenses/recommended", "ExpensesController@recommended")->name("recommended")->middleware("chairman");
Route::post("/expenses/fetchReco", "ExpensesController@fertchReco")->name("fetchRecommended")->middleware("chairman");

Route::post("/pdf/data", "ExpensesController@retrievePdf")->name("pdf");
