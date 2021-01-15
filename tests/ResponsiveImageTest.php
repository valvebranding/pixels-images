<?php
/**
 * ResponsiveImage class unit tests.
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images\Tests;

use PHPUnit\Framework\TestCase;

// SUT classes.
use Pixels\Components\Images\ResponsiveImage;

/**
 * ResponsiveImage unit tests.
 */
final class ResponsiveImageTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
        require_once __DIR__ . '/TestDoubles/wp_get_attachment_image_src.php';
    }

    /**
     * Can create instance
     */
    public function testCanCreateInstance()
    {
        $image = new ResponsiveImage(123);

        $this->assertInstanceOf(
            ResponsiveImage::class,
            $image
        );
    }

    /**
     * Can get / set alt tag
     */
    public function testCanGetAndSetAltTag()
    {
        $image = new ResponsiveImage(123);
        $image->set_alt_Tag('Image is nice');

        $this->assertEquals(
            'Image is nice',
            $image->get_alt_tag()
        );
    }

    /**
     * Can get / set sizes
     */
    public function testCanGetAndSetSizes()
    {
        $image = new ResponsiveImage(123);
        $image->set_mobile_size('page-hero-mobile');
        $image->set_desktop_size('page-hero');

        $this->assertEquals(
            'page-hero-mobile',
            $image->get_mobile_size()
        );

        $this->assertEquals(
            'page-hero',
            $image->get_desktop_size()
        );
    }

    /**
     * Can get urls
     */
    public function testCanGetUrlsArray()
    {
        $sizes = array(
            'page-hero'        => array( 1100, 500, true, true ),
            'page-hero-mobile' => array( 375, 500, true, true ),
        );

        $image = new ResponsiveImage(123);
        $image->add_theme_sizes($sizes);
        $image->set_mobile_size('page-hero-mobile');
        $image->set_desktop_size('page-hero');

        $expected = array(
            'mobile'         => 'https://www.pixels.fi/images/123-page-hero-mobile.jpg',
            'mobile_retina'  => 'https://www.pixels.fi/images/123-page-hero-mobile-retina.jpg',
            'desktop'        => 'https://www.pixels.fi/images/123-page-hero.jpg',
            'desktop_retina' => 'https://www.pixels.fi/images/123-page-hero-retina.jpg',
        );

        $this->assertEquals(
            $expected,
            $image->get_urls()
        );
    }

    /**
     * Retina checks work.
     */
    public function testCanDetectRetinaSizes()
    {
        $sizes = array(
            'page-hero'        => array( 1100, 500, true, true ),
            'page-hero-mobile' => array( 375, 500, true, false ),
        );

        $image = new ResponsiveImage(123);
        $image->add_theme_sizes( $sizes );

        $this->assertTrue( $image->has_retina( 'page-hero' ) );

        $this->assertFalse( $image->has_retina( 'page-hero-mobile' ) );
    }
}
