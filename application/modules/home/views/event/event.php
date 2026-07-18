    <!-- Page Header Start -->
    <?php
        // Get the Event menu image
        $this->db->where_in('menuname', array('Event', 'Events'));
        $menu = $this->db->get('menu')->row();
        $bgImage = (isset($menu) && !empty($menu->menuimage)) 
            ? base_url() . 'images/website/menu/' . $menu->menuimage 
            : base_url() . 'themes/bodare/website/assets/img/default-bg.jpg';
    ?>
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(to right, rgb(2, 36, 91) 0%, rgba(2, 36, 91, 0) 100%), url(<?php echo $bgImage; ?>) center center no-repeat">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Events</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Events</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Events Start -->
    <div class="container-xxl py-5 event-page">
        <div class="container">
            <style>
                .event-page .event-item {
                    height: 100%;
                    background: #ffffff;
                    border: 1px solid rgba(0, 0, 0, .08);
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                    transition: .5s;
                }

                .event-page .event-item:hover {
                    box-shadow: 0 0 45px rgba(0, 0, 0, .08);
                }

                .event-page .event-item img {
                    width: 100%;
                    height: 240px;
                    object-fit: cover;
                    display: block;
                }

                .event-page .event-item .event-meta span {
                    display: block;
                    font-size: 14px;
                    color: #666;
                    margin-bottom: 6px;
                }

                .event-page .event-item .event-meta i {
                    color: var(--primary);
                    width: 18px;
                }

                .event-page .pagination {
                    justify-content: center;
                    margin-top: 2rem;
                    gap: 5px;
                }

                .event-page .pagination li a,
                .event-page .pagination li span {
                    display: block;
                    padding: 8px 16px;
                    border: 1px solid rgba(0, 0, 0, .1);
                    color: var(--primary);
                    text-decoration: none;
                    transition: .3s;
                }

                .event-page .pagination li a:hover {
                    background: var(--primary);
                    color: #ffffff;
                }

                .event-page .pagination li.active a {
                    background: var(--primary);
                    border-color: var(--primary);
                    color: #ffffff;
                }
            </style>
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary mb-2">Our Events</p>
                <h1 class="display-5 mb-5">All Events</h1>
            </div>
            <div class="row g-4">
                <?php 
                $delays = [0.1, 0.3, 0.5];
                $index = 0;
                foreach ($event as $event) { 
                    $delay = $delays[$index % 3];
                    $index++;
                ?>
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="<?php echo $delay; ?>s">
                        <div class="event-item">
                            <a href="<?php echo base_url(); ?>home/event/view/<?php echo $event->eventid; ?>">
                                <img class="img-fluid" src="<?php echo base_url(); ?>images/event/feature/<?php echo $event->eventimage; ?>" alt="Event Banner">
                            </a>
                            <div class="p-4 d-flex flex-column flex-grow-1">
                                <div class="event-meta mb-3">
                                    <span><i class="fa fa-calendar"></i> Time - <?php echo $event->eventtime; ?>, <?php echo $event->eventdate; ?></span>
                                    <span><i class="fa fa-map-marker-alt"></i> Location - <?php echo $event->eventlocation; ?></span>
                                </div>
                                <h4 class="mb-0"><a href="<?php echo base_url(); ?>home/event/view/<?php echo $event->eventid; ?>"><?php echo $event->eventtitle; ?></a></h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Events End -->

    <!-- Call to Action Start -->
    <div class="container-fluid bg-primary bg-gradient my-5 py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 text-white mb-0">Want to Join Our Events?</h1>
                    <p class="text-white mb-4">Stay connected with the cooperative community. Reach out to us for more details about upcoming activities and how you can participate.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo base_url(); ?>home/contact" class="btn btn-light py-3 px-5">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->
