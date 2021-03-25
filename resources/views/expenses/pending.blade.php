@section('dynamic-js')
    <script src="{{ asset('/dist/js/expences.js?v=134345')}}"></script>
@stop
@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-5">
                        <h4 class="page-title">Pending Expenses</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('welcome')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Pending Expenses</li>
                                </ol>
                            </nav>
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
                                    <h6 class="card-subtitle">Pending Expenses</h6>
                                </div>
                                <div class="ml-auto">
                                    <div class="dl">
                                        <input type="month" class="pendingExp"name="month" id="month" />
                                    </div>
                                </div>
                            </div>
                            <!-- title -->
                        </div>
                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="border-top-0" style="width: 55%;">Description</th>
                                        <th class="border-top-0">Amount</th>
                                        <th class="border-top-0">Payee</th>
                                        <th class="border-top-0">Date</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Actions</th>
                                    </tr>
                                </thead>
                                {{-- data from jQuery --}}
                                <tbody class="pending-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection