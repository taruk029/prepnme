@extends('front.layout.app')
@section('title', 'Login')
@section('content')
    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url({{ asset('front/img/bg-img/login.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <h2>User Account</h2>
                        <!-- <a href="#" class="btn clever-btn">Get Started</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->
    <div class="single-course-content section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="course--content">

                        <div class="clever-tabs-content">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.prepnme.com/#levels">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab--2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.prepnme.com/password-recovery/" >Forgot Password</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                
                                <!-- Tab Text -->
                                <div class="tab-pane fade show active" id="tab2" role="tabpanel" aria-labelledby="tab--2">
                                    <div class="clever-curriculum">

                                        <div class="about-curriculum mb-30">
                                            <h4>Login</h4>
                                            @if(Session::has('error'))
                                            <div class="alert alert-danger" role="alert" id="alert_notify">
                                              {{ Session::get( 'error' ) }}
                                            </div>
                                            @endif
                                            <form action="{{ url('login_user') }}" method="post" >
                                                 {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                                            <span style="color: red"> 
                                                                @if ($errors->has('username'))
                                                                    <strong>{{ $errors->first('username') }}</strong>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                                            <span style="color: red"> 
                                                                @if ($errors->has('password'))
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <div><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />
                                                                <label for="remember-me">Remember me</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2">
                                                        <button type="submit" class="btn clever-btn"><i class="fa  fa-sign-in "></i> Login</button>
                                                    </div>
                                                </div><br>
                                                <!-- <div class="row">
                                                    <div class="col-6">
                                                        <label>Upgrade your account to get the practice you need! 
                                                            <a href="https://www.prepnme.com/rm_login/" style="text-decoration: underline; color: #3762f0" >Click Here to Upgrade</a>
                                                        </label>
                                                    </div>
                                                </div> -->
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Text -->
                                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab--3">
                                    <div class="clever-curriculum">

                                        <div class="about-curriculum mb-30">
                                            <h4>Forgot Password</h4>
                                            <form action="{{ url('login_user') }}" method="post" >
                                                 {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username or Email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2">
                                                        <button type="submit" class="btn clever-btn">Email Password Link</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
