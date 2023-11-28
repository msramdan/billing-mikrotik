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
            'header' => 'Olts',
            'permissions' => [
                'olt view',
                'monitoring view'
            ],
            'menus' => [
                [
                    'title' => 'OLT',
                    'icon' => '<i class="bi bi-device-ssd"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'olt view',
                        'monitoring view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'OLT Management',
                            'route' => '/olts',
                            'permission' => 'olt view'
                        ],
                        [
                            'title' => 'OLT Monitoring',
                            'route' => '/monitorings',
                            'permission' => 'monitoring view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Keuangan',
            'permissions' => [
                'pemasukan view',
                'pengeluaran view',
                'tagihan view',
                'laporan view'
            ],
            'menus' => [
                [
                    'title' => 'Keuangan',
                    'icon' => '<i class="bi bi-cash-stack"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'pemasukan view',
                        'pengeluaran view',
                        'tagihan view',
                        'laporan view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Tagihan',
                            'route' => '/tagihans',
                            'permission' => 'tagihan view'
                        ],
                        [
                            'title' => 'Pemasukan',
                            'route' => '/pemasukans',
                            'permission' => 'pemasukan view'
                        ],
                        [
                            'title' => 'Pengeluaran',
                            'route' => '/pengeluarans',
                            'permission' => 'pengeluaran view'
                        ],
                        [
                            'title' => 'Laporan',
                            'route' => '/laporans',
                            'permission' => 'laporan view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Pelanggans',
            'permissions' => [
                'pelanggan view'
            ],
            'menus' => [
                [
                    'title' => 'Pelanggan',
                    'icon' => '<i class="bi bi-people"></i>',
                    'route' => '/pelanggans',
                    'permission' => 'pelanggan view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Mikrotik',
            'permissions' => [
                'log view',
                'dhcp view',
                'interface view',
                'settingmikrotik view',
                'statusrouter view'
            ],
            'menus' => [
                [
                    'title' => 'Mikrotik',
                    'icon' => '<i class="bi bi-device-ssd"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'log view',
                        'dhcp view',
                        'interface view',
                        'settingmikrotik view',
                        'statusrouter view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Status Router',
                            'route' => '/statusrouters',
                            'permission' => 'statusrouter view'
                        ],
                        [
                            'title' => 'Log Router',
                            'route' => '/logs',
                            'permission' => 'log view'
                        ],
                        [
                            'title' => 'DHCP Leases',
                            'route' => '/dhcps',
                            'permission' => 'dhcp view'
                        ],
                        [
                            'title' => 'All Interface',
                            'route' => '/interfaces',
                            'permission' => 'interface view'
                        ],
                        [
                            'title' => 'Setting Router',
                            'route' => '/settingmikrotiks',
                            'permission' => 'settingmikrotik view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Hotspot',
            'permissions' => [
                'hotspotactive view',
                'hotspotuser view'
            ],
            'menus' => [
                [
                    'title' => 'Hotspot',
                    'icon' => '<i class="bi bi-wifi"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'hotspotactive view',
                        'hotspotuser view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Users Hotspot',
                            'route' => '/hotspotusers',
                            'permission' => 'hotspotuser view'
                        ],
                        [
                            'title' => 'Active Hotspot',
                            'route' => '/hotspotactives',
                            'permission' => 'hotspotactive view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'PppOE',
            'permissions' => [
                'profile pppoe view',
                'active ppp view',
                'non active ppp view',
                'secret ppp view',
                'static view'
            ],
            'menus' => [
                [
                    'title' => 'PPPOE & Static',
                    'icon' => '<i class="bi bi-list-ul"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'profile pppoe view',
                        'active ppp view',
                        'non active ppp view',
                        'secret ppp view',
                        'static view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Profile PPP',
                            'route' => '/profile-pppoes',
                            'permission' => 'profile pppoe view'
                        ],
                        [
                            'title' => 'Secret PPP',
                            'route' => '/secret-ppps',
                            'permission' => 'secret ppp view'
                        ],
                        [
                            'title' => 'Active PPP',
                            'route' => '/active-ppps',
                            'permission' => 'active ppp view'
                        ],
                        [
                            'title' => 'Non Active PPP',
                            'route' => '/non-active-ppps',
                            'permission' => 'non active ppp view'
                        ],
                        [
                            'title' => 'User Static',
                            'route' => '/statics',
                            'permission' => 'static view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'layanan',
            'permissions' => [
                'area coverage view',
                'package view',
                'package category view',
                'odc view',
                'odp view'
            ],
            'menus' => [
                [
                    'title' => 'Kelola Layanan',
                    'icon' => '<i class="bi bi-boxes"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'area coverage view',
                        'package view',
                        'package category view',
                        'odc view',
                        'odp view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Area Coverages',
                            'route' => '/area-coverages',
                            'permission' => 'area coverage view'
                        ],
                        [
                            'title' => 'ODC',
                            'route' => '/odcs',
                            'permission' => 'odc view'
                        ],
                        [
                            'title' => 'ODP',
                            'route' => '/odps',
                            'permission' => 'odp view'
                        ],
                        [
                            'title' => 'Packages',
                            'route' => '/packages',
                            'permission' => 'package view'
                        ],
                        [
                            'title' => 'Package Categories',
                            'route' => '/package-categories',
                            'permission' => 'package category view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Setting',
            'permissions' => [
                'bank account view',
                'bank view',
                'sendnotif view',
                'paket view',
                'company view'
            ],
            'menus' => [
                [
                    'title' => 'Setting Apps',
                    'icon' => '<i class="bi bi-gear"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'bank account view',
                        'bank view',
                        'sendnotif view',
                        'paket view',
                        'company view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Daftar Company',
                            'route' => '/companies',
                            'permission' => 'company view'
                        ],
                        [
                            'title' => 'Daftar Paket',
                            'route' => '/pakets',
                            'permission' => 'paket view'
                        ],
                        [
                            'title' => 'Bank Accounts',
                            'route' => '/bank-accounts',
                            'permission' => 'bank account view'
                        ],
                        [
                            'title' => 'Banks',
                            'route' => '/banks',
                            'permission' => 'bank view'
                        ],
                        [
                            'title' => 'Send Notif WA',
                            'route' => '/sendnotifs',
                            'permission' => 'sendnotif view'
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
