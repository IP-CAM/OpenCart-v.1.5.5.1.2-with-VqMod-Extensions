<?php echo $header; ?>
<link rel="stylesheet" href="view/javascript/farbtastic/farbtastic.css" type="text/css"/>
<script type="text/javascript" src="view/javascript/farbtastic/farbtastic.js"></script>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
       <hr>
		<div style="float: right;">						
			<div id="mmos-offer"></div>
			<div><a class="link" href="http://www.opencart.com/index.php?route=extension/extension&filter_username=mmosolution" target="_blank" class="text-success"><img src="//mmosolution.com/image/opencart.gif"> More Extension...</a><a  class="text-link"  href="http://mmosolution.com" target="_blank" class="text-success"><img src="//mmosolution.com/image/mmosolution_20x20.gif">More Extension...</a></div>									
		</div>
		<br/>
        <div id="mmosolution" class="htabs">
            <a href="#modulesetting" class="active" title="<?php echo $heading_title; ?>"><?php echo $tab_setting; ?></a>
            <a href="#supporttabs" id="support" title="Support"><?php echo $tab_support; ?></a>
        </div> 
        <div id="modulesetting">
            <div class="content">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                    <table class="form" style="width: 50% !important; float:left;">
                        <tr>
                            <td><?php echo $text_ThemePopup;  ?></td>
                            <td>	
                                <select name="theme">
                                    <?php foreach ($themes as $theme) { ?>
                                    <option value="<?php echo $theme; ?>" <?php echo ($theme == $mcloudzooms['theme']) ?  "selected" : ''; ?>><?php echo $theme; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_animation_speed;  ?></td>
                            <td>	


                                <select name="animation_speed">
                                    <?php foreach ($animation_speeds as $animation_speed) { ?>
                                    <option value="<?php echo $animation_speed; ?>" <?php echo ($animation_speed == $mcloudzooms['animation_speed']) ?  "selected" : ''; ?>><?php echo $animation_speed; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_show_title;  ?></td>
                            <td>	
                                <select name="show_title">
                                    <?php foreach ($show_titles as $show_title) { ?>
                                    <option value="<?php echo $show_title; ?>" <?php echo ($show_title == $mcloudzooms['show_title']) ?  "selected" : ''; ?>><?php echo $show_title == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_autoplay_slideshow;  ?></td>
                            <td>	
                                <select name="autoplay_slideshow">
                                    <?php foreach ($autoplay_slideshows as $autoplay_slideshow) { ?>
                                    <option value="<?php echo $autoplay_slideshow; ?>" <?php echo ($autoplay_slideshow == $mcloudzooms['autoplay_slideshow']) ?  "selected" : ''; ?>><?php echo $autoplay_slideshow == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $text_allow_resize;  ?></td>
                            <td>	
                                <select name="allow_resize">
                                    <?php foreach ($allow_resizes as $allow_resize) { ?>
                                    <option value="<?php echo $allow_resize; ?>" <?php echo ($allow_resize == $mcloudzooms['allow_resize']) ?  "selected" : ''; ?>><?php echo $allow_resize == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>



                        <tr>
                            <td><?php echo $text_opacity;  ?></td>
                            <td><input type="text" value="<?php echo $mcloudzooms['opacity']; ?>" size="4" name="opacity"/><span class="help">Value between 0 and 1</span></td>
                        </tr>
                        <tr>
                            <td><?php echo $text_slideshow;  ?></td>
                            <td><input type="text" value="<?php echo $mcloudzooms['slideshow']; ?>" size="4" name="slideshow"/><span class="help">e.g: 5000 == 5 second</span></td>
                        </tr>

                        <tr>
                            <td><?php echo $text_show_popup_button;  ?></td>
                            <td>	
                                <select name="show_popup_button">
                                    <?php foreach ($show_popup_buttons as $show_popup_button) { ?>
                                    <option value="<?php echo $show_popup_button; ?>" <?php echo ($show_popup_button == $mcloudzooms['show_popup_button']) ?  "selected" : ''; ?>><?php echo $show_popup_button == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $text_show_social_button;  ?></td>
                            <td>	
                                <select name="show_social_button">
                                    <?php foreach ($show_social_buttons as $show_social_button) { ?>
                                    <option value="<?php echo $show_social_button; ?>" <?php echo ($show_social_button == $mcloudzooms['show_social_button']) ?  "selected" : ''; ?>><?php echo $show_social_button == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_show_carousel;  ?></td>
                            <td>	
                                <select name="show_carousel">
                                    <?php foreach ($show_carousels as $show_carousel) { ?>
                                    <option value="<?php echo $show_carousel; ?>" <?php echo ($show_carousel == $mcloudzooms['show_carousel']) ?  "selected" : ''; ?>><?php echo $show_carousel == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $text_show_title_cloud_zoom;  ?></td>
                            <td>	
                                <select name="show_title_cloud_zoom">
                                    <?php foreach ($show_title_cloud_zooms as $show_title_cloud_zoom) { ?>
                                    <option value="<?php echo $show_title_cloud_zoom; ?>" <?php echo ($show_title_cloud_zoom == $mcloudzooms['show_title_cloud_zoom']) ?  "selected" : ''; ?>><?php echo $show_title_cloud_zoom == 'true' ? 'Yes' : 'No'; ?></option>
                                    <?php } ?>
                                </select>											
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $text_border_cloud_zoom;  ?></td>                         
                            <td>	
                                <input type ="text" value="<?php echo $mcloudzooms['show_border_cloud_zoom']; ?>" size="4" name="show_border_cloud_zoom"/>&nbsp;<?php echo $color_border_cloud_zoom;  ?>										
                                <input type ="text" value="<?php echo $mcloudzooms['color_border_cloud_zoom']; ?>" size="4" name="color_border_cloud_zoom" id="color"/>
                                <div title="choose color" style="display: none;" id="colorpicker"></div>
                                <span class="help">e.g: 1 == 1px</span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $text_resize_cloud_zoom;  ?></td>
                            <td><input type="text" value="<?php echo $mcloudzooms['resize_cloud_zoom']; ?>" size="4" name="resize_cloud_zoom"/><span class="help">e.g: 300 == 300px</span></td>
                        </tr>
                    </table>
                    <table style="width: 45% !important; float:left;">

                        <tr>
                            <td>   <img src="view/image/mmos1.png" alt=""></td>
                        </tr>
                        <tr>
                            <td>  <img src="view/image/mmos2.png" alt=""></td>
                        </tr>

                    </table>
                </form>
            </div>
        </div>
       <div id="supporttabs">
            <div class="panel">
                        <div class=" clearfix">
                            <div class="panel-body">
                                <h4> About <?php echo $heading_title; ?></h4>
                                <h5>Installed Version: V.<?php echo $MMOS_version; ?> </h5>
                                <h5>Latest version: <span id="mmos_latest_version"><a href="http://mmosolution.com/index.php?route=product/search&search=<?php echo trim(strip_tags($heading_title)); ?>" target="_blank">Check update</a></span></h5>
                                <hr>
                                <h4>About Author</h4>
                                <div id="contact-infor">
                                    <i class="fa fa-envelope-o"></i> <a href="mailto:support@mmosolution.com?Subject=<?php echo trim(strip_tags($heading_title)).' OC '.VERSION; ?>" target="_top">support@mmosolution.com</a></br>
                                    <i class="fa fa-globe"></i> <a href="http://mmosolution.com" target="_blank">http://mmosolution.com</a> </br>
                                    <i class="fa fa-ticket"></i> <a href="http://mmosolution.com/support/" target="_blank">Open Ticket</a> </br>

                                    <br>
                                    <h4>Our on Social</h4>
                                    <a href="http://www.facebook.com/mmosolution" target="_blank"> Facebook</a> | 
                                    <a class="text-success" href="http://plus.google.com/+Mmosolution" target="_blank">Google Plus</a> | 
                                    <a class="text-warning" href="http://mmosolution.com/mmosolution_rss.rss" target="_blank">Our RSS Feed</a> | 
                                    <a href="http://twitter.com/mmosolution" target="_blank">Twitter</a> | 
                                    <a class="text-danger" href="http://www.youtube.com/mmosolution" target="_blank">Youtube</a> | 
                                </div>
                                <div id="relate-products">
  
                                </div>
                            </div>
                        </div>
						
						</div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
         var productcode = '<?php echo $MMOS_code_id; ?>';
        $('#mmosolution a').tabs();
        $("#color").on("click", function() {
            $("#colorpicker").dialog();
            $('#colorpicker').farbtastic('#color');
        });
    });
</script>
<script type="text/javascript" src="//mmosolution.com/support.js"></script>
<?php echo $footer; ?>