<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/logo.jpg')}}">
    <title>Friends With a Purpose</title>
    <!-- Custom CSS -->
    <link href="{{asset('assets/libs/chartist/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css">
    <link href="{{ asset('vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/style.css')}}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="text-decoration-none">
    <div id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header id="header">
            <div class="container-fluid">
            <div id="logo" class="pull-left">
                <a class="navbar-brand" href="index.html">
                    <b class="logo-icon">
                        <img height="60px" src="{{asset('images/logo.jpg')}}" alt="logo" />
                    </b>
                    <span class="font-14" style="color: white;">Friends With a Purpose</span>
                </a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <a href="{{route('login')}}" class="nav-link text-white waves-effect waves-dark pro-pic font-12" href=""aria-expanded="false">Accountability</a>
                </ul>
            </nav>
            </div>
        </header>
        <section id="intro">
                <div class="intro-container">
                    <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators"></ol>
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <div class="carousel-background"><img src="{{ asset('profiles/image6.jpeg')}}" alt=""></div>
                                    <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2>Friends With a Purpose Assotiation</h2>
                                        <p>
                                            To be Financially Independent...
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-background"><img src="{{ asset('profiles/image7.jpeg')}}" alt=""></div>
                                <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2>Vision</h2>
                                        <p>
                                            "A united, excellent and prosperous memberships"
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-background"><img src="{{ asset('profiles/image3.jpeg')}}" alt=""></div>
                                <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2>Mission</h2>
                                        <p>
                                            To promote prosperity through unity, innovation and investment
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-background"><img src="{{ asset('profiles/image1.jpeg')}}" alt=""></div>
                                <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2>Main Objective</h2>
                                        <p>
                                            To maintain a spirit of fellowship while encouraging financial growth for one another
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-background"><img src="{{ asset('profiles/image4.jpeg')}}" alt=""></div>
                                <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2>Specific Objectives</h2>
                                        <p>
                                            To promote/enhance development amongst the members through assisting the members bothe in agony and joy.
                                        </p>
                                        <p>
                                            To encourage personal development amongst members by way of money contributions
                                            as shall be agreed by members in this Association.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="carousel-background"><img src="{{ asset('profiles/image2.jpeg')}}" alt=""></div>
                                <div class="carousel-container">
                                    <div class="carousel-content">
                                        <h2>Specific Objectives</h2>
                                        <p>
                                            To sensitize the members through designing various strategies and schemes that
                                            shall enhance development among the members.
                                        </p>
                                        <p>
                                            To create and promote the system of saving and credit among the members.
                                        </p>
                                        <p>
                                            Undertake any other activities related to the above for the prosperity of members.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
        </section>
    </div>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    </body>
</html>