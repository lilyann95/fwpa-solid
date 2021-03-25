@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row ml-1">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30"> 
                        <img src={{ asset("profiles/".Auth()->user()->image) }} class="rounded-circle" width="150" />
                        <h4 class="card-title m-t-10">{{Auth()->user()->name}}</h4>
                        <h6 class="card-subtitle">
                            @if(Auth()->user()->userType=="chairman") 
                                {{'The Chairperson'}}
                            @elseif (Auth()->user()->userType=="treasurer") 
                                {{'Secretary for Finance and Projects'}}
                            @else
                                {{Auth()->user()->userType}}
                            @endif
                        </h6>
                    </center>
                </div>
                <div>
                    <hr> </div>
                <div class="card-body"> 
                    <small class="text-muted">Email address </small>
                    <h6>{{Auth()->user()->email}}</h6> 
                    <small class="text-muted p-t-30 db">Name</small>
                    <h6>{{Auth()->user()->name}}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xlg-8 col-md-6 mr-auto ml-auto">
            <div class="card">
                <div class="card-body">
                    <form id="profile-form" class="form-horizontal form-material" enctype="multipart/form-data" style="margin: 2px 4rem 2px 4rem;">
                        @csrf
                        <div class="form-group">
                            <label class="col-md-12">Full Name</label>
                            <div class="col-md-12">
                                <input id="name" type="text" placeholder="username" value="{{Auth()->user()->name}}" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-email" class="col-md-12">Email</label>
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="example@admin.com" value={{Auth()->user()->email}} class="form-control form-control-sm @error('email') is-invalid @enderror" name="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Password</label>
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Confirm Password</label>
                            <div class="col-md-12">
                                <input id="password-confirm" name="password_confirmation" type="password" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Profile Image</label>
                            <div class="col-md-12">
                                <input id="image" name="image" type="file" class="form-control form-control-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" id="profile-btn" class="btn btn-success">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection