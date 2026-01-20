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
                <div class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2">Our Leadership</p>
                    <h1 class="display-5 mb-4">Cooperative Officers</h1>
                    <p class="mb-4">The Cooperative Officers of the Bohol DAR Employee & Community Multi-Purpose Cooperative is composed of dedicated leaders committed to the organization's mission and the welfare of its members.</p>
                </div>
            </div>

            <!-- Cooperative Officers Grouped by Department -->
            <?php foreach ($cooperative_officers as $department => $members): ?>
                <div class="mt-5">
                    <h3 class="text-primary mb-4 border-bottom pb-3">
                        <i class="bi bi-diagram-3"></i> <?php echo ucwords($department); ?>
                    </h3>
                    <div class="row g-4">
                        <?php foreach ($members as $member): ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="card">
                                    <img class="card-img-top" src="<?php echo base_url(); ?>images/<?php if($member->profileimage){ echo "cooperative_officers/profile/" . $member->profileimage; }else{ echo "avatar.png"; } ?>" alt="<?php echo $member->fname . " " . $member->lname; ?>">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-primary"><?php echo $member->position; ?></h5>
                                        <h4 class="card-title mb-3"><?php echo $member->fname . " " . $member->lname; ?></h4>
                                        <p class="card-text"><?php echo word_limiter(strip_tags($member->speech), 20); ?></p>
                                        <a href="<?php echo base_url(); ?>home/cooperative_officers/view/<?php echo $member->cooperative_officersid; ?>" class="btn btn-primary btn-sm">View Profile</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Cooperative Officers End -->

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
