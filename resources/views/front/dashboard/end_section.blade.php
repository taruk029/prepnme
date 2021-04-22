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
                            <?php if (strpos($section->section, 'Writing')) 
                            {
                            ?>
                            <input type="hidden" id="section_type" name="section_type" value="1">
                            <?php }
                            else { ?>   
                            <input type="hidden" id="section_type" name="section_type" value="0">
                        <?php } ?>
                        </div>

                        <div class="clever-tabs-content">
                            
                            <div class="tab-content" id="myTabContent" >
                                <!-- Tab Text -->
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-description">
                                        <!-- FAQ -->
                                        <div class="clever-faqs">
                                             <h4>Ready to score this section?</h4>
                                             <p>You won’t be able to come back. Don’t forget to check your work.</p><br>
                                            <center>
                                           <div style="border-top: 1px solid #eeeeee;padding: 20px;">
                                                <!-- <a href="{{ url('end/'.Request::segment(2).'/'.Request::segment(3)) }}" class="btn clever-btn" style="width: 300px;background: #e41515;">End & Score</a> -->
                                                <a href="javascript:void(0)" onclick="javascript:end()" class="btn clever-btn" style="width: 300px;background: #e41515;">End & Score</a>

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


<script type="text/javascript">
    
    function end()
    {
        var type = $("#section_type").val();
        if(type==1)
        {
            $.blockUI({ message: "<i class='fa fa-spinner' ></i> &nbsp; <h4>Please wait.</h4> It will take about 20 seconds before the submission is complete." });
        }
        var url = "{{ url('end/'.Request::segment(2).'/'.Request::segment(3)) }}";
        window.location.replace(url);
    }
</script>
