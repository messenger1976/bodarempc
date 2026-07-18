<?php foreach ($individual as $row): ?>
    <div class="content view_event">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">				
                    <div class="card card-product">
                        <div class="card-image">						
                            <img class="img" style="height:350px;" src="<?php echo base_url(); ?>images/event/feature/<?php
                            if ($row->eventimage) {
                                echo $row->eventimage;
                            } else {
                                echo "banner.jpg";
                            }
                            ?> ">						
                        </div>
                        <div class="card-content">						
                            <h4 class="card-title">
                                <a href="#"><?php echo $row->eventtitle; ?></a>
                            </h4>
                            <div class="card-description">
                                <?php echo $row->eventdescription; ?>
                            </div>
                        </div>
                        <div class="card-content event-element">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">date_range</i> Date - <?php echo $row->eventdate; ?></p>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">access_time</i> Time - <?php echo $row->eventtime; ?></p>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">place</i> Location - <?php echo $row->eventlocation; ?></p>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">public</i> Status - <?php echo $row->status === 'published' ? 'Published' : 'Draft'; ?></p>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">visibility</i> Publish Start - <?php echo date('M j, Y g:i A', strtotime($row->publish_start_at)); ?></p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <p><i class="material-icons">visibility_off</i> Publish End - <?php echo $row->publish_end_at ? date('M j, Y g:i A', strtotime($row->publish_end_at)) : 'No ending date'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>