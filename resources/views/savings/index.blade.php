@section('dynamic-js')
    <script src="{{ asset('/dist/js/savings.js?v=134345')}}"></script>
@stop
@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center"  >
                <div class="d-md-flex align-items-center">
                    <h2 class="page-title">Members Savings</h2>
                </div>

                    <!-- <div class="col-7">
                        <div class="text-right upgrade-btn">
                            <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#pdf">
                            <i class="far fa-scanner" size="2x" aria-hidden="true"></i> Scan Receipt</a>
                        </div>
                    </div> -->
            </div>
        </div>
            <!-- END FOR TODAY -->
        
        <div class="col-9">
            <div class="row align-items-center d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-6 ">
                            <div class="card-profile-image">
                                <a href="#" data-toggle="modal" data-target="#profileImage">
                                    <img src={{ asset("profiles/savings.jpg") }} width="600" height="300"  > 
                                </a>
                            </div>
                        </div>
                        <hr class="my-3">
                        <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Action to user</span>
                        </h6>
                        <div class="row justify-content-center">
                            <div class="container">
                                @if ((Auth()->user()->userType==="treasurer"))
                                    <!-- <button class="btn btn-primary custom-btn btn-sm float-right mb-2 add-saving" data-toggle="modal" data-target="#savings">
                                        <span class="togglsave">Add Savings</span> 
                                    </button> -->
                                    <a  class="btn btn-primary custom-btn btn-sm float-right mb-2 add-saving" data-toggle="modal" data-target="#savings">
                                        <span class="togglsave">Add Savings</span>
                                    </a>
                                @endif
                                <a href="{{route('view_savings')}}" class="btn btn-info custom-btn btn-sm float-left mb-2 view-savings">View Savings</a>
                                
                                <div class="align-items-center d-flex justify-content-center">
                                    <!-- <a href="" class="btn btn-secondary custom-btn btn-sm text-center mb-2 view-all-savings">View All Savings</a> -->
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div> 
    </div>
@endsection