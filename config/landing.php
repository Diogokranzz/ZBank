<?php

return [


    'hero' => [
        'title' => 'A Modern Bank Card For A Modern World',
        'description' => 'This Modern Bank Card Embraces The Era Of Contactless Payments, Enabling Swift And Effortless Transactions With Just A Tap Or Wave. No More Fumbling For Cash Or Struggling With Outdated Payment Methods.',
        'cta_text' => 'Explore More',
        'cta_url' => '/register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Bank Card Configuration
    |--------------------------------------------------------------------------
    |
    | Static data for the bank card visual including cardholder name
    | and card number display.
    |
    */

    'card' => [
        'holder_name' => 'ZBank Card',
        'number' => '4234 **** **** 1234',
        'qr_code_placeholder' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Brand Logos Configuration
    |--------------------------------------------------------------------------
    |
    | List of partner brand logos to display below the CTA button.
    | Each brand includes a name and logo filename.
    |
    */

    'brands' => [
        [
            'name' => 'Precision',
            'logo' => 'precision.svg',
        ],
        [
            'name' => 'MIT',
            'logo' => 'mit.svg',
        ],
        [
            'name' => 'ArsenalBio',
            'logo' => 'arsenalbio.svg',
        ],
        [
            'name' => 'Stretch',
            'logo' => 'stretch-1.svg',
        ],
        [
            'name' => 'Stretch',
            'logo' => 'stretch-2.svg',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Info Section Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the secondary informational section below the hero.
    | Includes title and descriptive text about the banking services.
    |
    */

    'info_section' => [
        'title' => 'We Tried To Provide You With All Global Banking Services',
        'description' => 'We Made Every Effort To Ensure That You Have Access To A Comprehensive Range Of Global Banking Services. Our Aim Was To Provide You With A Seamless Banking Experience That Caters To Your Financial Needs Regardless Of Your Location.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the navigation bar including logo text and
    | navigation links.
    |
    */

    'navigation' => [
        'logo_text' => 'ZBank',
        'links' => [
            ['text' => 'Home', 'url' => '/', 'has_dropdown' => false],
            ['text' => 'Learn', 'url' => '#', 'has_dropdown' => true],
            ['text' => 'Help', 'url' => '#', 'has_dropdown' => false],
            ['text' => 'Blog', 'url' => '#', 'has_dropdown' => false],
            ['text' => 'About', 'url' => '#', 'has_dropdown' => false],
        ],
        'sign_in_url' => '/login',
    ],

];
