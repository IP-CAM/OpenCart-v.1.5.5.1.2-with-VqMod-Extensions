<style>
    .zoom-top { 
        margin-left:<?php echo $this->config->get('config_image_thumb_width')-29 ?>px;
		z-index: 10;
	    position: absolute;
    }
    .image-additional ul li {
        list-style-type: none !important;
    }
    a.pp_close {
        z-index: 100;
        top: -13px !important;
        right: -7px !important;
    }
    .cloud-zoom-big {
		top: -1px !important;
        overflow:hidden !important;
        z-index: 10000 !important;
        margin-left: 10px;
        border:<?php echo $this->config->get('show_border_cloud_zoom'); ?>px solid <?php echo $this->config->get('color_border_cloud_zoom'); ?> !important;      
    }
		.product-info {
		overflow:hidden;
		
		}
	.product-info .image {
		border-left: 1px solid #E5E5E5;
		}
    
	.left{
	  width:  <?php echo  $this->config->get('config_image_thumb_width') + 15; ?>px;
	}
    .product-info > .left + .right {
        margin-left: <?php echo  $this->config->get('config_image_thumb_width') + 35; ?>px !important;
    }
    .product-info .image-additional{
        width: <?php echo  $this->config->get('config_image_thumb_width'); ?>px;
     }
	 .product-info > .left {
		float: left;
		margin-top:11px;
		}
	@media only screen and (max-width: 479px) {
	.product-info > .left + .right {
		 margin-left: 0px !important;
		}
			
		.product-info .image {
				float: none;
				max-width: 100%;
				border-right: 1px solid #e5e5e5;
				margin: 0px auto;
		}
	.product-info .right {
        width: 100%;
		clear:both;
    }
	.product-info .left{
	  width: 100%;
	}
	.zoom-top {
		margin-left: 80%;
		z-index: 10;
		position: absolute;
		}
	.product-info .image-additional {
		width: 95%;
		clear:both;
		margin: 10px 0 0 0;
		padding-left: 0px; 
		
	}
	}
	
	 
</style>

    <?php foreach ($images as $image) { ?>
    <div class="zoom-top" style="<?php if ($mcloudzooms['show_popup_button'] == 'false') { echo 'display: none' ;} ?>">      <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"  rel="prettyPhoto[pp_gal]" ><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>
    <?php } ?>
    <?php if ($thumb) { ?>
    <?php if($mcloudzooms['show_title_cloud_zoom'] != 'true') $heading_title ='';  ?>
    <div class="image"> 
        <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" data-rel="prettyPhoto[pp_gal]" class = 'cloud-zoom' id='zoom1' rel="position: 'right'" >
            <img src="<?php echo $thumb; ?>"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
        </a>
        
    </div>
    <?php } ?>
    <?php $cl1=''; if (count($images) > 1) {
    if (count($images)>3 && $mcloudzooms['show_carousel']=='true') {
    $cl1='image-caroucel';
    }
    else {
    $cl1='';
    }
    ?>
    <div class="image-additional <?php echo $cl1;?>">
        <ul>

            <?php $u=0; foreach ($images as $image) {
            $u++;
            $cl='';
            if ( count($images)<4 and $u==3) {
            $cl='class="last"';
            }
            else {
            $cl='';
            }


            ?>
            <li <?php echo $cl;?>>
                <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '<?php echo $image['thumb']; ?>' "><img src="<?php echo $image['small']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            </li>
            <?php } ?>
        </ul>
	</div>
    <?php } ?>
    <script type="text/javascript">
        
        var bigwidthcl = '<?php echo $this->config->get("resize_cloud_zoom"); ?>';
        $(document).ready(function() {
            $('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
            $(".cloud-zoom-wrap").on("click", function() {
                 $("a[rel^='prettyPhoto']").first().trigger("click");
            });
            
            $("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: '<?php echo $mcloudzooms['animation_speed'] ; ?>', /* fast/slow/normal */
                    slideshow: <?php echo $mcloudzooms['slideshow'] ; ?>, /* false OR interval time in ms */
                    autoplay_slideshow: <?php echo $mcloudzooms['autoplay_slideshow'] ; ?>, /* true/false */
                    opacity: <?php echo $mcloudzooms['opacity'] ; ?>, /* Value between 0 and 1 */
                    show_title: <?php echo $mcloudzooms['show_title'] ; ?>, /* true/false */
                    allow_resize: <?php echo $mcloudzooms['allow_resize'] ; ?>, /* Resize the photos bigger than viewport. true/false */
                    default_width: <?php echo  $this->config->get('config_image_popup_width'); ?> ,
                    default_height: <?php echo  $this->config->get('config_image_popup_height'); ?> ,
                    counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
                    theme: '<?php echo $mcloudzooms['theme'] ; ?>', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
                    modal: false, /* If set to true, only the close button will close the window */
                    overlay_gallery: true, /* If set to true, a gallery will overlay the fullscreen image on mouse over */               
                    <?php if ($mcloudzooms['show_social_button'] == 'false') { echo "social_tools: ''," ;}  ?>                   
        });
      
        // box slide show image
        $('.related-carousel .box-product ul').jcarousel({
            vertical: false,
            visible: 4,
            scroll: 1
        });
        $('div.image-caroucel').jcarousel({
        vertical: false,
                visible: 3,
                scroll: 1
        });
        });

    </script>








