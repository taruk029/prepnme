    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <!-- Top Footer Area -->
        <div class="top-footer-area">
            <div class="">
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <!-- Footer Logo -->
                        <div class="footer-logo" style="color:#fff;">
                            PREPNME
                        </div>
                        <!-- Copywrite -->
                        <p style="color:#999987 !important; text-align:justify;">We're a full-service digital agency that believes being a Favorite brand is more valuable than just being a Famous one. We craft beautifully useful, connected ecosystems that grow businesses and build enduring relationships between brands and humans.</p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <!-- Footer Logo -->
                        <div class="footer-logo" style="color:#fff;">
                            QUICK LINKS
                        </div>
                        <!-- Copywrite -->
                        <p><ul>
                                <li><a href="https://www.prepnme.com" style="color:#999987;font-size:13px;font-weight:400;">Home</a></li>
                                <li><a href="https://www.prepnme.com/#about" style="color:#999987;font-size:13px;font-weight:400;">About</a></li>
                                <li><a href="https://www.prepnme.com/#how-it-works/" style="color:#999987;font-size:13px;font-weight:400;">How It Works</a></li>
                                <li><a href="https://www.prepnme.com/#testimonials" style="color:#999987;font-size:13px;font-weight:400;">Testimonials</a></li>
                                <li><a href="https://www.prepnme.com/#levels" style="color:#999987;font-size:13px;font-weight:400;">Pricing </a></li>
                                @if(Session::has('loggedin_user_id'))
                                <li><a href="#"><i class="fa fa-user-circle " ></i></a>
                                    <ul class="dropdown">
                                        <li><a href="{{ url('dashboard')}}" style="color:#999987;font-size:13px;font-weight:400;">Dashboard</a></li>
                                        <li><a href="{{ url('logout_user')}}" style="color:#999987;font-size:13px;font-weight:400;">Logout</a></li>
                                    </ul>
                                </li>
                                @else
                                    <li><a href="{{ url('login_user')}}" style="color:#999987;font-size:13px;font-weight:400;">Login</a></li>
                                @endif
                            </ul></p>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <!-- Footer Logo -->
                        <div class="footer-logo" style="color:#fff;">
                            PRICING
                        </div>
                        <!-- Copywrite -->
                        <p><ul>
                                <li><a href="https://www.prepnme.com/elementary-ssat-grades-3-4/" style="color:#999987;font-size:13px;font-weight:400;">Elementary Level Package</a></li>
                                <li><a href="https://www.prepnme.com/middle-level-package/" style="color:#999987;font-size:13px;font-weight:400;">Middle Level Package</a></li>
                                <li><a href="https://www.prepnme.com/upper-level-package/" style="color:#999987;font-size:13px;font-weight:400;">Upper Level Package</a></li>
                           </ul>
                        </p>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <!-- Footer Logo -->
                        <div class="footer-logo" style="color:#fff;">
                            CONNECT
                        </div>
                        <!-- Copywrite -->
                        <p>
                             <a href="mailto:admin@prepnme.com" style="color: #fff;font-size: 25px;"><i class="fa fa-envelope-o" aria-hidden="true"style="width: 32px;text-align: center;"></i><span style="font-size:15px;font-weight:400;">&nbsp;&nbsp;admin@prepnme.com</span></a>
                            
                        </p>
                        <br>
                        <p>
                             <a href="#" style="color: #fff;font-size: 19px;background-color: #1e73be;padding: 9px;border-radius: 50%;"><i class="fa fa-facebook" aria-hidden="true"style="width: 25px;text-align: center;"></i></a>
                             <a href="#" style="color: #fff;font-size: 19px;background-color: #1e73be;padding: 9px;border-radius: 50%;"><i class="fa fa-linkedin" aria-hidden="true"style="width: 25px;text-align: center;"></i></a>
                             <a href="#" style="color: #fff;font-size: 19px;background-color: #1e73be;padding: 9px;border-radius: 50%;"><i class="fa fa-twitter" aria-hidden="true"style="width: 25px;text-align: center;"></i></a>
                             <a href="#" style="color: #fff;font-size: 19px;background-color: #d33;padding: 9px;border-radius: 50%;"><i class="fa fa-google-plus" aria-hidden="true"style="width: 25px;text-align: center;"></i></a>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer Area -->
        <div class="bottom-footer-area d-flex justify-content-between align-items-center">
          
            <div class="contact-info" style="padding-left: 2%;color: #fff;font-size: 11px;letter-spacing: 2px;">
                © 2019 <span style="color: #8d7431;">PREPNME</span> | All rights reserved.
            </div>
            <!-- Follow Us -->
            <div class="follow-us" style="padding-right: 2%;color: #fff;font-size: 11px;letter-spacing: 2px;">
                Powered by  <span style="color: #8d7431;font-size: 11px;padding: 0 0px;text-transform: unset;">IntelleMind Tech. Pvt. Ltd.</span>

                <!--<span>Follow us</span>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>-->
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->