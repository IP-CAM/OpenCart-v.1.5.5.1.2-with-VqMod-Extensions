<?php
/************* CUSTOM FONTS SETTING **************/
$defaultFont = array( 
	'Arial', 
	'Verdana', 
	'Helvetica', 
	'Lucida Grande', 
	'Trebuchet MS', 
	'Times New Roman', 
	'Tahoma', 
	'Georgia'
);
$BossFontData = array();
$BossFontData = $this->config->get('b_Font_Data');
$objXML = simplexml_load_file("eagency/font_setting.xml");
?>
<?php foreach ($objXML->children() as $child) {	
	foreach($child->children() as $childOFchild){ 
		 $style_name =  $childOFchild->style; 
		 $is_array = in_array($BossFontData[''.$style_name.''], $defaultFont);
		 if($BossFontData[''.$style_name.''] != 'default' && ($is_array==false)) { ?>
			<link href='//fonts.googleapis.com/css?family=<?php echo $BossFontData[''.$style_name.''];?>' rel='stylesheet' type='text/css'>
		<?php }
} } ?>
<style type="text/css">
<?php foreach ($objXML->children() as $child) {	
	foreach($child->children() as $childOFchild){ ?>
		<?php $style_name =  $childOFchild->style; ?>
		<?php $size_name =  $childOFchild->size; ?>
		<?php $weight_name =  $childOFchild->weight; ?>
		<?php $transform_name =  $childOFchild->transform; ?>
		<?php $class_name =  $childOFchild->class_name; ?>
		<?php if($BossFontData[''.$style_name.''] != 'default') {$fontStyle = str_replace("+", " ", $BossFontData[''.$style_name.'']); ?>
		<?php echo $class_name; ?> { 
				font-family: <?php echo $fontStyle ?>;
				<?php if($BossFontData[''.$size_name.'']!='default') { ?> 
				font-size: <?php echo $BossFontData[''.$size_name.'']; ?>;
				<?php } ?>
				<?php if($BossFontData[''.$weight_name.'']!='default') { ?>
				font-weight: <?php echo $BossFontData[''.$weight_name.'']; ?>;
				<?php } ?>
				<?php if($BossFontData[''.$transform_name.'']!='default') { ?>
				text-transform: <?php echo $BossFontData[''.$transform_name.'']; ?>;
				<?php } ?>
			}
		<?php } ?>
<?php } } ?>
</style>





