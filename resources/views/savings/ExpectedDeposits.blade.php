@section('dynamic-js')
    <script src="{{ asset('/assets/js/expenses.js?v=134345')}}"></script>
@stop
@extends('layouts.app', ['noSideBar' => true])
@section('content')
    <div class="page-wrapper page">
        <div class="page-breadcrumb">
            <a href="{{ route('savings') }}" class="btn btn-outline-secondary btn-sm float-left mb-2" >
                <i class="mdi mdi-arrow-left-bold"></i>
                    Return
            </a>
        </div>
        <br>
        <div class="container-fluid">
            <div class="stat">
                <h1>FWP FINANCIAL REPORT</h1>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <col>
                        <col style="background-color: white;">
                        <colgroup span="1" style="background-color: #B6B6B4"></colgroup>
                        <colgroup span="1" style="background-color: #8BB381;"></colgroup>
                        <colgroup span="1" style="background-color: #FF8040;"></colgroup>
                        <colgroup span="3" style="background-color: yellow;"></colgroup>
                        <colgroup span="3" style="background-color: #EBF4FA;"></colgroup>
                        <tr class="bg-light" >
                            <th class="border-top-0" colspan="5"  id="loan" scope="colgroup">FWP MEMBER SAVINGS STATUS</th>
                            <th class="border-top-0" colspan="4"  id="loan" style="background-color: white" scope="colgroup">LOAN</th>
                        </tr>
                        <tr>
                            <th class="border-top-0" scope="col">S/N</th>
                            <th class="border-top-0" scope="col">MEMBER</th>
                            <th class="border-top-0" scope="col">AMOUNT DUE TO MEMBERS</th>
                            <th class="border-top-0" scope="col">EXPECTED SAVINGS</th>
                            <th class="border-top-0" scope="col">ARREARS</th>
                            <th class="border-top-0" scope="col">AMOUNT OFFERED</th>
                            <th class="border-top-0" scope="col">MONTHS TAKEN</th>
                            <th class="border-top-0" scope="col">AMOUNT DUE</th>
                            <th class="border-top-0" scope="col">LAST REPAYMENT DATE</th>
                        </tr>
                    </thead>
                    <tbody class="expected-tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection