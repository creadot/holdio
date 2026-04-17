<?php

/**
 * Wrapper for Better image sizes plugin (https://wordpress.org/plugins/better-image-sizes/)
 *
 * @copyright  2024 Creadot
 */
class Img {

	/**
	 * Returns src of image, width and height
	 *
	 * @param int (required)			$attachment_id	The ID of the image attachment
	 * 													Example: 123 or get_post_thumbnail_id() or get_field('my_image')
	 * @param array (required)			$size			An array with the width and height
	 * 													Example: [ 1920, 1080 ]
	 * @param boolean|int|array|string	$crop			Skip this or pass false or 0 if you don’t want to crop, just rescale,
	 *													otherwise pass true or 1 to use focal point crop that is selected in admin media (by default center),
	 *													or pass array with string x-axis and y-axis parameters like [ 'right', 'bottom' ]
	 *													or pass array with numeric x-axis and y-axis parameters like [ 0.5, 0.8 ]
	 *													or pass string 'face' to automatically detect face position (can be exhaustive on server resources)
	 *
	 * @return array(
	 * 			'src'    => string	url of the image,
	 * 			'width'  => integer	width in pixels,
	 * 			'height' => integer	height in pixels
	 * 		   )
	 * @static
	 */
	public static function src($attachment_id, $size, $crop = false) {
		if (function_exists('bis_get_attachment_image_src')) {
			return bis_get_attachment_image_src($attachment_id, $size, $crop);
		}
	}

	/**
	 * Returns <img> element with width, height and other attrs
	 *
	 * @param int (required)			$attachment_id	The ID of the image attachment
	 * 													Example: 123 or get_post_thumbnail_id() or get_field('my_image')
	 * @param array (required)			$size			An array with the width and height
	 * 													Example: [ 1920, 1080 ]
	 * @param boolean|int|array|string	$crop			Skip this or pass false|0 if you don’t want to crop, just rescale,
	 *													otherwise pass true|1 to use focal point crop that is selected in admin media (by default center),
	 *													or pass array with string x-axis and y-axis parameters like [ 'right', 'bottom' ]
	 *													or pass array with numeric x-axis and y-axis parameters like [ 0.5, 0.8 ]
	 *													or pass string 'face' to automatically detect face position (can be exhaustive on server resources)
	 * @param array						$attr			An array of attributes
	 * 													Special attribute retina allows you to automatically generate srcset for @2x retina devices
	 * 													Example: [ 'retina' => true, 'alt' => 'Custom alt text', 'class' => 'my-class', 'id' => 'my-id' ]
	 *
	 * @return string	<img> element
	 * 					Example: <img src="https://web.com/wp-content/uploads/bis-images/1234/your-image-500x500-f50_50.jpg" width="500" height="500" alt="Alt text">
	 * @static
	 */
	public static function img($attachment_id, $size, $crop = false, $attr = []) {
		if (function_exists('bis_get_attachment_image')) {
			return bis_get_attachment_image($attachment_id, $size, $crop, $attr);
		}
	}

	/**
	 * Alias for self::img()
	 *
	 * @static
	 */
	public static function html($attachment_id, $size, $crop = false, $attr = []) {
		self::img($attachment_id, $size, $crop, $attr);
	}

	/**
	 * Returns <picture> element with <source> and <img> elements (with width, height and other attrs)
	 *
	 * @param int (required)			$attachment_id	The ID of the image attachment
	 * 													Example: 123 or get_post_thumbnail_id() or get_field('my_image')
	 * @param array (required)			$sizes			An array with the key => value pair
	 * 													- key means breakpoint (max-width)
	 * 													- value is array of width, height, crop and alternative_attachment_id
	 * 													Example:
	 * 														[
	 * 															9999 => [ 1200, 500, 1 ],
	 * 															767  => [  767, 400, 1, 987 ],
	 * 														]
	 * 													This will generate:
	 * 														<source media="(max-width:767px)" srcset="image987_767x400.jpg">
	 * 														<source media="(max-width:9999px)" srcset="image_1200x500.jpg">
	 * 														<source media="(min-width:10000px)" srcset="image.jpg">
	 * @param array						$attr			An array of attributes
	 * 													Special attribute retina allows you to automatically generate srcset for @2x retina devices
	 * 													Example: array( 'retina' => true, 'alt' => 'Custom alt text', 'class' => 'my-class', 'id' => 'my-id' )
	 *
	 * @return string	<picture> element with <source> and <img> elements
	 * 					Example:
	 * 						<picture>
	 * 							<source ...>
	 * 							<source ...>
	 * 							<img ...>
	 * 						</picture>
	 * @static
	 */
	public static function picture($attachment_id, $sizes, $attr = []) {
		if (function_exists('bis_get_attachment_picture')) {
			return bis_get_attachment_picture($attachment_id, $sizes, $attr);
		}
	}

	/**
	 * Returns position of focal point
	 *
	 * @param int	$attachment_id	The ID of the image attachment
	 *
	 * @return array(float, float)
	 * 			float	x - from left (0-1),
	 * 			float	y - from top (0-1)
	 * 		   )
	 * @static
	 */
	public static function focalPoint($attachment_id) {
		if (function_exists('sanitize_focal_point')) {
			return $focalPoint = sanitize_focal_point(get_post_meta($attachment_id, 'focal_point', true));
		}
	}
}
