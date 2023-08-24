<?php

return [
    /**
     * If any input file(image) as default will used options below.
     */
    'image' => [
        /**
         * Path for store the image.
         *
         * avaiable options:
         * 1. public
         * 2. storage
         */
        'path' => 'storage',

        /**
         * Will used if image is nullable and default value is null.
         */
        'default' => 'https://via.placeholder.com/350?text=No+Image+Avaiable',

        /**
         * Crop the uploaded image using intervention image.
         */
        'crop' => true,

        /**
         * When set to true the uploaded image aspect ratio will still original.
         */
        'aspect_ratio' => true,

        /**
         * Crop image size.
         */
        'width' => 500,
        'height' => 500,
    ],

    'format' => [
        /**
         * Will used to first year on select, if any column type year.
         */
        'first_year' => 1900,

        /**
         * If any date column type will cast and display used this format, but for input date still will used Y-m-d format.
         *
         * another most common format:
         * - M d Y
         * - d F Y
         * - Y m d
         */
        'date' => 'd/m/Y',

        /**
         * If any input type month will cast and display used this format.
         */
        'month' => 'm/Y',

        /**
         * If any input type time will cast and display used this format.
         */
        'time' => 'H:i',

        /**
         * If any datetime column type or datetime-local on input, will cast and display used this format.
         */
        'datetime' => 'd/m/Y H:i',

        /**
         * Limit string on index view for any column type text or longtext.
         */
        'limit_text' => 100,
    ],

    /**
     * It will used for generator to manage and showing menus on sidebar views.
     *
     * Example:
     * [
     *   'header' => 'Main',
     *
     *   // All permissions in menus[] and submenus[]
     *   'permissions' => ['test view'],
     *
     *   menus' => [
     *       [
     *          'title' => 'Main Data',
     *          'icon' => '<i class="bi bi-collection-fill"></i>',
     *          'route' => null,
     *
     *          // permission always null when isset submenus
     *          'permission' => null,
     *
     *          // All permissions on submenus[] and will empty[] when submenus equals to []
     *          'permissions' => ['test view'],
     *
     *          'submenus' => [
     *                 [
     *                     'title' => 'Tests',
     *                     'route' => '/tests',
     *                     'permission' => 'test view'
     *                  ]
     *               ],
     *           ],
     *       ],
     *  ],
     *
     * This code below always changes when you use a generator and maybe you must lint or format the code.
     */
    'sidebars' => [
    [
        'header' => 'Main',
        'permissions' => [
            'bank view'
        ],
        'menus' => [
            [
                'title' => 'Main Data',
                'icon' => '<i class="bi bi-list-ul"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'bank view'
                ],
                'submenus' => [
                    [
                        'title' => 'Banks',
                        'route' => '/banks',
                        'permission' => 'bank view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'Setting',
        'permissions' => [
            'company view',
            'bank account view',
            'wa gateway view'
        ],
        'menus' => [
            [
                'title' => 'Setting Apps',
                'icon' => '<i class="bi bi-gear"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'company view',
                    'bank account view',
                    'wa gateway view'
                ],
                'submenus' => [
                    [
                        'title' => 'Tests',
                        'route' => '/tests',
                        'permission' => 'test view'
                    ],
                    [
                        'title' => 'Companies',
                        'route' => '/companies',
                        'permission' => 'company view'
                    ],
                    [
                        'title' => 'Bank Accounts',
                        'route' => '/bank-accounts',
                        'permission' => 'bank account view'
                    ],
                    [
                        'title' => 'Wa Gateway',
                        'route' => '/wa',
                        'permission' => 'wa gateway view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'Utilities',
        'permissions' => [
            'user view',
            'role & permission view'
        ],
        'menus' => [
            [
                'title' => 'Users & Roles',
                'icon' => '<i class="bi bi-people"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'user view',
                    'role & permission view'
                ],
                'submenus' => [
                    [
                        'title' => 'Users',
                        'route' => '/users',
                        'permission' => 'user view'
                    ],
                    [
                        'title' => 'Roles & permissions',
                        'route' => '/roles',
                        'permission' => 'role & permission view'
                    ]
                ]
            ]
        ]
    ]
]
];
