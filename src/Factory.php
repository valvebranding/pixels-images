<?php
/**
 * Image Factory.
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images;

use Pixels\Components\Images\ResponsivePicture;
use Pixels\Components\Images\ResponsiveBackground;

/**
 * Create custom image instance on demand.
 */
class Factory
{

    /**
     * Image sizes array
     * Pattern:
     *
     * NAME, WIDTH, HEIGHT, CROP, RETINA TRUE/FALSE
     *
     * @var array
     */
    public static $sizes = array();


    /**
     * Breakpoint for switching from mobile img to desktop image
     * Will be used in <sources> and inline styles.
     *
     * @var string.
     */
    public static $breakpoint = '576px';

    /**
     * Register theme image sizes.
     * --> Loop through sizes array
     * --> If retina, create double version too.
     */
    public static function add_image_sizes(array $sizes)
    {
        static::$sizes = $sizes;

        add_theme_support('post-thumbnails');

        foreach ($sizes as $name => $details) :
            // Register standard size.
            add_image_size($name, $details[0], $details[1], $details[2]);

            // Check for retina enable.
            if ($details[3]) :
                add_image_size($name . '-retina', $details[0] * 2, $details[1] * 2, $details[2]);
            endif;
        endforeach;
    }

    /**
     * Set custom breakpoint for mobile / desktop.
     */
    public static function add_breakpoint(string $breakpoint)
    {
        static::$breakpoint = $breakpoint;
    }

    /**
     * Output <picture> tag with two image sizes
     *
     * @param int    $image_id of image / attachment.
     * @param string $mobile_size name.
     * @param string $desktop_size name.
     * @param string $alt tag of image, optional.
     * @return string.
     */
    public static function responsive_image($image_id, $mobile_size, $desktop_size, $alt = null)
    {

        // Create responsive image instance.
        $image = new ResponsivePicture($image_id);
        $image->add_theme_sizes(static::$sizes);
        $image->add_breakpoint(static::$breakpoint);

        // Default to main caption if not provided.
        $alt = $alt ?? wp_get_attachment_caption($image_id);

        // Add img sizes.
        $image->set_mobile_size($mobile_size);
        $image->set_desktop_size($desktop_size);
        $image->set_alt_tag($alt);

        return $image->get_html();
    }

    /**
     * Output background image with two sizes in <style> tag
     *
     * @param int    $image_id of image / attachment.
     * @param string $mobile_size name.
     * @param string $desktop_size name.
     * @param string $selector css selector of background. Like #my_background.
     * @return string.
     */
    public static function responsive_background($image_id, $mobile_size, $desktop_size, $selector)
    {

        $image = new ResponsiveBackground($image_id);
        $image->add_theme_sizes(static::$sizes);
        $image->add_breakpoint(static::$breakpoint);

        // Add img sizes.
        $image->set_selector($selector);
        $image->set_mobile_size($mobile_size);
        $image->set_desktop_size($desktop_size);

        return $image->get_html();
    }
}
