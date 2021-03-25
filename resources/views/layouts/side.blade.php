<aside class="left-sidebar" style="position: fixed; overflow-y: auto;" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <div class="user-profile d-flex no-block dropdown m-t-20">
                        <div class="user-pic"><img src={{ asset('profiles/'.Auth()->user()->image)}} alt="users" class="rounded-circle" width="40" /></div>
                        <div class="user-content hide-menu m-l-10 ml-2">
                            <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="m-b-0 user-name font-medium">{{Auth()->user()->name}} <i class="fa fa-angle-down"></i></h5>
                                <span class="op-5 user-email">{{Auth()->user()->email}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                                <a class="dropdown-item" href="{{route('profile')}}"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{route('logout')}}" 
                                    onclick="event.preventDefault(); 
                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- side bar items -->
                    <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('welcome')}}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                    </li>
                <!-- Navigation -->
                @if ((Auth()->user()->userType==="chairman")||(Auth()->user()->userType==="treasurer"))
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">
                   <span class="docs-normal">Expenses</span>
                </h6>
                    <li class="sidebar-item"> 
                      <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('allExpenses')}}" aria-expanded="false">
                        <i class="mdi mdi-file"></i>
                        <span class="hide-menu">All Expenses</span>
                      </a>
                    </li>
                @endif
                @if (Auth()->user()->userType==="treasurer")
                    <li class="sidebar-item"> 
                     <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('pending')}}" aria-expanded="false">
                        <i class="mdi mdi-file"></i>
                        <span class="hide-menu">Pending</span>
                     </a>
                    </li>
                @endif
                @if (Auth()->user()->userType==="chairman")
                    <li class="sidebar-item"> 
                      <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('recommended')}}" aria-expanded="false">
                        <i class="mdi mdi-file"></i>
                        <span class="hide-menu">Recommended</span>
                      </a>
                    </li>
                @endif
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading text-muted">
                   <span class="docs-normal">Savings</span>
                </h6>
                <!-- Navigation -->
                <li class="sidebar-item"> 
                   <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('savings')}}" aria-expanded="false">
                    <i class="mdi mdi-bank"></i>
                    <span class="hide-menu">Members savings</span>
                   </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('expected_deposits')}}" aria-expanded="false">
                        <i class="mdi mdi-wallet-giftcard"></i>
                        <span class="hide-menu">Expected Deposits</span>
                    </a>
                </li>
                <li class="sidebar-item"> 
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('payout')}}" aria-expanded="false">
                    <i class="mdi mdi-wallet"></i>
                    <span class="hide-menu">Pay out</span>
                    </a>
                </li>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">
                   <span class="docs-normal">Management</span>
                </h6>
                <!-- Navigation -->
                <li class="sidebar-item"> 
                   <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('profile')}}" aria-expanded="false">
                    <i class="mdi mdi-account-network"></i>
                    <span class="hide-menu">Profile</span>
                   </a>
                </li>
                <li class="sidebar-item"> 
                   <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('members')}}" aria-expanded="false">
                    <i class="mdi mdi-border-all"></i>
                    <span class="hide-menu">Members</span>
                   </a>
                </li>
                <!-- <li class="sidebar-item"> 
                   <a class="sidebar-link waves-effect waves-dark sidebar-link" href="icon-material.html" aria-expanded="false">
                    <i class="mdi mdi-face"></i>
                    <span class="hide-menu">Projects</span>
                   </a>
                </li> -->
                <li class="sidebar-item"> 
                   <a class="sidebar-link waves-effect waves-dark sidebar-link" href="error-404.html" aria-expanded="false">
                    <i class="mdi mdi-alert-outline"></i>
                    <span class="hide-menu">Others</span>
                   </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>