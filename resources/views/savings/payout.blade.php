@section('dynamic-js')
    <script src="{{ asset('/dist/js/savings.js?v=134345')}}"></script>
@stop
@extends('layouts.app', ['noSideBar' => true])
@section('content')
<div class="page-wrapper page">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-5">
                    <a href="{{ route('savings') }}" class="btn btn-outline-secondary btn-sm float-left mb-2" >
                        <i class="mdi mdi-arrow-left-bold"></i>
                            Return
                    </a>
                </div>
                  
            </div>
        </div>
        <br>
        <div class="container">
            <div class="align-items-center d-flex justify-content-center">
                <h4 class="page-title" style="font-size: 40px;">PAY OUT</h4>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <span class="connection-check text-danger ml-4" style="font-size: 12px;"></span>
                <!-- column -->
                    <div class=" table-responsive">
                        <table class="">
                            <thead>
                                <tr>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">S/N</th>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">MEMBER</th>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">AMOUNT DUE TO MEMBER</th>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">90% OF AMOUNT DUE</th>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">ARREARS</th>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">LOAN LIABILITY</th>
                                    <th class="border-top-0" style="background-color: #b6fcd5" scope="col">PAY OUT AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody class="payout-tbody">
                                
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@endsection