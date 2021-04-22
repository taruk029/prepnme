@extends('front.layout.app')
@section('title', 'Welcome')
@section('content')
    
    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url({{ asset('front/img/bg-img/test.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <h2>Welcome to Scoolars</h2>
                        <!-- <a href="#" class="btn clever-btn">Get Started</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Cool Facts Area Start ##### -->
    <section class="cool-facts-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="250ms">
                        
                        <h2><i class="fa fa-desktop"></i></h2>
                        <h5><a href="{{ url('web-app') }}">Access your mini test and diagnostics</a></h5><br>
                        <div class="register-login-area">
                                <a href="index-login.html" class="btn active">View Dashboard</a>
                            </div>
                    </div>
                </div>

                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="500ms">
                        
                        <h2><i class="fa fa-arrow-circle-up"></i></h2>
                        <h5><a href="{{ url('pricing') }}">Get more practice tests.</a></h5><br>
                        <div class="register-login-area">
                              <a href="index-login.html" class="btn active">Upgrade</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
