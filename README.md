# Pixels Images

Responsive Image component for WordPress. Handles retina sizes & different image shape for mobile.

- Allows images to have normal & retina size
- Allows images to have different mobile image in different aspect ratio
- Automatically handles lazyload
- Uses Picture tag for images & custom background style set for background images.

# Install

`composer require pixelshelsinki/images`

# Usage

Pixels Images consists of individual classes for image handling + a static factory for easily using them. Before using new image handlers you just have to register image sizes using the Factory class.

### Register image sizes.

Declare your image sizes in your theme / plugin. Good spot would be 'init' action hook.

```php
<?php

use Pixels\Components\Images\Factory as ImageFactory;

/**
 * Image sizes array
 * Pattern:
 *
 * NAME, WIDTH, HEIGHT, CROP, RETINA TRUE/FALSE
 *
 * @var array
 */
$sizes = array(
    'page-hero'        => array( 1100, 500, true, true ),
    'page-hero-mobile' => array( 375, 500, true, true ),
);

// Register sizes to image factory.
ImageFactory::add_image_sizes( $sizes );

/**
 * You can also optionally register css-style breakpoint for mobile / desktop.
 * Default is 576px.
 */
ImageFactory::add_breakpoint( '600px' );
```

### Using responsive picture.

Usage in PHP:

```php
<?php

use Pixels\Components\Images\Factory as ImageFactory;

$image_html = ImageFactory::responsive_image( $image_id, 'my_mobile_size', 'my_desktop_size', 'my alt text' );

echo $image_html;

```

### Using responsive background.

Usage in PHP. Note that element with given CSS selector must exist in dom. Can be any valid css selector, like class or id.:

```php
<?php

use Pixels\Components\Images\Factory as ImageFactory;

$image_html = ImageFactory::responsive_background( $image_id, 'my_mobile_size', 'my_desktop_size', '#my_html_element' );

echo $image_html;

```

### Using with Twig / Timber.

Easiest way is to register the factory functions as Twig helper functions.

```php
<?php

add_filter( 'get_twig', array( 'add_image_functions' ) );

function add_image_functions( $twig ) {
    // Responsive mage helper functions.
    $twig->addFunction( new \Timber\Twig_Function( 'responsive_image', '\\Pixels\\Components\\Images\\Factory::responsive_image' ) );
    $twig->addFunction( new \Timber\Twig_Function( 'responsive_background', '\\Pixels\\Components\\Images\\Factory::responsive_background' ) );

    return $twig;
}

```