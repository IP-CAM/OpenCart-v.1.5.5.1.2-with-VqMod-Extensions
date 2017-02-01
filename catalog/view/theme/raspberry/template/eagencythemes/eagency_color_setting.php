<?php 
$b_Color_Data = array();
$b_Color_Data = $this->config->get('b_Color_Data');
?>
<?php $objXML = simplexml_load_file("eagency/color_setting.xml");
?>
<style type="text/css">
/************* Header Setting Colors ****************/
<?php foreach ($objXML->children() as $child) {
	
	foreach($child->children() as $childOFchild){ ?>
	<?php foreach($childOFchild->children() as $childOF){ ?>
		<?php if($childOF->name){?>
			<?php echo $childOF->class; ?> { 
				<?php if($childOFchild->getName()=='background') {?>
					<?php 
						$bg_name = $childOF->name; 
						$pieces = explode("_", $bg_name);
						$pre = $pieces[0];
					?>
					<?php if($b_Color_Data[''.$childOF->name.'']){ ?>
						<?php echo $childOF->style; ?>: #<?php echo $b_Color_Data[''.$childOF->name.'']; ?>;
					<?php } ?>
					<?php if($b_Color_Data[''.$pre.'_bg_image']==''.$pre.'_upload_bg_image') {?>
					background-image: url("image/<?php echo $b_Color_Data[''.$pre.'_upload_bg_image']; ?>"); 
					<?php } else {?>
						<?php if($b_Color_Data[''.$pre.'_bg_image']=='default') {} else {?>
					background-image: url("image/data/background/<?php echo $b_Color_Data[''.$pre.'_bg_image']; ?>");
					<?php } }?>
					background-position: <?php echo $b_Color_Data[''.$pre.'_bg_image_position']; ?> ;
					background-repeat: <?php echo $b_Color_Data[''.$pre.'_bg_image_repeat']; ?>;
				<?php }else { ?>
					<?php if($b_Color_Data[''.$childOF->name.'']){ ?>
							<?php echo $childOF->style; ?>: #<?php echo $b_Color_Data[''.$childOF->name.'']; ?>;
					<?php } ?>
				<?php } ?>
			}
		<?php } ?>
	<?php	} ?>
<?php } } ?>
</style>