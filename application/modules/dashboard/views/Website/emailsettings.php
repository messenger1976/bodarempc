<?php
$settings = isset($email_settings) ? $email_settings : null;
$value = function ($field, $default = '') use ($settings) {
    return htmlspecialchars($settings && isset($settings->$field) ? $settings->$field : $default, ENT_QUOTES, 'UTF-8');
};
$password_is_set = $settings && !empty($settings->smtp_pass);
?>
<div class="content website">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><em class="icon ni ni-mail"></em> Email/SMTP Settings</h4>
                        <p class="category">Configure the mail server used for password resets and system email.</p>
                    </div>
                    <div class="card-content">
                        <form method="post" action="<?php echo base_url('dashboard/website/updateemailsettings'); ?>">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label" for="smtp_host">SMTP Host (*)</label>
                                        <input type="text" class="form-control form-control-lg" id="smtp_host" name="smtp_host"
                                               value="<?php echo $value('smtp_host'); ?>" placeholder="smtp.example.com" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="smtp_port">SMTP Port (*)</label>
                                        <input type="number" min="1" max="65535" class="form-control form-control-lg" id="smtp_port"
                                               name="smtp_port" value="<?php echo $value('smtp_port', '587'); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="smtp_user">SMTP Username (*)</label>
                                        <input type="text" class="form-control form-control-lg" id="smtp_user" name="smtp_user"
                                               value="<?php echo $value('smtp_user'); ?>" autocomplete="username" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="smtp_pass">
                                            SMTP Password <?php echo $password_is_set ? '(leave blank to keep current password)' : '(*)'; ?>
                                        </label>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="smtp_pass">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="smtp_pass" name="smtp_pass"
                                                   autocomplete="new-password" <?php echo $password_is_set ? '' : 'required'; ?>>
                                        </div>
                                        <?php if ($password_is_set) { ?>
                                            <span class="form-note">An encrypted SMTP password is currently saved.</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="smtp_crypto">Encryption</label>
                                        <select class="form-select form-control form-control-lg" id="smtp_crypto" name="smtp_crypto">
                                            <option value="tls" <?php echo $value('smtp_crypto', 'tls') === 'tls' ? 'selected' : ''; ?>>TLS (usually port 587)</option>
                                            <option value="ssl" <?php echo $value('smtp_crypto') === 'ssl' ? 'selected' : ''; ?>>SSL (usually port 465)</option>
                                            <option value="" <?php echo $settings && $value('smtp_crypto') === '' ? 'selected' : ''; ?>>None</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="smtp_timeout">Timeout (seconds)</label>
                                        <input type="number" min="1" max="120" class="form-control form-control-lg" id="smtp_timeout"
                                               name="smtp_timeout" value="<?php echo $value('smtp_timeout', '30'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="mailtype">Email Format</label>
                                        <select class="form-select form-control form-control-lg" id="mailtype" name="mailtype">
                                            <option value="html" <?php echo $value('mailtype', 'html') === 'html' ? 'selected' : ''; ?>>HTML</option>
                                            <option value="text" <?php echo $value('mailtype') === 'text' ? 'selected' : ''; ?>>Plain text</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="from_email">From Email (*)</label>
                                        <input type="email" class="form-control form-control-lg" id="from_email" name="from_email"
                                               value="<?php echo $value('from_email'); ?>" placeholder="noreply@example.com" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="from_name">From Name (*)</label>
                                        <input type="text" class="form-control form-control-lg" id="from_name" name="from_name"
                                               value="<?php echo $value('from_name'); ?>" placeholder="BODARE &amp; COMMUNITY MPC" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                           <?php echo !$settings || !empty($settings->is_active) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="is_active">Enable SMTP email sending</label>
                                </div>
                            </div>

                            <div class="alert alert-light alert-icon">
                                <em class="icon ni ni-info"></em>
                                Use your hosting SMTP details here (for SSL, usually port <strong>465</strong>).
                                Save settings first, then send a test email below.
                                If you get a <strong>535 authentication</strong> error, the mailbox password is wrong or SMTP is disabled for that account — reset it in cPanel and save it again here.
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <em class="icon ni ni-save"></em><span>Save Email Settings</span>
                                </button>
                            </div>
                        </form>

                        <hr class="preview-hr">

                        <h6 class="title">Send Test Email</h6>
                        <p class="category">Uses the currently saved SMTP settings (not unsaved form changes).</p>
                        <form method="post" action="<?php echo base_url('dashboard/website/testemail'); ?>" class="mt-3">
                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label" for="test_email">Recipient Email (*)</label>
                                        <input type="email" class="form-control form-control-lg" id="test_email" name="test_email"
                                               value="<?php echo $value('from_email'); ?>" placeholder="you@example.com" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-outline-primary btn-block" <?php echo $password_is_set ? '' : 'disabled'; ?>>
                                            <em class="icon ni ni-send"></em><span>Send Test Email</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php if (!$password_is_set) { ?>
                                <span class="form-note text-danger">Save SMTP settings with a password before sending a test.</span>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
