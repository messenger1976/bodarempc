<?php
$logo = !empty($siteinfo[0]->logo) ? $siteinfo[0]->logo : '';
$title = !empty($siteinfo[0]->title) ? $siteinfo[0]->title : 'Admin';
$token = !empty($token) ? $token : '';
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
                                        <h5 class="nk-block-title">Create New Password</h5>
                                        <div class="nk-block-des">
                                            <p>Choose a new password for your <?php echo htmlspecialchars($title); ?> account.</p>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($this->session->flashdata('reset_error')) { ?>
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong><?php echo $this->session->flashdata('reset_error'); ?></strong>
                                    </div>
                                <?php } ?>

                                <form method="post" action="<?php echo base_url('access/forgot/update'); ?>">
                                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">New Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password"
                                                   placeholder="Enter new password" minlength="6" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="confirm_password">Confirm Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="confirm_password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password"
                                                   placeholder="Confirm new password" minlength="6" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Update Password</button>
                                    </div>
                                </form>

                                <div class="form-note-s2 pt-4">
                                    <a href="<?php echo base_url('access/login'); ?>">Back to login</a>
                                </div>
                            </div>
