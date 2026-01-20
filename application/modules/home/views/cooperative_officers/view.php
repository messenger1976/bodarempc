
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
            <h1 class="display-3 text-white animated slideInRight">Cooperative Officer Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home/cooperative_officers">Cooperative Officers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Officer Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container">
            <h2>Cooperative Officer</h2>

            <?php foreach ($cooperative_officers as $cooperative_officers) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="person-view">
                        <div class="row">
                            <img src="<?php echo base_url(); ?>images/<?php if($cooperative_officers->profileimage){ echo "cooperative_officers/profile/" . $cooperative_officers->profileimage; }else{ echo "avatar.png"; } ?>" alt="Cooperative Officer - <?php echo $cooperative_officers->fname . " " . $cooperative_officers->lname; ?>" style="width: 250px; height: 250px; border-radius: 50%; object-fit: cover; margin: 0 auto; display: block;"></img>
                            <h5><?php echo $cooperative_officers->position; ?></h5>
                            <h4><a   href="<?php echo base_url(); ?>home/cooperative_officers/view/<?php echo $cooperative_officers->cooperative_officersid; ?>"><?php echo $cooperative_officers->fname . " " . $cooperative_officers->lname; ?></a></h4>
                            <h6 style="color: #666; margin-bottom: 15px;"><?php echo $cooperative_officers->department ? $cooperative_officers->department : 'N/A'; ?></h6>
                            <p><?php echo strip_tags($cooperative_officers->speech); ?></p>
                        </div>
                        
                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="social_media">
                                    <?php if(!empty($cooperative_officers->facebook)): ?><a class="socialbtn facebook" target="_blank" href="<?php echo $cooperative_officers->facebook; ?>"><i class="fa fa-facebook"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->twitter)): ?><a class="socialbtn twitter" target="_blank" href="<?php echo $cooperative_officers->twitter; ?>"><i class="fa fa-twitter"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->linkedin)): ?><a class="socialbtn linkedin" target="_blank" href="<?php echo $cooperative_officers->linkedin; ?>"><i class="fa fa-linkedin"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->googleplus)): ?><a class="socialbtn googleplus" target="_blank" href="<?php echo $cooperative_officers->googleplus; ?>"><i class="fa fa-google"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->youtube)): ?><a class="socialbtn youtube" target="_blank" href="<?php echo $cooperative_officers->youtube; ?>"><i class="fa fa-youtube"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->pinterest)): ?><a class="socialbtn pinterest" target="_blank" href="<?php echo $cooperative_officers->pinterest; ?>"><i class="fa fa-pinterest"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->instagram)): ?><a class="socialbtn instagram" target="_blank" href="<?php echo $cooperative_officers->instagram; ?>"><i class="fa fa-instagram"></i></a><?php endif; ?>
                                    <?php if(!empty($cooperative_officers->whatsapp)): ?><a class="socialbtn whatsapp" target="_blank" href="tel:<?php echo $cooperative_officers->whatsapp; ?>"><i class="fa fa-whatsapp"></i></a><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="separator-container">
                            <div class="extra_space_sm"></div>
                        </div>

                        <div class="row">    
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td><i class="fa fa-phone"></i></td>
                                            <td>Phone</td>
                                            <td><?php echo $cooperative_officers->phone; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-envelope"></i></td>
                                            <td>Email</td>
                                            <td><?php echo $cooperative_officers->email; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-calendar"></i></td>                                
                                            <td>DOB</td>
                                            <td><?php echo $cooperative_officers->dob; ?></td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Baptized</td>
                                            <td><?php echo $cooperative_officers->bpdate; ?></td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td><i class="fa fa-calendar"></i></td>
                                            <td>Marriage Date</td>
                                            <td><?php echo $cooperative_officers->marriagedate; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td><i class="fa fa-book"></i></td>
                                            <td>Social Status</td>
                                            <td><?php echo $cooperative_officers->socialstatus; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-briefcase"></i></td>
                                            <td>Employment/Job</td>
                                            <td><?php echo $cooperative_officers->job; ?></td>
                                        </tr>
                                        
                                        <tr style="display: none;">
                                        <tr>
                                            <td><i class="fa fa-th"></i></td>
                                            <td>Department</td>
                                            <td><?php echo $cooperative_officers->department; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Nationality</td>
                                            <td><?php echo $cooperative_officers->nationality; ?></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-map-marker"></i></td>
                                            <td>Location</td>
                                            <td><?php echo $cooperative_officers->city . ", " . $cooperative_officers->country; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> 

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <iframe
                                    width="100%"
                                    height="280"
                                    frameborder="0" style="border:0; pointer-events: none;"
                                    src="https://www.google.com/maps/embed/v1/place?key=<?php echo getBasic()->mapapi;?>
                                    &q=<?php echo $cooperative_officers->city . ", " . $cooperative_officers->country; ?>">
                                </iframe>
                            </div> 
                        </div>
                    </div>

                    <div class="separator-container">
                        <div class="extra_space_sm"></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                        <div class="socialShare"></div>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
</div> 
