<?php
$cmodule = $this->uri->segment(1);
$ccontroller = $this->uri->segment(2);
$themeColor = !empty($siteinfo[0]->color) ? $siteinfo[0]->color : '#36661f';
$logo = !empty($siteinfo[0]->logo) ? $siteinfo[0]->logo : '';
$favicon = !empty($siteinfo[0]->favicon) ? $siteinfo[0]->favicon : $logo;
$title = !empty($siteinfo[0]->title) ? $siteinfo[0]->title : 'Login';
$tag = !empty($siteinfo[0]->tag) ? $siteinfo[0]->tag : '';
?>
<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($title); ?><?php echo $tag ? ' | ' . htmlspecialchars($tag) : ''; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/website/<?php echo htmlspecialchars($favicon); ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/dashlite.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/theme.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --coop-theme: <?php echo htmlspecialchars($themeColor); ?>;
        }
        .pg-auth .btn-primary {
            color: #fff !important;
            background-color: var(--coop-theme) !important;
            border-color: var(--coop-theme) !important;
        }
        .pg-auth .btn-primary:hover,
        .pg-auth .btn-primary:focus,
        .pg-auth .btn-primary:active {
            color: #fff !important;
            background-color: color-mix(in srgb, var(--coop-theme) 85%, #000) !important;
            border-color: color-mix(in srgb, var(--coop-theme) 85%, #000) !important;
        }
        .pg-auth a.link-primary,
        .pg-auth .link-primary,
        .pg-auth .form-note-s2 a,
        .pg-auth .nav-link:hover {
            color: var(--coop-theme) !important;
        }
        .pg-auth .form-control:focus {
            border-color: var(--coop-theme) !important;
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--coop-theme) 18%, transparent) !important;
        }
        .pg-auth .brand-logo .logo-img {
            max-height: 52px;
            width: auto;
        }
        .pg-auth .nk-auth-promo-panel {
            background:
                radial-gradient(circle at 20% 20%, color-mix(in srgb, var(--coop-theme) 18%, transparent), transparent 45%),
                radial-gradient(circle at 80% 80%, color-mix(in srgb, var(--coop-theme) 12%, transparent), transparent 40%),
                #f5f6fa;
        }
        .pg-auth .nk-feature-content h4 {
            color: var(--coop-theme);
        }
        .pg-auth .nk-feature-img {
            max-width: 420px;
            margin: 0 auto;
        }
        .pg-auth .nk-feature-img img.round {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
        }
    </style>
</head>
<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <div class="nk-main">
            <div class="nk-wrap nk-wrap-nosidebar">
                <div class="nk-content">
                    <div class="nk-split nk-split-page nk-split-md">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                            </div>
