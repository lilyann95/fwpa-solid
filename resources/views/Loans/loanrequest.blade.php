@section('dynamic-js')
    <script src="{{ asset('/dist/js/loans.js?v=134345')}}"></script>
@stop
@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-5">
                    <h4 class="page-title">Loan Requests</h4>
                </div>
                <div class="col-5">
                
                    <?php
                    $defaulters = DB::table("loans")->where("loans.status", "=", "approved")->pluck('loans.user_id')->toArray();
                    $id = Auth::id();
                        if(in_array($id,  $defaulters)) {
                            ?>
                            <div class="text-right upgrade-btn">
                                
                            </div> 
                        <?php }else {
                            ?>
                            <div class="text-right upgrade-btn">
                                <a href="#" class="btn btn-sm btn-outline-primary loanmember" data-toggle="modal" data-target="#loans">New Loan</a>
                            </div>    
                        <?php  
                        }
                        ?>  
                </div>
                
                <div class="col-2">
                    <div class="text-right upgrade-btn">
                        
                        <a href="#" data-toggle="modal" data-target="#guarantor" class="notification">
                            <span><i class="fa fa-bell fa-3x"></i></span>
                            <span class="badge2 badge3 badge-quarantor custom-badge badge-default"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <span class="connection-check text-danger ml-4" style="font-size: 12px;"></span>
                <!-- column -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- title -->
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h6 class="card-subtitle">Loans</h6>
                                </div>
                                <div class="ml-auto">
                                    <div class="dl">
                                        <input type="month" class="fetchLoan" name="month" id="monthloan" />
                                    </div>
                                </div>
                            </div>
                            <!-- title -->
                        </div>
                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="border-top-0" style="width: 25%;">Description</th>
                                        <th class="border-top-0">Loan Amount</th>
                                        <th class="border-top-0">Months Taken</th>
                                        <th class="border-top-0">Processing Fee</th>
                                        <th class="border-top-0">Expected Loan Return</th>
                                        <th class="border-top-0">Guarantor</th>
                                        <th class="border-top-0">Guarantor status</th>
                                        <th class="border-top-0">Guarantor Amount</th>
                                        <th class="border-top-0">User Name</th>
                                        <th class="border-top-0">User Number</th>
                                        <th class="border-top-0">Last Payment Date</th>
                                        <th class="border-top-0">Date</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Actions</th>
                                    </tr>
                                </thead>
                                {{-- data from jQuery --}}
                                <tbody class="loans-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
