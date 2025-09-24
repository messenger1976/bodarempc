<!-- Carousel Start -->
    <div class="container-fluid px-0 mb-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">



                

                <?php $i=0; foreach ($slider as $slide) { $i++;?>     
                    <div class="carousel-item <?php if($i == 1){echo "active";} ?>">
                        <img class="w-100" src="<?php echo base_url();?>images/website/slider/<?php echo $slide->filename; ?>" alt="Image">
                        <div class="carousel-caption">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10 text-start">
                                        <p class="fs-5 fw-medium text-primary text-uppercase animated slideInRight"><?php echo $slide->subtitle; ?></p>
                                        <h1 class="display-1 text-white mb-5 animated slideInRight"><?php echo $slide->content; ?></h1>
                                        <?php
                                        if(!empty($slide->button_text)){
                                        ?>
                                            <a href="<?php echo $slide->button_link; ?>" class="btn btn-primary py-3 px-5 animated slideInRight"><?php echo $slide->button_text; ?></a>
                                            
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     
                <?php } ?>

                


                
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="row gx-3 h-100">
                        <div class="col-6 align-self-start wow fadeInUp" data-wow-delay="0.1s">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/about-1.jpg">
                        </div>
                        <div class="col-6 align-self-end wow fadeInDown" data-wow-delay="0.1s">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/about-2.jpg">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2">About Us</p>
                    <h1 class="display-5 mb-4">Brief History</h1>
                    <p class="mb-4">The Bohol DAR Employee & Community Multi - Purpose Cooperative is a duly registered cooperative initially organized in 1991. It was constituted by a group of seventy-five(75) determined DAR employees whose main purpose was to give financial assistance to its DAR members.</p>

                    <p class="mb-4">The Cooperative started with a paid- up capital of only Php 12,840.00. This was initially extended to the members in the forms of loans with an interest rate of 5% (now increased to 16%). Through prudent management. BODARE has long been experiencing a net surplus from its lending operations.
                    </p>
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0 bg-primary p-5">
                            <h1 class="display-2">34</h1>
                            <h5 class="text-white">Years of</h5>
                            <h5 class="text-white">Existence</h5>
                        </div>
                        <div class="ms-4">
                            <h3 class="mb-4">Goals and Objectives</h3>
                            <p><i class="fa fa-check text-primary me-2"></i>To implement credit assistance with reasonable interest , mortuary and health programs, time and savings deposits and other services.</p>
                            <p><i class="fa fa-check text-primary me-2"></i>To provide trainings and information related to officers , staff and members development .</p>
                            <p class="mb-0"><i class="fa fa-check text-primary me-2"></i>To access technical and financial assistance to concerned stockholders</p>
                            
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-envelope-open text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-2">Email us</p>
                                    <h5 class="mb-0">bodarempc@yahoo.com</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-phone-alt text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-2">Call us</p>
                                    <h5 class="mb-0">038-422-8034</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Facts Start -->
    <div class="container-fluid facts my-5 p-5">
        <div class="row g-5">
            <div class="col-md-6 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="text-center border p-5">
                    <i class="fa fa-certificate fa-3x text-white mb-3"></i>
                    <h1 class="display-2 text-primary mb-0" data-toggle="counter-up">34</h1>
                    <span class="fs-5 fw-semi-bold text-white">Years Existence</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 wow fadeIn" data-wow-delay="0.3s">
                <div class="text-center border p-5">
                    <i class="fa fa-users-cog fa-3x text-white mb-3"></i>
                    <h1 class="display-2 text-primary mb-0" data-toggle="counter-up">135</h1>
                    <span class="fs-5 fw-semi-bold text-white">Staff Members</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 wow fadeIn" data-wow-delay="0.5s">
                <div class="text-center border p-5">
                    <i class="fa fa-users fa-3x text-white mb-3"></i>
                    <h1 class="display-2 text-primary mb-0" data-toggle="counter-up">1228</h1>
                    <span class="fs-5 fw-semi-bold text-white">Happy Members</span>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 wow fadeIn" data-wow-delay="0.7s">
                <div class="text-center border p-5">
                    <i class="fa fa-check-double fa-3x text-white mb-3"></i>
                    <h1 class="display-2 text-primary mb-0">136M</h1>
                    <span class="fs-5 fw-semi-bold text-white">Assets</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Facts End -->

        <!-- Features Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative me-lg-4">
                        <img class="img-fluid w-100" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/feature.jpg" alt="">
                        <span
                            class="position-absolute top-50 start-100 translate-middle bg-white rounded-circle d-none d-lg-block"
                            style="width: 120px; height: 120px;"></span>
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2">Why Choosing Us!</p>
                    <h1 class="display-5 mb-4">Few Reasons Why People Choosing Us!</h1>
                    <p class="mb-4">These are the values that define us. They are the heart of our cooperatives culture and the principles we live by, guiding us in everything we do.
                    </p>
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Committed</h4>
                                    <span>To the ongoing education of its members about the cooperative principles and values. Seeks ways to improve its services and operations to better meet the evolving needs of its members.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Alliance</h4>
                                    <span>Committed to the well-being of its broader community. It works for the sustainable development of its members' communities through shared initiatives and policies.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Reliable</h4>
                                    <span>Built on trust and transparency, our purpose is to serve you, our members, consistently and for the long term.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Excellent</h4>
                                    <span>It means going beyond what's expected to create exceptional value for our members and community.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary">
                                    <i class="fa fa-check text-white"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Service Oriented</h4>
                                    <span>Where members are the users of the service and share in the benefits.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Video Modal Start -->
    <div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Youtube Video</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <!--<p class="fw-medium text-uppercase text-primary mb-2">Our Products & Services</p>-->
                <h1 class="display-5 mb-4">Our Products & Services</h1>
            </div>
            <div class="row gy-5 gx-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-1.jpg" alt="">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-1.jpg" alt="">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Lending Operations</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Salary, Petty Cash, Motor Vehicle Loans, Appliance, Business, Bonus, PO’s Grocery and Dept.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-2.jpg" alt="">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-2.jpg" alt="">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Building Rental</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-3.jpg" alt="">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-3.jpg" alt="">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Savings and Time Deposits</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="">Read More</a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-4.jpg" alt="">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-4.jpg" alt="">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Mortuary Aid</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="">Read More</a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-2.jpg" alt="">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-2.jpg" alt="">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">BODARE Coop Pension House</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Erat ipsum justo amet duo et elitr dolor, est duo duo eos
                                    lorem sed diam stet diam sed stet.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->



    <!-- Project Start -->
    <div class="container-fluid bg-dark pt-5 my-5 px-0">
        <div class="text-center mx-auto mt-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="fw-medium text-uppercase text-primary mb-2">Our Projects</p>
            <h1 class="display-5 text-white mb-5">See What We Have Completed Recently</h1>
        </div>
        <div class="owl-carousel project-carousel wow fadeIn" data-wow-delay="0.1s">
            <a class="project-item" href="">
                <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/project-1.jpg" alt="">
                <div class="project-title">
                    <h5 class="text-primary mb-0">Auto Engineering</h5>
                </div>
            </a>
            <a class="project-item" href="">
                <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/project-2.jpg" alt="">
                <div class="project-title">
                    <h5 class="text-primary mb-0">Civil Engineering</h5>
                </div>
            </a>
            <a class="project-item" href="">
                <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/project-3.jpg" alt="">
                <div class="project-title">
                    <h5 class="text-primary mb-0">Gas Engineering</h5>
                </div>
            </a>
            <a class="project-item" href="">
                <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/project-4.jpg" alt="">
                <div class="project-title">
                    <h5 class="text-primary mb-0">Power Engineering</h5>
                </div>
            </a>
            <a class="project-item" href="">
                <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/project-5.jpg" alt="">
                <div class="project-title">
                    <h5 class="text-primary mb-0">Energy Engineering</h5>
                </div>
            </a>
            <a class="project-item" href="">
                <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/project-6.jpg" alt="">
                <div class="project-title">
                    <h5 class="text-primary mb-0">Water Engineering</h5>
                </div>
            </a>
        </div>
    </div>
    <!-- Project End -->


    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Our Team</p>
                <h1 class="display-5 mb-5">Dedicated Team Members</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/team-1.jpg" alt="">
                        <div class="d-flex">
                            <div class="flex-shrink-0 btn-square bg-primary" style="width: 90px; height: 90px;">
                                <i class="fa fa-2x fa-share text-white"></i>
                            </div>
                            <div class="position-relative overflow-hidden bg-light d-flex flex-column justify-content-center w-100 ps-4"
                                style="height: 90px;">
                                <h5>Rob Miller</h5>
                                <span class="text-primary">CEO & Founder</span>
                                <div class="team-social">
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/team-2.jpg" alt="">
                        <div class="d-flex">
                            <div class="flex-shrink-0 btn-square bg-primary" style="width: 90px; height: 90px;">
                                <i class="fa fa-2x fa-share text-white"></i>
                            </div>
                            <div class="position-relative overflow-hidden bg-light d-flex flex-column justify-content-center w-100 ps-4"
                                style="height: 90px;">
                                <h5>Adam Crew</h5>
                                <span class="text-primary">Project Manager</span>
                                <div class="team-social">
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/team-3.jpg" alt="">
                        <div class="d-flex">
                            <div class="flex-shrink-0 btn-square bg-primary" style="width: 90px; height: 90px;">
                                <i class="fa fa-2x fa-share text-white"></i>
                            </div>
                            <div class="position-relative overflow-hidden bg-light d-flex flex-column justify-content-center w-100 ps-4"
                                style="height: 90px;">
                                <h5>Peter Farel</h5>
                                <span class="text-primary">Engineer</span>
                                <div class="team-social">
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square btn-dark rounded-circle mx-1" href=""><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Testimonial</p>
                <h1 class="display-5 mb-5">What Our Clients Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item text-center">
                    <div class="testimonial-img position-relative">
                        <img class="img-fluid rounded-circle mx-auto mb-5" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/testimonial-1.jpg">
                        <div class="btn-square bg-primary rounded-circle">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                    </div>
                    <div class="testimonial-text text-center rounded p-4">
                        <p>Clita clita tempor justo dolor ipsum amet kasd amet duo justo duo duo labore sed sed. Magna
                            ut diam sit et amet stet eos sed clita erat magna elitr erat sit sit erat at rebum justo sea
                            clita.</p>
                        <h5 class="mb-1">Client Name</h5>
                        <span class="fst-italic">Profession</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <div class="testimonial-img position-relative">
                        <img class="img-fluid rounded-circle mx-auto mb-5" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/testimonial-2.jpg">
                        <div class="btn-square bg-primary rounded-circle">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                    </div>
                    <div class="testimonial-text text-center rounded p-4">
                        <p>Clita clita tempor justo dolor ipsum amet kasd amet duo justo duo duo labore sed sed. Magna
                            ut diam sit et amet stet eos sed clita erat magna elitr erat sit sit erat at rebum justo sea
                            clita.</p>
                        <h5 class="mb-1">Client Name</h5>
                        <span class="fst-italic">Profession</span>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <div class="testimonial-img position-relative">
                        <img class="img-fluid rounded-circle mx-auto mb-5" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/testimonial-3.jpg">
                        <div class="btn-square bg-primary rounded-circle">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                    </div>
                    <div class="testimonial-text text-center rounded p-4">
                        <p>Clita clita tempor justo dolor ipsum amet kasd amet duo justo duo duo labore sed sed. Magna
                            ut diam sit et amet stet eos sed clita erat magna elitr erat sit sit erat at rebum justo sea
                            clita.</p>
                        <h5 class="mb-1">Client Name</h5>
                        <span class="fst-italic">Profession</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->









    
    

    <div class="animate-in cs_sections map" data-anim-type="bounce-in-up-large"  data-anim-delay="600"  >
        <iframe
            width="100%"
            height="700"
            frameborder="0" style="border:0; pointer-events: none;"
            src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>&q=<?php echo $basic->map; ?>" allowfullscreen>
        </iframe>
    </div>

    <div class="animate-in cs_sections parallax" data-parallax="scroll" data-image-src="images/slide07.jpg" data-anim-type="bounce-in-up-large"  data-anim-delay="600"  >
        <div class="content">
        <div class="container">
            <h2>Contact With Us</h2>

            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            <div class="col-md-offset-2 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <form id="contactform" class="form-horizontal" action="<?php echo base_url();?>home/home/contactWithUs" method="post" enctype="multipart/form-data">
                    <div class="column one-second">
                        <input placeholder="Your name" type="text" name="name" required>
                    </div>
                    <div class="column one-second">
                        <input placeholder="Your e-mail" type="email" name="email" required>
                    </div>
                    <div class="column one">
                        <input placeholder="Subject" type="text" name="subject" id="subject" required>
                    </div>
                    <div class="column one">
                        <textarea placeholder="Message" name="body" id="body" style="width:100%;" rows="10" required></textarea>
                    </div>
                    <div class="column one">
                        <input type="submit" value="Send Now" id="submit" >
                    </div>
                </form>
            </div>
        </div>	
        </div>
    </div>