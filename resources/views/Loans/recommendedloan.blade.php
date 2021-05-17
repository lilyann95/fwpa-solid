@section('dynamic-js')
    <script src="{{ asset('/dist/js/loans.js?v=134345')}}"></script>
@stop
@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-5">
                        <h4 class="page-title">Recommended Loans</h4>
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
                                    <h6 class="card-subtitle">Recommended Loans</h6>
                                </div>
                                <div class="ml-auto">
                                    <div class="dl">
                                        <input type="month" class="recoLoan" name="month" id="monthloan" />
                                    </div>
                                </div>
                            </div>
                            <!-- title -->
                        </div>
                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                    <th class="border-top-0" style="width: 25%;">Description</th>
                                    <th class="border-top-0">Loan Amount</th>
                                    <th class="border-top-0">Months Taken</th>
                                    <th class="border-top-0">Processing Fee</th>
                                    <th class="border-top-0">Expected Loan Return</th>
                                    <th class="border-top-0">Guarantor</th>
                                    <th class="border-top-0">Guarantor Amount</th>
                                    <th class="border-top-0">User Name</th>
                                    <th class="border-top-0">User Number</th>
                                    <th class="border-top-0">Last Payment Date</th>
                                    <th class="border-top-0">Date</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0">Actions</th>
                                </thead>
                                {{-- data from jQuery --}}
                                <tbody class="recommendedloan-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection