<?php
$slide_title = ( ( !empty($fields['field_slide_title']->content) ) ? ( '<h2>' . $fields['field_slide_title']->content . '</h2>' ) : '' );
$slide_text_location = ( ( !empty($fields['field_slide_text_location']->content) ) ? strtolower($fields['field_slide_text_location']->content) : 'hide' ) . '-cap';
?>
<div class="slide-image">
	<a href="<?php echo $fields['field_slide_link']->content; ?>">
		<div class="full-img">
			<?php echo $fields['field_slide_image']->content; ?>
		</div>
		<div class="slide-text <?php echo $slide_text_location; ?>"><?php echo $slide_title . $fields['field_slide_text']->content; ?></div>
	</a>
</div>