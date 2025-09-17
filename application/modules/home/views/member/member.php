
<div class="wrapper_section">
    <!-- <div class="container"> -->
    <div class="animate-in cs_sections" data-anim-type="bounce-in-up-large"  data-anim-delay="300"  >
        <div class="container allperson">
            <p class="breadcrumb"><i class="fa fa-home"></i> <a href="<?php echo base_url();?>">Home</a> <i class="fa fa-angle-right"></i> <a href="<?php echo base_url();?>home/member">Member</a></p>
            <h2>All Member</h2>
            <div class="separator-container">
                <div class="separator line-separator">♦</div>
            </div>
            
            <?php foreach ($member as $member){ ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="pastors">
                    <img src="<?php echo base_url();?>images/member/profile/<?php echo $member->profileimage;?>" alt="Member - <?php echo $member->fname. " " . $member->lname;?>"></img>
                    <h5><?php echo $member->position;?></h5>
                    <h4><a   href="<?php echo base_url();?>home/member/view/<?php echo $member->memberid;?>"><?php echo $member->fname. " " . $member->lname;?></a></h4>
                </div>
            </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  echo $pagination; ?>
            </div>  
        </div>
    </div>
</div> 




