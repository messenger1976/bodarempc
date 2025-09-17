<div class="content website">
    <div class="container-fluid">
        <div class="row">	                    
            <div class="col-md-offset-1 col-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_websitebasic_panel_title'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <?php foreach ($website as $web): ?>
                            <form id="webBasicForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/website/updatebasic" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-4">
                                        <img class="favicon" src="<?php echo base_url(); ?>images/website/<?php echo $web->favicon; ?>" alt="Favicon">
                                        <div class="form-group label-floating">
                                            <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_sfavicon'); ?></p>													
                                            <input type="file" id="favicon" name="favicon"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-offset-1 col-md-4">
                                        <img class="logo" src="<?php echo base_url(); ?>images/website/<?php echo $web->logo; ?>" alt="Favicon">
                                        <div class="form-group label-floating">
                                            <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_slogo'); ?></p>
                                            <input type="file" id="logo" name="logo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webtitle'); ?> (*)</label>
                                            <input id="title" name="title" type="text" class="form-control" value="<?php echo $web->title; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webtag'); ?> (*)</label>
                                            <input id="tag" name="tag" type="text" class="form-control" value="<?php echo $web->tag; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">	                                        
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webmap'); ?></label>
                                            <input id="map" name="map" type="text" class="form-control" value="<?php echo $web->map; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_googlemapapi'); ?></label>
                                            <input id="map" name="mapapi" type="text" class="form-control" value="<?php echo $web->mapapi; ?>">
                                        </div>
                                    </div>                           
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_adminemail'); ?></label>
                                            <input id="email" name="email" type="text" class="form-control" value="<?php echo $web->email; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_themecolor'); ?></label>
                                            <input id="color" name="color" type="text" class="colorSelect form-control" value="<?php echo $web->color; ?>">
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webcurrency'); ?> (*)</label>
                                            <select class="select form-control" id="currency" name="currency" required>
                                                <option selected value="<?php echo $web->currency; ?>"><?php echo $web->currency; ?></option>
                                                <option value="DZD" >Algeria Dinars </option>
                                                <option value="ARP" >Argentina Pesos </option>
                                                <option value="AUD" >Australia Dollars </option>
                                                <option value="ATS" >Austria Schillings </option>
                                                <option value="BSD" >Bahamas Dollars </option>
                                                <option value="BBD" >Barbados Dollars </option>
                                                <option value="BDT" >Bangladesh Taka </option>
                                                <option value="BEF" >Belgium Francs </option>
                                                <option value="BMD" >Bermuda Dollars </option>
                                                <option value="BRR" >Brazil Real </option>
                                                <option value="BGL" >Bulgaria Lev </option>
                                                <option value="CAD" >Canada Dollars </option>
                                                <option value="CLP" >Chile Pesos </option>
                                                <option value="CNY" >China Yuan Renmimbi </option>
                                                <option value="CYP" >Cyprus Pounds </option>
                                                <option value="CSK" >Czech Republic Koruna </option>
                                                <option value="DKK" >Denmark Kroner </option>
                                                <option value="NLG" >Dutch Guilders </option>
                                                <option value="XCD" >Eastern Caribbean Dollars </option>
                                                <option value="EGP" >Egypt Pounds </option>
                                                <option value="EUR" >Euro </option>
                                                <option value="FJD" >Fiji Dollars </option>
                                                <option value="FIM" >Finland Markka </option>
                                                <option value="FRF" >France Francs </option>
                                                <option value="DEM" >Germany Deutsche Marks </option>
                                                <option value="GRD" >Greece Drachmas </option>
                                                <option value="HKD" >Hong Kong Dollars </option>
                                                <option value="HUF" >Hungary Forint </option>
                                                <option value="ISK" >Iceland Krona </option>
                                                <option value="INR" >India Rupees </option>
                                                <option value="IDR" >Indonesia Rupiah </option>
                                                <option value="IEP" >Ireland Punt </option>
                                                <option value="ILS" >Israel New Shekels </option>
                                                <option value="ITL" >Italy Lira </option>
                                                <option value="JMD" >Jamaica Dollars </option>
                                                <option value="JPY" >Japan Yen </option>
                                                <option value="JOD" >Jordan Dinar </option>
                                                <option value="KRW" >Korea (South) Won </option>
                                                <option value="LBP" >Lebanon Pounds </option>
                                                <option value="LUF" >Luxembourg Francs </option>
                                                <option value="MYR" >Malaysia Ringgit </option>
                                                <option value="MXP" >Mexico Pesos </option>
                                                <option value="NLG" >Netherlands Guilders </option>
                                                <option value="NZD" >New Zealand Dollars </option>
                                                <option value="NOK" >Norway Kroner </option>
                                                <option value="PKR" >Pakistan Rupees </option>
                                                <option value="PHP" >Philippines Pesos </option>
                                                <option value="PLZ" >Poland Zloty </option>
                                                <option value="PTE" >Portugal Escudo </option>
                                                <option value="ROL" >Romania Leu </option>
                                                <option value="RUR" >Russia Rubles </option>
                                                <option value="SAR" >Saudi Arabia Riyal </option>
                                                <option value="SGD" >Singapore Dollars </option>
                                                <option value="SKK" >Slovakia Koruna </option>
                                                <option value="ZAR" >South Africa Rand </option>
                                                <option value="KRW" >South Korea Won </option>
                                                <option value="ESP" >Spain Pesetas </option>
                                                <option value="SDD" >Sudan Dinar </option>
                                                <option value="SEK" >Sweden Krona </option>
                                                <option value="CHF" >Switzerland Francs </option>
                                                <option value="TWD" >Taiwan Dollars </option>
                                                <option value="THB" >Thailand Baht </option>
                                                <option value="TTD" >Trinidad and Tobago Dollars </option>
                                                <option value="TRL" >Turkey Lira </option>
                                                <option value="GBP" >United Kingdom Pounds </option>
                                                <option value="USD" >USD United States Dollars </option>
                                                <option value="VEB" >Venezuela Bolivar </option>
                                                <option value="ZMK" >Zambia Kwacha </option>
                                            </select>
                                        </div>
                                    </div> 
                                </div>



                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_city'); ?></label>
                                            <input id="city" name="city" type="text" class="form-control" value="<?php echo $web->city; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_country'); ?></label>
                                            <input id="country" name="country" type="text" class="form-control" value="<?php echo $web->country; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_zone'); ?></label>
                                            <input id="postal" name="postal" type="text" class="form-control" value="<?php echo $web->postal; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_facebook'); ?></label>
                                            <input type="text" id="fname" name="facebook" class="form-control" value="<?php echo $web->facebook; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_twitter'); ?></label>
                                            <input type="text" id="fname" name="twitter" class="form-control" value="<?php echo $web->twitter; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_googleplus'); ?></label>
                                            <input type="text" id="lname" name="googleplus" class="form-control" value="<?php echo $web->googleplus; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_linkedin'); ?></label>
                                            <input type="text" id="position" name="linkedin" class="form-control" value="<?php echo $web->linkedin; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_youtube'); ?></label>
                                            <input type="text" id="fname" name="youtube" class="form-control" value="<?php echo $web->youtube; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pinterest'); ?></label>
                                            <input type="text" id="fname" name="pinterest" class="form-control" value="<?php echo $web->pinterest; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_instagram'); ?></label>
                                            <input type="text" id="lname" name="instagram" class="form-control" value="<?php echo $web->instagram; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_whatsapp'); ?></label>
                                            <input type="text" id="position" name="whatsapp" class="form-control" value="<?php echo $web->whatsapp; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webchurchtime'); ?></label>													
                                            <textarea id="churchtime" name="churchtime" class="form-control" rows="4"><?php echo $web->churchtime; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webaboutus'); ?></label>													
                                            <textarea id="about" name="about" class="form-control" rows="4"><?php echo $web->about; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webcontact'); ?></label>													
                                            <textarea id="contact" name="contact" class="form-control" rows="4" ><?php echo $web->contact; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_address'); ?></label>
                                            <textarea id="address" name="address" class="form-control" rows="4" ><?php echo $web->address; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_webcopyright'); ?></label>
                                            <textarea id="copyright" name="copyright" type="text" class="form-control"><?php echo $web->copyright; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button id="webBasicSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_update_now'); ?></button>
                                <div class="clearfix"></div>
                            </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>