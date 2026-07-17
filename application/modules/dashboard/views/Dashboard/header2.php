<?php
$cmodule = $this->uri->segment(1); //Church Module
$ccontroller = $this->uri->segment(2); //Church Controller
$cmethod = $this->uri->segment(3); //Church Method

if (!$ccontroller && $cmodule == "dashboard") {
    $itdash = "dashboard";
} else {
    $itdash = "notdashboard";
}

$raw_user_position = $this->session->userdata('user_position');
$user_position = $raw_user_position;
if ($user_position == "Super Admin") {
    $user_position = "Admin";
}
$role_display = $raw_user_position ? $raw_user_position : "Viewer";
$role_permissions_map = array(
    "Super Admin" => "Full access: users, roles, backups, website, reports",
    "Admin" => "Admin access: users, backups, website, reports",
    "Manager" => "Operations access: finance, members, events, reports",
    "Staff" => "Execution access: members, events, notices, reports",
    "Viewer" => "Read-only access: reports and dashboard overview",
);
$role_summary = isset($role_permissions_map[$role_display]) ? $role_permissions_map[$role_display] : $role_permissions_map["Viewer"];
$role_class_map = array(
    "Super Admin" => "role-level-super-admin",
    "Admin" => "role-level-admin",
    "Manager" => "role-level-manager",
    "Staff" => "role-level-staff",
    "Viewer" => "role-level-viewer",
);
$role_class = isset($role_class_map[$role_display]) ? $role_class_map[$role_display] : "role-level-viewer";
$siteinfo = $this->db->get('websitebasic');
$siteinfo = $siteinfo->result();
?>


