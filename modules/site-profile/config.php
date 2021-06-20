<?php

return [
    '__name' => 'site-profile',
    '__version' => '0.1.0',
    '__git' => 'git@github.com:getmim/site-profile.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/site-profile' => ['install','update','remove'],
        'app/site-profile' => ['install','remove'],
        'theme/site/profile' => ['install','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'profile' => NULL
            ],
            [
                'site-meta' => NULL
            ],
            [
                'lib-formatter' => NULL
            ]
        ],
        'optional' => [
            [
                'lib-event' => NULL
            ],
            [
                'lib-cache-output' => NULL
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'SiteProfile\\Controller' => [
                'type' => 'file',
                'base' => ['modules/site-profile/controller','app/site-profile/controller']
            ],
            'SiteProfile\\Library' => [
                'type' => 'file',
                'base' => 'modules/site-profile/library'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'site' => [
            'siteProfileIndex' => [
                'path' => [
                    'value' => '/profile'
                ],
                'method' => 'GET',
                'handler' => 'SiteProfile\\Controller\\Profile::index'
            ],
            'siteProfileSingle' => [
                'path' => [
                    'value' => '/profile/(:name)',
                    'params' => [
                        'name' => 'slug'
                    ]
                ],
                'method' => 'GET',
                'handler' => 'SiteProfile\\Controller\\Profile::single'
            ],
            'siteProfileFeed' => [
                'path' => [
                    'value' => '/profile/feed.xml'
                ],
                'method' => 'GET',
                'handler' => 'SiteProfile\\Controller\\Robot::feed'
            ]
        ]
    ],
    'libFormatter' => [
        'formats' => [
            'profile' => [
                'page' => [
                    'type' => 'router',
                    'router' => [
                        'name' => 'siteProfileSingle',
                        'params' => [
                            'name' => '$name'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'libEvent' => [
        'events' => [
            'profile:created' => [
                'SiteProfile\\Library\\Event::clear' => TRUE
            ],
            'profile:deleted' => [
                'SiteProfile\\Library\\Event::clear' => TRUE
            ],
            'profile:updated' => [
                'SiteProfile\\Library\\Event::clear' => TRUE
            ]
        ]
    ],
    'site' => [
        'robot' => [
            'feed' => [
                'SiteProfile\\Library\\Robot::feed' => TRUE
            ],
            'sitemap' => [
                'SiteProfile\\Library\\Robot::sitemap' => TRUE
            ]
        ]
    ]
];
