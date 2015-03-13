Required modules:
	- menu_block
	- views
	- jquery_update
	- flexslider
	- ckeditor (for wysiwyg with media embed features)

Main Navigation Setup:
	- Create/modify a menu under: structure > menus (up to three tiers)
	- Add a new menu block under: structure > blocks
		- Block title: <none>
		- Menu: (the created/modified menu)
		- Starting level: 1st level
		- Maximum depth: 3
		- Expand all children
		- Region settings: York [Navigation bar]

Slider setup:
	- Create content type with:
		- `field_slide_title` field <text>
		- `field_slide_image` field <image>
		- `field_slide_text` field <text> 
		- `field_slide_text_location` field <boolean> (Options: Left and Right)
		- `field_slide_link` field <text> (For slide link)
	- Create a new view block filtering by the slider content type just created.
		- Use all the above fields
		- Remove field html tags
		- Rename views-field template file to match view name. E.g. views-view-fields--slider.tpl.php	`slider` being the view name
		- Make sure the image field is set to an image style with: Scale 1150x360 (upscale allowed)