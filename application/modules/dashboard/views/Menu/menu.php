<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_addmenu_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">                       
                        <form id="menuAddForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/menu/add" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuname'); ?> (*)</label>
                                        <input id="menuname" name="menuname" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12">                                    
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menuparent'); ?></label>
                                        <select class="select form-control" id="menuparent" name="menuparent">
                                            <option value=""><?php echo $this->lang->line('dash_gpanel_smenuparent'); ?></option>
                                            <?php foreach ($menus as $row): ?>
                                                <option value="<?php echo $row->menuid; ?>"><?php echo $row->menuname; ?></option>
                                            <?php endforeach; ?>   
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-12">                                    
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menupage'); ?> Menu Page</label>
                                        <select class="select form-control" id="menupage" name="menupage">
                                            <option value=""><?php echo $this->lang->line('dash_gpanel_smenupage'); ?></option>
                                            <?php foreach ($pages as $row): ?>
                                                <option value="<?php echo $row->pageslug; ?>"><?php echo $row->pagetitle; ?></option>
                                            <?php endforeach; ?>                                                
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_menulink'); ?></label>
                                        <input id="menulink" name="menulink" type="text" class="form-control">
                                    </div>
                                </div>
                                <button id="menuAddSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_addmenu_panel_title'); ?></button>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card gusers">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_allmenus_panel_title'); ?> ( <?php
                            $this->db->from('menu');
                            echo $this->db->count_all_results();
                            ?> ) </h4>
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_newmenu'); ?> <?php echo getCreateDate('menuid','menu'); ?></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-hover sorted_menu_table">
                            <thead class="text-default">
                            <th style="width: 1%"><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th style="width: 5%"><?php echo $this->lang->line('dash_gpanel_menutitle'); ?></th>
                            <th style="width: 10%"><?php echo $this->lang->line('dash_gpanel_menulink'); ?></th>
                            <th style="width: 4%"><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($parentmenu as $row) {
                                    $i++;
                                    ?>                                
                                    <tr data-id="<?php echo $row->menuid; ?>" style="color: rgba(33, 33, 33, 0.70); font-weight: bold" class="parent-menu">
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo $row->menuname; ?></td>
                                        <td><?php
                                            $menulink = $row->menulink;
                                            echo character_limiter($menulink, 5);
                                            ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/menu/edit/<?php echo $row->menuid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                            <a href="<?php echo base_url(); ?>dashboard/menu/delete/<?php echo $row->menuid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>

                                    <?php
                                    $this->db->where('menuparentid', $row->menuid);
                                    $this->db->order_by('subserialid', "asc");
                                    $cmquery = $this->db->get('menu');


                                    //$cmquery = $this->db->get_where('menu', array('serialid' => $row->menuid));
                                    $j = 0;
                                    foreach ($cmquery->result() as $cm) {
                                        $j++;
                                        ?>
                                        <tr data-id="<?php echo $cm->menuid . "," . $row->menuid . "," . $j; ?>" class="child-menu">
                                            <td style="margin-left: 10px"> - <?php echo $i . "." . $j; ?></td>                                        
                                            <td><?php echo $cm->menuname; ?></td>
                                            <td><?php
                                                $menulink = $cm->menulink;
                                                echo character_limiter($menulink, 5);
                                                ?></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>dashboard/menu/edit/<?php echo $cm->menuid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/menu/delete/<?php echo $cm->menuid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <?php //echo $pagination;       ?>
            </div>


        </div>