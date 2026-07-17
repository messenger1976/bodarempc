<?php
$title = !empty($siteinfo[0]->title) ? $siteinfo[0]->title : 'Cooperative';
$tag = !empty($siteinfo[0]->tag) ? $siteinfo[0]->tag : '';
$year = date('Y');
$auth_slides = !empty($slider) ? $slider : array();
?>
                            <div class="nk-block nk-auth-footer">
                                <div class="nk-block-between">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url(); ?>access/login">Login</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo base_url(); ?>access/register">Register</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-3">
                                    <p>&copy; <?php echo $year; ?> <?php echo htmlspecialchars($title); ?><?php echo $tag ? ' — ' . htmlspecialchars($tag) : ''; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="nk-split-content nk-split-stretch nk-auth-promo-panel d-flex toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                    <?php if (!empty($auth_slides)) { ?>
                                        <?php foreach ($auth_slides as $slide) {
                                            $slide_title = !empty($slide->subtitle) ? html_entity_decode(strip_tags($slide->subtitle), ENT_QUOTES, 'UTF-8') : $title;
                                            $slide_text = !empty($slide->content) ? html_entity_decode(strip_tags($slide->content), ENT_QUOTES, 'UTF-8') : ($tag ? $tag : 'Welcome to our cooperative community.');
                                            $slide_img = base_url() . 'images/website/slider/' . $slide->filename;
                                            ?>
                                            <div class="slider-item">
                                                <div class="nk-feature nk-feature-center">
                                                    <div class="nk-feature-img">
                                                        <img class="round" src="<?php echo $slide_img; ?>" alt="<?php echo htmlspecialchars($slide_title); ?>">
                                                    </div>
                                                    <div class="nk-feature-content py-4 p-sm-5">
                                                        <h4><?php echo htmlspecialchars($slide_title); ?></h4>
                                                        <p><?php echo htmlspecialchars($slide_text); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="slider-item">
                                            <div class="nk-feature nk-feature-center">
                                                <div class="nk-feature-img">
                                                    <img class="round" src="<?php echo base_url(); ?>assets/dashlite/images/slides/promo-a.png" alt="">
                                                </div>
                                                <div class="nk-feature-content py-4 p-sm-5">
                                                    <h4><?php echo htmlspecialchars($title); ?></h4>
                                                    <p>Manage members, finances, and cooperative operations from one modern admin panel.</p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="slider-dots"></div>
                                <div class="slider-arrows"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/dashlite/js/bundle.js?v=<?php echo time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assets/dashlite/js/scripts.js?v=<?php echo time(); ?>"></script>
</body>
</html>
