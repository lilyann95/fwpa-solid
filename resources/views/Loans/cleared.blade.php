@section('dynamic-js')
    <script src="{{ asset('/dist/js/loans.js?v=134345')}}"></script>
@stop
@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-5">
                    <h4 class="page-title">All Cleared Loans</h4>
                </div>
                <div class="col-7">
                    <div class="text-right upgrade-btn">
                        <a href="#" data-toggle="modal" data-target="#loanpdf"><i class="fas fa-eye fa-3x" title="VIEW LOANS REPORT" ></i></a>
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
                                    <h6 class="card-subtitle">Cleared Loans</h6>
                                    <h6>Total Year: <strong class="year_total">__ UGX</strong>, Month : <strong class="month_total">__ UGX</strong></h6>
                                </div>
                                <div class="ml-auto">
                                    <div class="dl">
                                        <input type="month" name="month" class="ClearedLoan" id="monthloan" />
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
                                        <th class="border-top-0">Guarantor Amount</th>
                                        <th class="border-top-0">User Name</th>
                                        <th class="border-top-0">User Number</th>
                                        <th class="border-top-0">Date</th>
                                        <th class="border-top-0">Status</th>
                                    </tr>
                                </thead>
                                {{-- get all form jQuery --}}
                                <tbody class="ClearedLoans-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection