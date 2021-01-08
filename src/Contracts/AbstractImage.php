<?php
/**
 * Abstract for our custom image types.
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images;

/**
 * Contains methods & props common for
 * our responsive images.
 */
abstract class AbstractImage
{

    /**
     * Image / attatchment id.
     *
     * @var int.
     */
    protected $id;

    /**
     * Mobile size name
     *
     * @var string.
     */
    protected $mobile_size;

    /**
     * Desktop size name
     *
     * @var string.
     */
    protected $desktop_size;

    /**
     * Alternative tag.
     *
     * @var string.
     */
    protected $alt;

    /**
     * Theme image size data.
     *
     * @var array.
     */
    public $sizes;

    /**
     * Breakpoint for mobile / desktop.
     *
     * @var string.
     */
    public $breakpoint;

    /**
     * Class constructor
     *
     * @param int $id of attachment.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Set mobile size name.
     *
     * @param string $mobile_size name.
     */
    public function set_mobile_size($mobile_size)
    {
        $this->mobile_size = $mobile_size;
    }

    /**
     * Set desktop size name.
     *
     * @param string $desktop_size name.
     */
    public function set_desktop_size($desktop_size)
    {
        $this->desktop_size = $desktop_size;
    }

    /**
     * Get mobile size name.
     *
     * @return string $mobile_size name.
     */
    public function get_mobile_size()
    {
        return $this->mobile_size;
    }

    /**
     * Get desktop size name.
     *
     * @return string $desktop_size name.
     */
    public function get_desktop_size()
    {
        return $this->desktop_size;
    }

    /**
     * Set image alt tag.
     *
     * @param string $alt text of image.
     */
    public function set_alt_tag($alt)
    {
        $this->alt = $alt;
    }

    /**
     * Get image alt tag.
     *
     * @return string $alt text of image.
     */
    public function get_alt_tag()
    {
        return $this->alt;
    }

    /**
     * Save theme sizes to property.
     */
    public function add_theme_sizes(array $sizes)
    {
        $this->sizes = $sizes;
    }

    /**
     * Save breakpoint property.
     */
    public function add_breakpoint(string $breakpoint)
    {
        $this->breakpoint = $breakpoint;
    }

    /**
     * Return urls array of image.
     */
    abstract public function get_urls();
}
