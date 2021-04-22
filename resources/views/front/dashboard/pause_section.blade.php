@extends('front.layout.dashboard_app')
@section('title', 'Dashboard')
@section('content')


    <div class="single-course-content section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="course--content">
                        <div class="header_test">
                            <div class="col-12 col-lg-8" style="float: left;">
                                <p style="margin-top: 10px; line-height: 26px;">PrepNMe {{ $tests->test_name }}</p>
                                <p class="section_heading">{{ $section->section }}</p>
                            </div>
                        
                        </div>

                        <div class="clever-tabs-content">
                            
                            <div class="tab-content" id="myTabContent" >
                                <!-- Tab Text -->
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-description">
                                        <!-- FAQ -->
                                        <div class="clever-faqs">
                                             <h4>You’ve paused this section!</h4>
                                              <p>From your dashboard, you’ll be able to pick up where you left off whenever you’re ready.</p>
                                              <br>
                                            <center>
                                           <div style="border-top: 1px solid #eeeeee;padding: 20px;">
                                                <a href="{{ url('pause/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)) }}" class="btn clever-btn" style="width: 300px;background: #e41515;">Leave For Now</a>
                                                  <a href="{{ $_SERVER['HTTP_REFERER'] }}" class="btn clever-btn" style="width: 300px;">Keep Working</a>
                                           </div>
                                           </center>
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
    <!-- ##### Courses Content End ##### -->
@endsection
