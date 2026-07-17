<?php
$logo = !empty($siteinfo[0]->logo) ? $siteinfo[0]->logo : '';
$title = !empty($siteinfo[0]->title) ? $siteinfo[0]->title : 'Admin';
$tag = !empty($siteinfo[0]->tag) ? $siteinfo[0]->tag : '';
?>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="<?php echo base_url(); ?>" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="<?php echo base_url(); ?>images/website/<?php echo htmlspecialchars($logo); ?>" alt="<?php echo htmlspecialchars($title); ?>">
                                        <img class="logo-dark logo-img logo-img-lg" src="<?php echo base_url(); ?>images/website/<?php echo htmlspecialchars($logo); ?>" alt="<?php echo htmlspecialchars($title); ?>">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Sign-In</h5>
                                        <div class="nk-block-des">
                                            <p>Access the <?php echo htmlspecialchars($title); ?> panel using your email and password.</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($this->session->flashdata('login_error')) { ?>
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong><?php echo $this->session->flashdata('login_error'); ?></strong>
                                    </div>
                                <?php } ?>

                                <?php if ($this->session->flashdata('logout_msg')) { ?>
                                    <div class="alert alert-success alert-icon">
                                        <em class="icon ni ni-check-circle"></em>
                                        <strong><?php echo $this->session->flashdata('logout_msg'); ?></strong>
                                    </div>
                                <?php } ?>

                                <?php if ($this->session->userdata('register_error')) { ?>
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong><?php echo $this->session->userdata('register_error'); ?></strong>
                                    </div>
                                    <?php $this->session->unset_userdata('register_error'); ?>
                                <?php } ?>

                                <form method="post" action="<?php echo base_url(); ?>access/login/checking">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email address</label>
                                            <a class="link link-primary link-sm" tabindex="-1" href="<?php echo base_url(); ?>">Need Help?</a>
                                        </div>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            <a class="link link-primary link-sm" tabindex="-1" href="<?php echo base_url(); ?>access/register">Create account</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form>

                                <div class="form-note-s2 pt-4">
                                    New on our platform? <a href="<?php echo base_url(); ?>access/register">Create an account</a>
                                </div>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>access/login/media/Facebook">Facebook</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>access/login/media/Google">Google</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>access/login/media/Twitter">Twitter</a></li>
                                </ul>
                            </div>
