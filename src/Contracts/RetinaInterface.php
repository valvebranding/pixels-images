<?php
/**
 * Retina Interface
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images\Contracts;

/**
 * Retina interface
 */
interface RetinaInterface
{

    /**
     * Check if image size has retina version.
     *
     * @param string $size_name of image.
     * @return bool $has_retina true/false.
     */
    public function has_retina(string $size_name) : bool;

    /**
     * Get retina size, if exists.
     *
     * @param string $size_name of image.
     * @return mixed $retina bool/string false or url of image.
     */
    public function get_retina(string $size_name);
}
