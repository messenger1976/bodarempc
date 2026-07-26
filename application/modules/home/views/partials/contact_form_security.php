<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$fs = (isset($form_security) && is_array($form_security)) ? $form_security : array();
$csrfToken = !empty($fs['csrf_token']) ? $fs['csrf_token'] : '';
$honeypotField = !empty($fs['honeypot_field']) ? $fs['honeypot_field'] : 'company_url';
$honeypotId = !empty($honeypot_id) ? $honeypot_id : $honeypotField;
?>
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="recaptcha_token" value="" class="contact-recaptcha-token">
<!-- Honeypot: leave empty. Hidden from humans, filled by many bots. -->
<div class="hp-field" aria-hidden="true" style="position:absolute!important;left:-10000px!important;top:auto!important;width:1px!important;height:1px!important;overflow:hidden!important;opacity:0!important;pointer-events:none!important;">
	<label for="<?php echo htmlspecialchars($honeypotId, ENT_QUOTES, 'UTF-8'); ?>">Company Website</label>
	<input type="text" id="<?php echo htmlspecialchars($honeypotId, ENT_QUOTES, 'UTF-8'); ?>" name="<?php echo htmlspecialchars($honeypotField, ENT_QUOTES, 'UTF-8'); ?>" value="" tabindex="-1" autocomplete="off">
</div>
