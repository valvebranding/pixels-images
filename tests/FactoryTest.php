<?php
/**
 * Factory class unit tests.
 *
 * @package PixelsImages
 */

namespace Pixels\Components\Images\Tests;

use PHPUnit\Framework\TestCase;

// SUT classes.
use Pixels\Components\Images\Factory as ImageFactory;

/**
 * Factory unit tests.
 */
final class FactoryTest extends TestCase
{

    /**
     * Include doubles for wp functions & constants
     */
    public static function setUpBeforeClass(): void
    {
        require_once __DIR__ . '/TestDoubles/add_theme_support.php';
        require_once __DIR__ . '/TestDoubles/add_image_size.php';
    }

    /**
     * Can inject image sizes array
     */
    public function testCanInjectImageSizes()
    {
        $sizes = array(
            'page-hero'        => array( 1100, 500, true, true ),
            'page-hero-mobile' => array( 375, 500, true, true ),
        );

        $this->assertEquals(ImageFactory::$sizes, array());
        
        // Register sizes to image factory.
        ImageFactory::add_image_sizes($sizes);

        $this->assertEquals(ImageFactory::$sizes, $sizes);
    }
    
    /**
     * Can inject custom breakpoint array
     */
    public function testCanInjectBreakpoint()
    {

        $this->assertEquals(ImageFactory::$breakpoint, '576px');
        
        ImageFactory::add_breakpoint('600px');

        $this->assertEquals(ImageFactory::$breakpoint, '600px');
    }
}
