@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-5">
                    <h4 class="page-title">Dashboard</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-7">
                    <div class="text-right upgrade-btn">
                        <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#expenses">New Expense</a>
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
                                    <h6 class="card-subtitle">Expenses</h6>
                                </div>
                                <div class="ml-auto">
                                    <div class="dl">
                                        <input type="month" class="fetchExp" name="month" id="month" />
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
                                        <th class="border-top-0">Budget</th>
                                        <th class="border-top-0">User</th>
                                        <th class="border-top-0">Date</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Actions</th>
                                    </tr>
                                </thead>
                                {{-- data from jQuery --}}
                                <tbody class="expenses-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection