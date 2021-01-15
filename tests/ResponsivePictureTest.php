<?php
/**
 * ResponsivePicture class unit tests.
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images\Tests;

use PHPUnit\Framework\TestCase;

// SUT classes.
use Pixels\Components\Images\ResponsivePicture;

/**
 * ResponsiveImage unit tests.
 */
final class ResponsivePictureTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
        require_once __DIR__ . '/TestDoubles/wp_get_attachment_image_src.php';
        require_once __DIR__ . '/TestDoubles/esc_html.php';
    }

    /**
     * Can create instance
     */
    public function testCanCreateInstance()
    {
        $image = new ResponsivePicture(123);

        $this->assertInstanceOf(
            ResponsivePicture::class,
            $image
        );
    }

    /**
     * Can get html
     */
    public function testCanGetHtml()
    {
        $sizes = array(
            'page-hero'        => array( 1100, 500, true, true ),
            'page-hero-mobile' => array( 375, 500, true, true ),
        );

        $image = new ResponsivePicture(123);
        $image->add_theme_sizes($sizes);
        $image->add_breakpoint('600px');
        $image->set_mobile_size('page-hero-mobile');
        $image->set_desktop_size('page-hero');
        $image->set_alt_tag('Alternative tag for img');

        $expected = '<picture><source media="(max-width: 600px)" srcset="https://www.pixels.fi/images/123-page-hero-mobile.jpg 1x, https://www.pixels.fi/images/123-page-hero-mobile-retina.jpg 2x">
            <source media="(min-width: 600px)" srcset="https://www.pixels.fi/images/123-page-hero.jpg 1x, https://www.pixels.fi/images/123-page-hero-retina.jpg 2x">

            <img width="2200px" height="1000px" loading="lazy" src="https://www.pixels.fi/images/123-page-hero-retina.jpg" alt="Alternative tag for img" />
            
        </picture>';

        /**
         * ob_get leaves awful spacings.
         * Clear them out for comparisons
         */
        $this->assertEquals(
            str_replace(' ', '', $expected),
            str_replace(' ', '', $image->get_html())
        );
    }
}
