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
                                <p style="margin-top: 10px; line-height: 26px;">PrepNMe {{ $membership_level->name }}</p>
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
                                             <h4>Your time for this section is over.</h4>
                                            <center>
                                           <div style="border-top: 1px solid #eeeeee;padding: 20px;">
                                                <a href="{{ url('dashboard') }}" class="btn clever-btn" style="width: 300px;background: #e41515;">Go To Dashboard</a>
                                                 <a href="{{ url('analysis/'.Request::segment(2).'/'.Request::segment(3).'/'.base64_encode(0)) }}" class="btn clever-btn" style="width: 300px;">Go To Analysis</a>
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
