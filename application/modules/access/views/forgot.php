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
                                        <h5 class="nk-block-title">Forgot Password</h5>
                                        <div class="nk-block-des">
                                            <p>Enter your email address and we will send you a link to reset your password.</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($this->session->flashdata('forgot_error')) { ?>
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong><?php echo $this->session->flashdata('forgot_error'); ?></strong>
                                    </div>
                                <?php } ?>

                                <?php if ($this->session->flashdata('forgot_success')) { ?>
                                    <div class="alert alert-success alert-icon">
                                        <em class="icon ni ni-check-circle"></em>
                                        <strong><?php echo $this->session->flashdata('forgot_success'); ?></strong>
                                    </div>
                                <?php } ?>

                                <form method="post" action="<?php echo base_url('access/forgot/send'); ?>">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email address</label>
                                            <a class="link link-primary link-sm" tabindex="-1" href="<?php echo base_url('access/login'); ?>">Back to login</a>
                                        </div>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                                               placeholder="Enter your email address" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Send Reset Link</button>
                                    </div>
                                </form>

                                <div class="form-note-s2 pt-4">
                                    Remembered your password? <a href="<?php echo base_url('access/login'); ?>"><strong>Sign in</strong></a>
                                </div>
                            </div>
