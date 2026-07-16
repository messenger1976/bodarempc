    <!-- Page Header Start -->
    <?php
        // Get the Gallery menu image
        $this->db->where('menuname', 'Gallery');
        $menu = $this->db->get('menu')->row();
        $bgImage = (isset($menu) && !empty($menu->menuimage)) 
            ? base_url() . 'images/website/menu/' . $menu->menuimage 
            : base_url() . 'themes/bodare/website/assets/img/default-bg.jpg';
    ?>
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(to right, rgb(2, 36, 91) 0%, rgba(2, 36, 91, 0) 100%), url(<?php echo $bgImage; ?>) center center no-repeat">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Gallery Start -->
    <div class="container-xxl py-5 gallery-page">
        <div class="container">
            <style>
                .gallery-page .project-item {
                    overflow: hidden;
                    height: 100%;
                    background: var(--dark);
                    display: flex;
                    flex-direction: column;
                }

                .gallery-page .project-item img {
                    width: 100%;
                    height: 260px;
                    object-fit: cover;
                    display: block;
                    margin-top: 0 !important;
                }

                .gallery-page .project-item .project-title {
                    position: relative !important;
                    bottom: auto !important;
                    left: auto;
                    height: 56px;
                    margin-top: 0;
                    width: 100%;
                }

                .gallery-page .project-item .project-title::before {
                    display: none;
                }
            </style>
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Our Gallery</p>
                <h1 class="display-5 mb-5">See What We Have Recently</h1>
            </div>
            <div class="row g-4">
                <?php 
                $delays = [0.1, 0.3, 0.5];
                $index = 0;
                foreach ($gallery as $item) { 
                    $delay = $delays[$index % 3];
                    $index++;
                ?>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                        <a class="project-item gallery-lightbox" href="<?php echo base_url(); ?>images/website/gallery/large/<?php echo $item->filename; ?>" data-title="<?php echo $item->title; ?>" data-gallery="gallery">
                            <img class="img-fluid" src="<?php echo base_url(); ?>images/website/gallery/small/<?php echo $item->filename; ?>" alt="<?php echo $item->title; ?>">
                            <div class="project-title">
                                <h5 class="text-primary mb-0"><?php echo $item->title; ?></h5>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Gallery End -->

    <!-- Call to Action Start -->
    <div class="container-fluid bg-primary bg-gradient my-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 text-white mb-0">Want to See More?</h1>
                    <p class="text-white mb-4">Visit us in person to experience the full range of our facilities and services. Our team is always happy to show you around and answer any questions.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo base_url(); ?>home/home/contact" class="btn btn-light py-3 px-5">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->

    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    
    <!-- Lightbox JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({
                selector: '.gallery-lightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true
            });
        });
    </script>

