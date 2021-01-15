<?php
/**
 * ResponsiveBackground class unit tests.
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images\Tests;

use PHPUnit\Framework\TestCase;

// SUT classes.
use Pixels\Components\Images\ResponsiveBackground;

/**
 * ResponsiveBackground unit tests.
 */
final class ResponsiveBackgroundTest extends TestCase
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
        $image = new ResponsiveBackground(123);

        $this->assertInstanceOf(
            ResponsiveBackground::class,
            $image
        );
    }

    /**
     * Can get / set selector
     */
    public function testCanGetAndSetSelector()
    {
        $image = new ResponsiveBackground(123);
        $image->set_selector('#my_div');

        $this->assertEquals(
            '#my_div',
            $image->get_selector()
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

        $image = new ResponsiveBackground(123);
        $image->add_theme_sizes($sizes);
        $image->add_breakpoint('600px');
        $image->set_mobile_size('page-hero-mobile');
        $image->set_desktop_size('page-hero');
        $image->set_selector('#my_div');

        /**
         * Unfortunate formatting due to ob_get
         * Comparison is strict about these things.
         */
        $expected = '<style>#my_div            {
            background-image:url( https://www.pixels.fi/images/123-page-hero-mobile-retina.jpg );
            background-image: -webkit-image-set(url(https://www.pixels.fi/images/123-page-hero-mobile.jpg) 1x, url(https://www.pixels.fi/images/123-page-hero-mobile-retina.jpg) 2x);
            background-image: image-set(url(https://www.pixels.fi/images/123-page-hero-mobile.jpg) 1x, url(https://www.pixels.fi/images/123-page-hero-mobile-retina.jpg ) 2x);
        }
        @media only screen and (min-width : 600px ) {
        #my_div {
            background-image:url( https://www.pixels.fi/images/123-page-hero-retina.jpg );
            background-image: -webkit-image-set(url(https://www.pixels.fi/images/123-page-hero.jpg) 1x, url(https://www.pixels.fi/images/123-page-hero-retina.jpg) 2x);
            background-image: image-set(url(https://www.pixels.fi/images/123-page-hero.jpg) 1x, url(https://www.pixels.fi/images/123-page-hero-retina.jpg ) 2x);
        }
        }
        </style>';


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