<!doctype html>
<html lang="en" class="js">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title><?php echo $siteinfo[0]->title; ?> | <?php echo $siteinfo[0]->tag; ?></title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.png" />
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>images/favicon.png" />

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/dashlite.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/theme.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom_style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/dashlite-coop-bridge.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/nice-select.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-colorpicker.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/3.1.3/cropper.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="<?php echo base_url(); ?>trumbowyg/dist/ui/trumbowyg.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>datatables/css/buttons.bootstrap4.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>fullcalendar/fullcalendar.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>fullcalendar/fullcalendar.print.min.css" rel="stylesheet" media="print">

        <script>
            (function () {
                try {
                    var theme = localStorage.getItem('coop_admin_theme') || 'dark';
                    document.documentElement.setAttribute('data-theme', theme === 'light' ? 'light' : 'dark');
                } catch (e) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            })();
        </script>

        <script src="<?php echo base_url(); ?>fullcalendar/lib/moment.min.js"></script>		
        <script src="<?php echo base_url(); ?>fullcalendar/fullcalendar.min.js"></script>

        <style>
            <?php $themeColor = !empty($siteinfo[0]->color) ? $siteinfo[0]->color : '#36661f'; ?>
            :root, .coop-dashlite {
                --coop-theme: <?php echo $themeColor; ?>;
            }
            .coop-dashlite .card .card-header[data-background-color],
            .coop-dashlite .card .card-header[data-background-color="purple"] {
                background: <?php echo $themeColor; ?> !important;
                background-image: none !important;
            }
            .coop-dashlite .btn-primary {
                color: #fff !important;
                background-color: <?php echo $themeColor; ?> !important;
                border-color: <?php echo $themeColor; ?> !important;
            }
            .coop-dashlite .btn-primary:hover,
            .coop-dashlite .btn-primary:focus,
            .coop-dashlite .btn-primary:active {
                color: #fff !important;
                background-color: color-mix(in srgb, <?php echo $themeColor; ?> 85%, #000) !important;
                border-color: color-mix(in srgb, <?php echo $themeColor; ?> 85%, #000) !important;
            }
            .coop-dashlite .btn-outline-primary {
                color: <?php echo $themeColor; ?> !important;
                border-color: <?php echo $themeColor; ?> !important;
                background-color: transparent !important;
            }
            .coop-dashlite .btn-outline-primary:hover,
            .coop-dashlite .btn-outline-primary:focus {
                color: #fff !important;
                background-color: <?php echo $themeColor; ?> !important;
                border-color: <?php echo $themeColor; ?> !important;
            }
            .coop-dashlite .image_select_text, .coop-dashlite .file_import_btn { background: <?php echo $themeColor; ?> !important; }
            .coop-dashlite .pagination > .active > a,
            .coop-dashlite .pagination > .active > span { background-color: <?php echo $themeColor; ?> !important; border-color: <?php echo $themeColor; ?> !important; }
            .coop-dashlite .coop-sidebar-nav .nav > li.active > a,
            .coop-dashlite.theme-light .coop-sidebar-nav .nav > li.active > a {
                background: <?php echo $themeColor; ?> !important;
            }
            .coop-dashlite .coop-sidebar-nav .nav li ul.nav_child li.active > a,
            .coop-dashlite .coop-sidebar-nav .nav li ul.nav_child li > a:hover,
            .coop-dashlite.theme-light .coop-sidebar-nav .nav li ul.nav_child li.active > a,
            .coop-dashlite.theme-light .coop-sidebar-nav .nav li ul.nav_child li > a:hover {
                background: transparent !important;
                color: <?php echo $themeColor; ?> !important;
            }
            .coop-dashlite.theme-light .coop-sidebar-nav .nav > li > a:hover {
                background: color-mix(in srgb, <?php echo $themeColor; ?> 12%, transparent) !important;
                color: <?php echo $themeColor; ?> !important;
            }
            .coop-dashlite .gIconColor { background: <?php echo $themeColor; ?> !important; }
            .coop-dashlite a { color: inherit; }
            .coop-dashlite .text-primary,
            .coop-dashlite a.link-primary { color: <?php echo $themeColor; ?> !important; }
        </style>
    </head>

    <body class="nk-body bg-lighter npc-general has-sidebar coop-dashlite theme-dark" theme="dark">
        <script>
            (function () {
                var theme = 'dark';
                try { theme = localStorage.getItem('coop_admin_theme') || 'dark'; } catch (e) {}
                document.body.classList.remove('theme-dark', 'theme-light', 'dark-mode');
                if (theme === 'light') {
                    document.body.classList.add('theme-light');
                    document.body.setAttribute('theme', 'light');
                } else {
                    document.body.classList.add('theme-dark', 'dark-mode');
                    document.body.setAttribute('theme', 'dark');
                }
            })();
        </script>

            <div class="loading" id="loading" style="display:none;">
                <img src="<?php echo base_url(); ?>images/loading.svg" alt="Loading">
            </div>
            <div class="warning_notifi notifi" id="warning_notifi" style="display:none;">
            <p><em class="icon ni ni-alert-circle"></em> Oops! Something Wrong</p>
            </div>
            <div class="success_notifi notifi" id="success_notifi" style="display:none;">
            <p><em class="icon ni ni-check-circle"></em> Successfully Updated</p>
            </div>

            <?php
            $success = $this->session->flashdata('success');
            $notsuccess = $this->session->flashdata('notsuccess');
        if ($success) { ?>
            <div class="success_notifi notifi" style="display:block;">
                <p><em class="icon ni ni-check-circle"></em> <?php echo $success; ?></p>
                </div>
            <?php } elseif ($notsuccess) { ?>
            <div class="warning_notifi notifi" style="display:block;">
                <p><em class="icon ni ni-alert-circle"></em> <?php echo $notsuccess; ?></p>
                </div>
            <?php } ?>

        <div class="nk-app-root">
            <div class="nk-main">
                <div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
                    <div class="nk-sidebar-element nk-sidebar-head">
                        <div class="nk-sidebar-brand">
                            <a href="<?php echo base_url('dashboard'); ?>" class="logo-link nk-sidebar-logo">
                                <img src="<?php echo base_url(); ?>images/website/<?php echo $siteinfo[0]->logo; ?>" alt="Logo" style="max-height:42px;border-radius:6px;">
                            </a>
                        </div>
                        <div class="nk-menu-trigger me-n2">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        </div>
                    </div>
                    <div class="nk-sidebar-element nk-sidebar-body">
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-menu" data-simplebar>
                                <div class="coop-sidebar-nav">
            <div class="sidebar" data-color="purple">
                                        <?php include APPPATH.'modules/dashboard/views/Dashboard/sidebar_nav.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nk-wrap">
                    <div class="nk-header nk-header-fixed is-light">
                        <div class="container-fluid">
                            <div class="nk-header-wrap">
                                <div class="nk-menu-trigger d-xl-none ms-n1">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                                </div>
                                <div class="nk-header-brand d-xl-none">
                                    <a href="<?php echo base_url('dashboard'); ?>" class="logo-link">
                                        <span class="fw-bold"><?php echo $siteinfo[0]->title; ?></span>
                                    </a>
                                </div>
                                <div class="nk-header-tools">
                                    <ul class="nk-quick-nav">
                                        <li class="header-role-chip d-none d-md-block" title="<?php echo $role_summary; ?>">
                                            <div class="role-chip-wrap">
                                                <span class="role-chip-title">Role</span>
                                                <span class="role-chip-badge <?php echo $role_class; ?>"><?php echo $role_display; ?></span>
                                                <span class="role-chip-summary d-none d-lg-block"><?php echo $role_summary; ?></span>
                                            </div>
                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>" target="_blank" class="btn btn-sm btn-outline-light">
                                                <em class="icon ni ni-external"></em>
                                                <span><?php echo $this->lang->line('dash_view_front'); ?></span>
                                        </a>
                                    </li>
                                        <li class="dropdown user-dropdown">
                                            <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                                                <div class="user-toggle">
                                                    <div class="user-avatar sm"><em class="icon ni ni-user-alt"></em></div>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                    <div class="user-card">
                                                        <div class="user-avatar"><em class="icon ni ni-user-alt"></em></div>
                                                        <div class="user-info"><span class="lead-text"><?php echo $role_display; ?></span><span class="sub-text"><?php echo $role_summary; ?></span></div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-inner">
                                                    <ul class="link-list">
                                                        <li><a href="<?php echo base_url(); ?>dashboard/setting/profile"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                        <li><a href="<?php echo base_url(); ?>dashboard/setting/editprofile"><em class="icon ni ni-edit-alt"></em><span>Update Profile</span></a></li>
                                                        <li class="theme-switch-item">
                                                            <a href="#" class="coop-theme-toggle" role="button">
                                                                <em class="icon ni ni-moon theme-mode-icon"></em>
                                                                <span class="theme-mode-label">Dark Mode</span>
                                                                <span class="theme-switch"><span class="theme-switch-knob"></span></span>
                                                            </a>
                                                        </li>
                                                        <li><a href="<?php echo base_url(); ?>access/logout/"><em class="icon ni ni-signout"></em><span>Logout</span></a></li>
                    </ul>
                </div>
            </div>
                                        </li>
                                        <li class="dropdown language-dropdown">
                                            <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown"><em class="icon ni ni-globe"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="<?php echo base_url(); ?>dashboard/switchLang/english"><img class="lang_img" src="<?php echo base_url(); ?>images/language/english.png" alt="english"> <?php echo $this->lang->line('dash_lenglish'); ?></a></li>
                                                    <li><a href="<?php echo base_url(); ?>dashboard/switchLang/bengali"><img class="lang_img" src="<?php echo base_url(); ?>images/language/bengali.png" alt="bengali"> <?php echo $this->lang->line('dash_lbengali'); ?></a></li>
                                                    <li><a href="<?php echo base_url(); ?>dashboard/switchLang/hindi"><img class="lang_img" src="<?php echo base_url(); ?>images/language/hindi.png" alt="hindi"> <?php echo $this->lang->line('dash_lhindi'); ?></a></li>
                                                    <li><a href="<?php echo base_url(); ?>dashboard/switchLang/spanish"><img class="lang_img" src="<?php echo base_url(); ?>images/language/spanish.png" alt="spanish"> <?php echo $this->lang->line('dash_lspanish'); ?></a></li>
                                                    <li><a href="<?php echo base_url(); ?>dashboard/switchLang/portuguese"><img class="lang_img" src="<?php echo base_url(); ?>images/language/portuguese.png" alt="portuguese"> <?php echo $this->lang->line('dash_lportuguese'); ?></a></li>
                                                </ul>
                                    </div>
                                </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="nk-content nk-content-fluid">
                        <div class="container-xl wide-xl">
        