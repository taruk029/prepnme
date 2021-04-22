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
                    <a class="nav-brand" href="https://www.prepnme.com"><img src="<?php echo e(asset('front/img/core-img/logo.png')); ?>" alt=""></a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">

                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li><a href="https://www.prepnme.com">Home</a></li>
                                <li><a href="https://www.prepnme.com/#about">About</a></li>
                                <li><a href="https://www.prepnme.com/#how-it-works/">How It Works</a></li>
                                <li><a href="https://www.prepnme.com/#testimonials">Testimonials</a></li>
                                <li><a href="https://www.prepnme.com/#levels">Pricing </a></li>
                                <?php if(Session::has('loggedin_user_id')): ?>
                                <li><a href="#"><i class="fa fa-user-circle " ></i></a>
                                    <ul class="dropdown">
                                        <li><a href="<?php echo e(url('dashboard')); ?>">Dashboard</a></li>
                                        <li><a href="<?php echo e(url('logout_user')); ?>">Logout</a></li>
                                    </ul>
                                </li>
                                <?php else: ?>
                                    <li><a href="<?php echo e(url('login_user')); ?>">Login</a></li>
                                <?php endif; ?>
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
                </nav>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### --><?php /**PATH C:\xampp\htdocs\Prepnme\resources\views/front/layout/header.blade.php ENDPATH**/ ?>