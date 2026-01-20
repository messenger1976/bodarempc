<!-- Page Header Start -->
    <?php
        // Get the Cooperative Officers menu image
        $this->db->where('menuname', 'Cooperative Officers');
        $menu = $this->db->get('menu')->row();
        $bgImage = (isset($menu) && !empty($menu->menuimage)) 
            ? base_url() . 'images/website/menu/' . $menu->menuimage 
            : base_url() . 'themes/bodare/website/assets/img/members-training.jpg';
    ?>
    <div class="container-fluid py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(to right, rgb(2, 36, 91) 0%, rgba(2, 36, 91, 0) 100%), url(<?php echo $bgImage; ?>) center center no-repeat">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Cooperative Officers</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cooperative Officers</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Cooperative Officers Start -->
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
                    <p class="fw-medium text-uppercase text-primary mb-2">Cooperative Officers</p>
                    <h1 class="display-5 mb-4">Leadership Structure</h1>
                    <p class="mb-4">The Cooperative Officers of the Bohol DAR Employee & Community Multi-Purpose Cooperative is composed of dedicated leaders committed to the organization's mission and the welfare of its members. They provide strategic guidance and oversight to ensure the cooperative remains strong and true to its values.</p>

                    <p class="mb-4">Our officers bring diverse expertise and a shared commitment to serving the cooperative's members with integrity, transparency, and excellence.</p>
                    
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
    <!-- Cooperative Officers End -->

    <!-- Cooperative Officers Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12 text-center wow fadeIn" data-wow-delay="0.1s">
                    <h2 class="display-5 mb-5">Cooperative Officers</h2>
                </div>
            </div>

            <!-- Cooperative Officers Grouped by Department -->
            <?php foreach ($cooperative_officers as $department => $members): ?>
                <div class="mt-5">
                    <h3 class="text-primary mb-4 border-bottom pb-3">
                        <i class="fa fa-sitemap"></i> <?php echo ucwords($department); ?>
                    </h3>
                    <div class="row g-4">
                        <?php foreach ($members as $member): ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="card card-profile" style="padding: 10px;">
                                    <div class="card-avatar" style="text-align: center;">
                                        <img class="img" src="<?php echo base_url(); ?>images/<?php if($member->profileimage){ echo "cooperative_officers/profile/" . $member->profileimage; }else{ echo "avatar.png"; } ?>" alt="<?php echo $member->fname . " " . $member->lname; ?>">
                                    </div>
                                    <div class="content text-center">
                                        <h6 class="category text-gray"><?php echo $member->position; ?></h6>
                                        <h4 class="card-title"><?php echo $member->fname . " " . $member->lname; ?></h4>
                                        <p class="card-content speech"><?php echo word_limiter(strip_tags($member->speech), 20); ?></p>
                                        <div class="action-btn">
                                            <a href="<?php echo base_url(); ?>home/cooperative_officers/view/<?php echo $member->cooperative_officersid; ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Cooperative Officers End -->

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
