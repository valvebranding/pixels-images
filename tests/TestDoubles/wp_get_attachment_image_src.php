<?php
/**
 * Test double.
 *
 * @package PixelsImages.
 */

/**
 * Mock for wp_get_attachment_image_src
 */
function wp_get_attachment_image_src(int $id, string $size) : array
{
    return array( 'https://www.pixels.fi/images/' . $id . '-' . $size .  '.jpg' );
}
