<?php
/**
 * DashLite-style list page header (project-list nk-block-head).
 *
 * Expected vars:
 *   $page_title (string) required
 *   $page_subtitle (string) optional
 *   $page_total (int|string) optional — builds "You have total X."
 *   $page_add_url (string) optional
 *   $page_add_label (string) optional — default "Add"
 *   $page_add_modal (string) optional — e.g. "#addSliderModal"
 */
if (!isset($page_title)) {
    return;
}
$subtitle = '';
if (!empty($page_subtitle)) {
    $subtitle = $page_subtitle;
} elseif (isset($page_total) && $page_total !== '' && $page_total !== null) {
    $subtitle = 'You have total ' . $page_total . '.';
}
$add_label = !empty($page_add_label) ? $page_add_label : 'Add';
?>
<div class="nk-block-head nk-block-head-sm coop-table-block-head">
    <div class="nk-block-between g-3">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title"><?php echo html_escape($page_title); ?></h3>
            <?php if ($subtitle) { ?>
                <div class="nk-block-des text-soft">
                    <p><?php echo html_escape($subtitle); ?></p>
                </div>
            <?php } ?>
        </div>
        <?php if (!empty($page_add_url) || !empty($page_add_modal)) { ?>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li class="nk-block-tools-opt">
                                <?php if (!empty($page_add_modal)) { ?>
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-bs-toggle="modal" data-target="<?php echo html_escape($page_add_modal); ?>" data-bs-target="<?php echo html_escape($page_add_modal); ?>">
                                        <em class="icon ni ni-plus"></em><span><?php echo html_escape($add_label); ?></span>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo $page_add_url; ?>" class="btn btn-primary">
                                        <em class="icon ni ni-plus"></em><span><?php echo html_escape($add_label); ?></span>
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
