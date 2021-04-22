 <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- Top Header Area -->
        <!-- <div class="top-header-area d-flex justify-content-between align-items-center"> -->
            <!-- Contact Info -->
           <!--  <div class="contact-info">
                <a href="#"><span>Phone:</span> +44 300 303 0266</a>
                <a href="#"><span>Email:</span> info@clever.com</a>
            </div> -->
            <!-- Follow Us -->
            <!-- <div class="follow-us">
                <span>Follow us</span>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </div>
        </div> -->

        <!-- Navbar Area -->
        <div class="clever-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="cleverNav">

                    <!-- Logo -->
                    @if(Request::segment(1)!="user_test" && Request::segment(1)!="pause_section" && Request::segment(1)!="end_section" )
                    <a class="nav-brand" href="{{ url('dashboard')}}"><img src="{{ asset('front/img/core-img/logo.png') }}" alt=""></a>
                    @else
                     <a class="nav-brand" href="javascript:void(0)"><img src="{{ asset('front/img/core-img/logo.png') }}" alt=""></a>
                    @endif
                    @if(Request::segment(1)!="user_test" && Request::segment(1)!="pause_section" && Request::segment(1)!="end_section" )

                    <!-- Menu -->
                    <div class="classy-menu">

                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <div style="<?php if(Request::segment(1)=="result") echo "width: 40%"; else echo "width: 54%"; ?>;"></div>
                            <ul>                               
                                <li><a href="{{ url('dashboard')}}">Dashboard</a></li>
                                @if(Request::segment(1)=="result")
                                    <li><a href="{{ url('analysis/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4))}}">Analysis</a></li>
                                @endif
                                @if(Session::has('loggedin_user_id'))
                                <li><a href="#"><i class="fa fa-user-circle " ></i></a>
                                    <ul class="dropdown">
                                       <!--  <li><a href="{{ url('account')}}">Account</a></li> -->
                                        <li><a href="{{ url('dashboard')}}">Dashboard</a></li>
                                        <li><a href="{{ url('logout_user')}}">Logout</a></li>
                                    </ul>
                                </li>
                                @else
                                <li><a href="{{ url('login_user')}}">Login</a></li>
                                @endif
                            </ul>

                            <!-- Search Button -->
                            <!-- <div class="search-area">
                                <form action="#" method="post">
                                    <input type="search" name="search" id="search" placeholder="Search">
                                    <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div> -->

                            <!-- Register / Login -->
                            <!-- <div class="register-login-area">
                                <a href="index-login.html" class="btn active">Login</a>
                            </div> -->

                        </div>
                        <!-- Nav End -->
                    </div>
                     @else
        <span style="float: right !important; "><i class="fa fa-user-circle"></i> {{Session::get('user_email')}}</span>
        @endif
                </nav>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->