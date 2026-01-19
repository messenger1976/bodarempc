    <!-- Page Header Start -->
    <?php
        // Get the Products menu image
        $this->db->where('menuname', 'Products');
        $menu = $this->db->get('menu')->row();
        $bgImage = (isset($menu) && !empty($menu->menuimage)) 
            ? base_url() . 'images/website/menu/' . $menu->menuimage 
            : base_url() . 'themes/bodare/website/assets/img/default-bg.jpg';
    ?>
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(to right, rgb(2, 36, 91) 0%, rgba(2, 36, 91, 0) 100%), url(<?php echo $bgImage; ?>) center center no-repeat">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Our Products & Services</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products & Services</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <p class="fw-medium text-uppercase text-primary mb-2">What We Offer</p>
                <h1 class="display-5 mb-4">Our Products & Services</h1>
                <p class="mb-0">BODARE provides comprehensive financial and community services designed to support our members' growth and well-being. Explore our range of products and services tailored to meet your needs.</p>
            </div>
            <div class="row gy-5 gx-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-1.jpg" alt="Lending Operations">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-1.jpg" alt="Lending Operations">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Lending Operations</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Salary, Petty Cash, Motor Vehicle Loans, Appliance, Business, Bonus, PO's Grocery and Dept.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="#">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-2.jpg" alt="Building Rental">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-2.jpg" alt="Building Rental">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Building Rental</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">This expansive office suite offers a premier location and a functional layout designed for productivity. The space includes private offices, a large central conference room with a projector, and a welcoming reception area for clients. It provides commanding views and an abundance of natural light. The building features 24/7 security, high-speed fiber optic internet, and a fully equipped kitchen area for tenant use</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="#">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-3.jpg" alt="Savings and Time Deposits">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-3.jpg" alt="Savings and Time Deposits">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Savings and Time Deposits</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Your future is worth investing in. Open a savings account with us today and watch your money grow. It's safe, simple, and the smart choice for a secure tomorrow.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="#">Read More</a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-4.jpg" alt="Mortuary Aid">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-4.jpg" alt="Mortuary Aid">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">Mortuary Aid</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Relieve the financial and emotional stress of an unexpected loss.</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="#">Read More</a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-5.jpg" alt="BODARE Coop Pension House">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-5.jpg" alt="BODARE Coop Pension House">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">BODARE Coop Pension House</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Why pay more for a fancy room you'll barely use? At BODARE Pension House, we give you everything you need for a comfortable stay at a fraction of the cost. Clean rooms, friendly service, and a great location. Book now and start your adventure!</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="#">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item">
                        <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-6.jpg" alt="BODARE Crown Residences">
                        <div class="service-img">
                            <img class="img-fluid" src="<?php echo base_url(); ?>themes/bodare/website/assets/img/service-6.jpg" alt="BODARE Crown Residences">
                        </div>
                        <div class="service-detail">
                            <div class="service-title">
                                <hr class="w-25">
                                <h3 class="mb-0">BODARE Crown Residences</h3>
                                <hr class="w-25">
                            </div>
                            <div class="service-text">
                                <p class="text-white mb-0">Coming Soon...</p>
                            </div>
                        </div>
                        <a class="btn btn-light" href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Call to Action Start -->
    <div class="container-fluid bg-primary bg-gradient my-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 text-white mb-0">Ready to Get Started?</h1>
                    <p class="text-white mb-4">Join BODARE today and experience the benefits of being a member. Our team is here to help you find the right products and services for your needs.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo base_url(); ?>home/home/contact" class="btn btn-light py-3 px-5">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->

