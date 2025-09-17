
<?php
if ($this->uri->uri_string() == '') {
    $home = true;
} else {
    $home = false;
}
?>

<?php 

    $query = $this->db->get('websitebasic');
    foreach ($query->result() as $basic): 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $basic->title;?> | <?php echo $basic->tag;?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>images/website/<?php echo $basic->favicon;?>"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo base_url(); ?>themes/bodare/website/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>themes/bodare/website/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo base_url(); ?>themes/bodare/website/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo base_url(); ?>themes/bodare/website/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row g-0 d-none d-lg-flex">
            <div class="col-lg-6 ps-5 text-start">
                <div class="h-100 d-inline-flex align-items-center text-white">
                    <span>Follow Us:</span>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-6 text-end">
                <div class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 px-5">
                    <span class="fs-5 fw-bold me-2"><i class="fa fa-phone-alt me-2"></i>Call Us:</span>
                    <span class="fs-5 fw-bold">0915-192-9565</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-0 pe-5">
        <a href="/" class="navbar-brand ps-5 me-0">
            <?php //foreach ($basicinfo as $basic)  ?>
            <img src="<?php echo base_url();?>images/website/<?php echo $basic->logo;?>" alt="<?php echo $basic->title;?>" style="width: 70px;"></img>
            <h1 class="text-white m-0"><?php echo $basic->title; ?></h1>
        </a>
        <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">

                <?php 
                            
                            $this->db->where('menuparentid', " ");
                            $this->db->where('active', "1");
                            $this->db->order_by('serialid', "asc");
                            $parentmenu = $query = $this->db->get('menu');
                            $parentmenu->result();
        
                            foreach ($parentmenu->result() as $row) { ?>
                                <a class="nav-item nav-link" href="
                                <?php 
                                    if($row->menupageid)
                                    {
                                        echo base_url('home/page'). "/". $row->menupageid;}
                                    else{
                                        echo $row->menulink;
                                    } ?>"><?php echo $row->menuname;?></a>
                                    <?php 
                                    
                                        $this->db->where('serialid', $row->menuid);
                                        $this->db->order_by('subserialid', "asc");
                                        $cmquery = $this->db->get('menu');
                                        
                                        if($cmquery->num_rows() > 0){ ?>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($cmquery->result() as $cm) { ?>
                                                <li><a href="<?php echo $cm->menulink;?>"><?php echo $cm->menuname;?></a></li>
                                            <?php }?>
                                        </ul>
                                    <?php } ?>
                                   
                            <?php } ?>  


                <!--<a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Services</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="project.html" class="dropdown-item">Projects</a>
                        <a href="feature.html" class="dropdown-item">Features</a>
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>-->
            </div>
            <a href="<?php echo base_url();?>access/login" class="btn btn-primary px-3 d-none d-lg-block">Login</a>
        </div>
    </nav>
    <!-- Navbar End -->


<?php endforeach;?>