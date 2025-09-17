
<?php foreach ($page as $row) : ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight"><?php echo $row->pagetitle; ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home/page/<?php echo $row->pageslug; ?>"><?php echo $row->pagetitle; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $row->pagetitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


<?php echo $row->pagecontent; ?>
 
    
<?php endforeach; ?>