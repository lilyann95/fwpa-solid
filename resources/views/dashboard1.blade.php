@extends("layouts.app")
@section("content")
<div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="page-title font-20" style="text-align: center; font-size: 40px; color: #FF6700;"><strong>THE DASHBOARD</strong> </h4>
                </div>
            </div>
        </div>
        <div class="container-fluid ">
            <div class="row ">
                
                <div class="col-sm-11 col-md-6 col-lg-10 col-xl-11  mx-auto" style="background-color: #696969;">
                    <div class="card card-stats ">
                        <!-- Card body -->
                        @if((Auth()->user()->userType==="chairman")||(Auth()->user()->userType==="treasurer"))
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="container p-5">
                                            <h3><strong> PIE CHART</strong></h3>
                                            <div id="piechart" style="width: 600px; height: 350px;"></div>
                                        </div>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                                var loanall = parseFloat(
                                                    @php
                                                        $runningloanall = DB::table("loans")->where("loans.status", "=", "approved")->sum("loanamount");
                                                        echo floatval($runningloanall);
                                                    @endphp
                                                   
                                                );

                                                var expense = parseFloat(
                                                    @php
                                                        $Allexpenses = DB::table("expenses")->where("expenses.status", "=", "approved")->sum("budget");
                                                        echo floatval($Allexpenses);
                                                    @endphp
                                                   
                                                );
                                                var expenditure = parseFloat(
                                                    @php
                                                    $sumlatepayment = DB::table("savings")->sum("late_payment");
                                                        $sumlatemeeting = DB::table("savings")->sum("late_meeting");
                                                        $sumabsenteeism = DB::table("savings")->sum("absenteeism");
                                                        $summarriage = DB::table("savings")->sum("marriage");
                                                        $sumbirth = DB::table("savings")->sum("birth");
                                                        $sumgraduation = DB::table("savings")->sum("graduation");
                                                        $sumconsecration = DB::table("savings")->sum("consecration");
                                                        $sumsickness = DB::table("savings")->sum("sickness");
                                                        $sumdeath = DB::table("savings")->sum("death");
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
                                                        echo floatval($total_expenditure);                         
                                                    @endphp
                                                );
                                                var totalAll = parseFloat(
                                                    @php
                                                        $loancleared = DB::table("loans")->where("loans.status", "=", "cleared")->sum("loanamount");
                                                        $total_amountall = DB::table("savings")->sum("monthly_contribution");
                                                        $sumlatepayment = DB::table("savings")->sum("late_payment");
                                                        $sumlatemeeting = DB::table("savings")->sum("late_meeting");
                                                        $sumabsenteeism = DB::table("savings")->sum("absenteeism");
                                                        $summarriage = DB::table("savings")->sum("marriage");
                                                        $sumbirth = DB::table("savings")->sum("birth");
                                                        $sumgraduation = DB::table("savings")->sum("graduation");
                                                        $sumconsecration = DB::table("savings")->sum("consecration");
                                                        $sumsickness = DB::table("savings")->sum("sickness");
                                                        $sumdeath = DB::table("savings")->sum("death");
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
                                                        $runningloanall = DB::table("loans")->where("loans.status", "=", "approved")->sum("loanamount");
                                                        $Allexpenses = DB::table("expenses")->where("expenses.status", "=", "approved")->sum("budget");
                                                        $finalall = $total_amountall - ($runningloanall +  $Allexpenses + $total_expenditure);
                                                        echo floatval($finalall);
                                                    @endphp
                                                );

                                            var data = google.visualization.arrayToDataTable([
                                                ["EXISTING MONEY", "PERCENTAGE OF MONEY"],
                                                ["LOANS", loanall],
                                                ["TOTAL AMOUNT DUE TO ALL", totalAll],
                                                ["EXPENSES", expense],
                                                ["EXPENDITURES", expenditure]

                                            ]);

                                            var options = {
                                                // title: 'Product Details',
                                                colors: ['#696969', '#FF6700', '#DA70D6',"#FFFF00"],
                                                is3D: true,
                                            };
                                                console.log(true)
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                                            chart.draw(data, options);
                                            }
                                        </script>
                                    </div>
                                    <div class="col-md-6">
                                        @php
                                            $Allexpenses = DB::table("expenses")->where("expenses.status", "=", "approved")->sum("budget");
                                            $runningloanall = DB::table("loans")->where("loans.status", "=", "approved")->sum("loanamount");
                                            $expectedreturnall = DB::table("loans")->where("loans.status", "=", "approved")->sum("return");
                                            $total_amountall = DB::table("savings")->sum("monthly_contribution");

                                            $sumlatepayment = DB::table("savings")->sum("late_payment");
                                            $sumlatemeeting = DB::table("savings")->sum("late_meeting");
                                            $sumabsenteeism = DB::table("savings")->sum("absenteeism");
                                            $summarriage = DB::table("savings")->sum("marriage");
                                            $sumbirth = DB::table("savings")->sum("birth");
                                            $sumgraduation = DB::table("savings")->sum("graduation");
                                            $sumconsecration = DB::table("savings")->sum("consecration");
                                            $sumsickness = DB::table("savings")->sum("sickness");
                                            $sumdeath = DB::table("savings")->sum("death");
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

                                        @endphp
                                        <br>
                                        <br>
                                        <br>
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-align:center" style="font-size: 30px; "><strong>ASSOCIATION EXPENSE</strong></h5>
                                            <span class="h2 font-weight-bold mb-0"></span>
                                            <h6 style="font-size: 20px;"> TOTAL EXPENSES:<strong>{{number_format($Allexpenses)}} UGX </strong></h6>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0" style="font-size: 30px; "><strong> LOANS</strong></h5>
                                            <span class="h2 font-weight-bold mb-0"></span>
                                            <h6 style="font-size: 20px;">AMOUNT IN LOANS:<strong>{{number_format($runningloanall)}} UGX </strong></h6>
                                            <h6 style="font-size: 20px;">EXPECTED RETURNS:<strong>{{number_format($expectedreturnall)}} UGX </strong></h6>
                                        </div>
                                        
                                        <br>
                                        <br>
                                        <br>
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0" style="font-size: 30px; "><strong> SAVINGS</strong></h5>
                                            <span class="h2 font-weight-bold mb-0"></span>
                                            <h6 style="font-size: 20px;">TOTAL AMOUNT SAVED:<strong>{{number_format($total_amountall)}} UGX </strong></h6>
                                            
                                        </div>
                                        <!-- <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded shadow">
                                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="container p-5">
                                            <h3><strong> PIE CHART</strong></h3>
                                            <div id="piechart" style="width: 600px; height: 350px;"></div>
                                        </div>
                                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                        <script type="text/javascript">
                                            google.charts.load('current', {'packages':['corechart']});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                               
                                                // $total_amount = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("total_amount");
                                                var loan = parseFloat(
                                                    @php
                                                         $runningloan =DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "approved")->value("loanamount");
                                                        echo floatval($runningloan);
                                                    @endphp
                                                   
                                                );
                                                var expenditures = parseFloat(
                                                    @php
                                                    $sumlatepayment = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("late_payment");
                                                    $sumlatemeeting = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("late_meeting");
                                                    $sumabsenteeism = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("absenteeism");
                                                    $summarriage = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("marriage");
                                                    $sumbirth = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("birth");
                                                    $sumgraduation = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("graduation");
                                                    $sumconsecration = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("consecration");
                                                    $sumsickness = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("sickness");
                                                    $sumdeath = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("death");
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
                                                    echo floatval($total_expenditure);                       
                                                    @endphp
                                                );
                                                
                                                var clearedloans = parseFloat(
                                                    @php
                                                        $loancleared = DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "cleared")->sum("return");
                                                        echo floatval($loancleared);
                                                    @endphp
                                                );
                                                var total = parseFloat(
                                                    @php
                                                        $total_amount = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("monthly_contribution");
                                                        $loancleared = DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "cleared")->sum("return");
                                                       
                                                        $sumlatepayment = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("late_payment");
                                                        $sumlatemeeting = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("late_meeting");
                                                        $sumabsenteeism = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("absenteeism");
                                                        $summarriage = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("marriage");
                                                        $sumbirth = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("birth");
                                                        $sumgraduation = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("graduation");
                                                        $sumconsecration = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("consecration");
                                                        $sumsickness = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("sickness");
                                                        $sumdeath = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("death");
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

                                                        $runningloan =DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "approved")->value("loanamount");
                                                        $final = $total_amount - ($runningloan + $total_expenditure + $loancleared );
                                                        echo floatval($final);
                                                    @endphp
                                                );
                                            var data = google.visualization.arrayToDataTable([
                                                ["EXISTING LOAN", "PERCENTAGE OF LOAN"],
                                                ["LOANS", loan],
                                                ["SAVINGS EXPENDITURES", expenditures],
                                                ["SAVINGS", total],
                                                ["CLEARED LOANS", clearedloans]
                                                   
                                            ]);

                                            var options = {
                                                // title: 'Product Details',
                                                colors: ['#696969', "#946000" , '#FF6700', "#DA70D6"],
                                                is3D: true,
                                            };
                                                console.log(true)
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                                            chart.draw(data, options);
                                            }
                                        </script>
                                    </div>
                                    <div class="col-md-6">
                                    
                                    <br>
                                    <br>
                                    <br>
                                        @php

                                            $loancleared = DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "cleared")->sum("return");

                                            $runningloan = DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "approved")->value("loanamount");
                                            $expectedreturn = DB::table("loans")->where("user_id", "=", Auth::user()->id)->where("loans.status", "=", "approved")->value("return");
                                            $total_amount = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("monthly_contribution");

                                            $sumlatepayment = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("late_payment");
                                            $sumlatemeeting = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("late_meeting");
                                            $sumabsenteeism = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("absenteeism");
                                            $summarriage = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("marriage");
                                            $sumbirth = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("birth");
                                            $sumgraduation = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("graduation");
                                            $sumconsecration = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("consecration");
                                            $sumsickness = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("sickness");
                                            $sumdeath = DB::table("savings")->where("name_id", "=", Auth::user()->id)->sum("death");
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
                                            $final_totalamount = $total_amount - ($total_expenditure + $loancleared);                        
                                        @endphp
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0" style="font-size: 30px;"><strong> LOANS</strong></h5>
                                            <span class="h2 font-weight-bold mb-0"></span>
                                            <h6 style="font-size: 20px;">RUNNING LOANS : <strong>{{number_format($runningloan)}} UGX </strong></h6>
                                            <h6 style="font-size: 20px;">EXPECTED RETURNS : <strong>{{number_format($expectedreturn)}} UGX </strong></h6>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0" style="font-size: 30px;"><strong> SAVINGS</strong></h5>
                                            <span class="h2 font-weight-bold mb-0"></span>
                                            <h6 style="font-size: 20px;">AMOUNT SAVED: <strong>{{number_format($total_amount)}} UGX </strong></h6>
                                            <h6 style="font-size: 20px;">AMOUNT IN CLEARED LOANS: <strong>{{number_format($loancleared)}} UGX </strong></h6>
                                            <h6 style="font-size: 20px;">AMOUNT IN EXPENDITURES: <strong>{{number_format($total_expenditure)}} UGX </strong></h6>
                                            <h6 style="font-size: 20px;">TOTAL AMOUNT DUE: <strong>{{number_format($final_totalamount)}} UGX </strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
    </div>
@endsection