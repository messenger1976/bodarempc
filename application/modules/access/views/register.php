<?php
$logo = !empty($siteinfo[0]->logo) ? $siteinfo[0]->logo : '';
$title = !empty($siteinfo[0]->title) ? $siteinfo[0]->title : 'Admin';
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
                                        <h5 class="nk-block-title">Register</h5>
                                        <div class="nk-block-des">
                                            <p>Create a new <?php echo htmlspecialchars($title); ?> account.</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($this->session->flashdata('register_error')) { ?>
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong><?php echo $this->session->flashdata('register_error'); ?></strong>
                                    </div>
                                <?php } ?>

                                <form method="post" action="<?php echo base_url(); ?>access/register/addnewuser">
                                    <div class="form-group">
                                        <label class="form-label" for="username">User Name</label>
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Enter your name" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email address</label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-control-xs custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="terms_agree" checked>
                                            <label class="custom-control-label" for="terms_agree">I agree to the <a tabindex="-1" href="#">Privacy Policy</a> &amp; <a tabindex="-1" href="#">Terms</a>.</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
                                    </div>
                                </form>

                                <div class="form-note-s2 pt-4">
                                    Already have an account? <a href="<?php echo base_url(); ?>access/login"><strong>Sign in instead</strong></a>
                                </div>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>access/register/media/Facebook">Facebook</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>access/register/media/Google">Google</a></li>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>access/register/media/Twitter">Twitter</a></li>
                                </ul>
                            </div>
