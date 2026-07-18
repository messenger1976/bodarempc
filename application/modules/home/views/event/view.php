    <!-- Page Header Start -->
    <?php
        $eventRow = !empty($event) ? (is_array($event) ? reset($event) : $event) : null;
        $eventTitle = ($eventRow && !empty($eventRow->eventtitle)) ? $eventRow->eventtitle : 'Event Details';

        // Get the Event menu image
        $this->db->where_in('menuname', array('Event', 'Events'));
        $menu = $this->db->get('menu')->row();
        $bgImage = (isset($menu) && !empty($menu->menuimage)) 
            ? base_url() . 'images/website/menu/' . $menu->menuimage 
            : base_url() . 'themes/bodare/website/assets/img/default-bg.jpg';
    ?>
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(to right, rgb(2, 36, 91) 0%, rgba(2, 36, 91, 0) 100%), url(<?php echo $bgImage; ?>) center center no-repeat">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight"><?php echo htmlspecialchars($eventTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home/event">Events</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($eventTitle, ENT_QUOTES, 'UTF-8'); ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Event Details Start -->
    <div class="container-xxl py-5 event-view-page">
        <div class="container">
            <style>
                .event-view-page .event-banner img {
                    width: 100%;
                    max-height: 480px;
                    object-fit: cover;
                    display: block;
                }

                .event-view-page .event-meta span {
                    display: inline-block;
                    margin-right: 24px;
                    color: #666;
                }

                .event-view-page .event-meta i {
                    color: var(--primary);
                    margin-right: 6px;
                }

                .event-view-page .event-description {
                    line-height: 1.8;
                }
            </style>

            <?php foreach ($event as $event) { ?>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="event-banner mb-4 wow fadeInUp" data-wow-delay="0.1s">
                            <img class="img-fluid" src="<?php echo base_url(); ?>images/event/feature/<?php echo $event->eventimage; ?>" alt="<?php echo htmlspecialchars($event->eventtitle, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <h1 class="display-6 mb-3"><?php echo $event->eventtitle; ?></h1>
                            <div class="event-meta mb-4">
                                <span><i class="fa fa-calendar"></i> Time - <?php echo $event->eventtime; ?>, <?php echo $event->eventdate; ?></span>
                                <span><i class="fa fa-map-marker-alt"></i> Location - <?php echo $event->eventlocation; ?></span>
                            </div>
                            <div class="event-description mb-5">
                                <?php echo $event->eventdescription; ?>
                            </div>
                        </div>
                        <div class="wow fadeInUp" data-wow-delay="0.5s">
                            <h4 class="mb-3"><i class="fa fa-map-marked-alt text-primary"></i> Event Location</h4>
                            <?php echo coop_map_embed($event->eventlocation, $event->eventtitle, 380); ?>
                        </div>
                        <div class="mt-5 text-center wow fadeInUp" data-wow-delay="0.5s">
                            <a href="<?php echo base_url(); ?>home/event" class="btn btn-primary py-3 px-5"><i class="fa fa-arrow-left me-2"></i>Back to All Events</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Event Details End -->
