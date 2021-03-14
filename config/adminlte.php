<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'Sparteoli',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>Sparteoli',
    'logo_img' => 'img/logo-insignia.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Sparteoli',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-danger',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-danger',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-danger',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => 'font-weight-normal',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-danger elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-danger navbar-dark text-bold',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-dark',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'danger',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-dark',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => false,

    'password_reset_url' => false,

    'password_email_url' => false,

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        # [
        #    'text' => 'search',
        #    'search' => true,
        #    'topnav' => true,
        #],
        ['header' => 'main_navigation'],
        # [
        #    'text' => 'blog',
        #    'url'  => 'admin/blog',
        #    'can'  => 'manage-blog',
        #],
        [
            'text'        => 'Dashboard',
            'url'         => '/home',
            'icon'        => 'fas fa-fw fa-home',
        ],
        [
            'text'        => 'Ocorrências',
            'url'         => '/occurrence',
            'icon'        => 'fas fa-fw fa-file',
            #'label'       => 4,
            'label_color' => 'success',
        ],
        ['header' => 'Configurações de perfil'],
        [
            'text' => 'Perfil',
            'url'  => 'profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'change_password',
            'url'  => 'profile/password',
            'icon' => 'fas fa-fw fa-lock',
        ],
        ['header' => 'Outros'],
        [
            'text'    => 'Pré-definidos',
            'icon'    => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'Naturezas de ocorrência',
                    'icon' => 'fas fa-fw fa-book',
                    'submenu' => [
                        [
                            'text' => 'Listar',
                            'url'  => 'nature',
                            'icon' => 'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'Criar',
                            'url' => 'nature/create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'admin',
                        ],
                        [
                            'text'    => 'Tipos de ocorrência',
                            'icon' => 'fas fa-fw fa-arrow-down',
                            'submenu' => [
                                [
                                    'text' => 'Listar',
                                    'url'  => 'type',
                                    'icon' => 'fas fa-fw fa-list'
                                ],
                                [
                                    'text' => 'Criar',
                                    'url' => 'type/create',
                                    'icon' => 'fas fa-fw fa-plus',
                                    'can' => 'admin',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Incêndio',
                    'icon' => 'fas fa-fw fa-fire',
                    'submenu' => [
                        [
                            'text' => 'Sistemas de proteção',
                            'icon' => 'fas fa-fw fa-exclamation-triangle',
                            'submenu' => [
                                [
                                    'text' => 'Listar',
                                    'url'  => 'fireprotection',
                                    'icon' => 'fas fa-fw fa-list'
                                ],
                                [
                                    'text' => 'Criar',
                                    'url' => 'fireprotection/create',
                                    'icon' => 'fas fa-fw fa-plus',
                                    'can' => 'admin',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'Ocorrência',
                    'icon' => 'fas fa-fw fa-file',
                    'submenu' => [
                        [
                            'text' => 'Atendimento a vítimas',
                            'icon' => 'fas fa-fw fa-heart',
                            'submenu' => [
                                [
                                    'text' => 'Tipos de socorristas',
                                    'icon' => 'fas fa-fw fa-edit',
                                    'submenu' => [
                                        [
                                            'text' => 'Listar',
                                            'url'  => 'rescuer',
                                            'icon' => 'fas fa-fw fa-list'
                                        ],
                                        [
                                            'text' => 'Criar',
                                            'url' => 'rescuer/create',
                                            'icon' => 'fas fa-fw fa-plus',
                                            'can' => 'admin',
                                        ],
                                    ],
                                ],
                                [
                                    'text' => 'Tipos de problemas',
                                    'icon' => 'fas fa-fw fa-tint',
                                    'submenu' => [
                                        [
                                            'text' => 'Listar',
                                            'url'  => 'problem',
                                            'icon' => 'fas fa-fw fa-list'
                                        ],
                                        [
                                            'text' => 'Criar',
                                            'url' => 'problem/create',
                                            'icon' => 'fas fa-fw fa-plus',
                                            'can' => 'admin',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'text' => 'Características do local',
                            'icon' => 'fas fa-fw fa-edit',
                            'submenu' => [
                                [
                                    'text' => 'Listar',
                                    'url'  => 'placefreature',
                                    'icon' => 'fas fa-fw fa-list'
                                ],
                                [
                                    'text' => 'Criar',
                                    'url' => 'placefreature/create',
                                    'icon' => 'fas fa-fw fa-plus',
                                    'can' => 'admin',
                                ],
                            ],
                        ],
                        [
                            'text' => 'Usos do local',
                            'icon' => 'fas fa-fw fa-edit',
                            'submenu' => [
                                [
                                    'text' => 'Listar',
                                    'url'  => 'placeuse',
                                    'icon' => 'fas fa-fw fa-list'
                                ],
                                [
                                    'text' => 'Criar',
                                    'url' => 'placeuse/create',
                                    'icon' => 'fas fa-fw fa-plus',
                                    'can' => 'admin',
                                ],
                            ],
                        ],
                        [
                            'text' => 'Meios de chamado',
                            'icon' => 'fas fa-fw fa-phone',
                            'submenu' => [
                                [
                                    'text' => 'Listar',
                                    'url'  => 'meanused',
                                    'icon' => 'fas fa-fw fa-list'
                                ],
                                [
                                    'text' => 'Criar',
                                    'url' => 'meanused/create',
                                    'icon' => 'fas fa-fw fa-plus',
                                    'can' => 'admin',
                                ],
                            ],
                        ],
                        [
                            'text' => 'Utilização do local',
                            'icon' => 'fas fa-fw fa-briefcase',
                            'submenu' => [
                                [
                                    'text' => 'Listar',
                                    'url'  => 'placeuse',
                                    'icon' => 'fas fa-fw fa-list'
                                ],
                                [
                                    'text' => 'Criar',
                                    'url' => 'placeuse/create',
                                    'icon' => 'fas fa-fw fa-plus',
                                    'can' => 'admin',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        [
            'text' => 'Usuários',
            'icon' => 'fas fa-user',
            'can' => 'admin',
            'submenu' => [
                [
                    'text' => 'Listar',
                    'url'  => 'user',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Adicionar',
                    'url' => 'register',
                    'icon' => 'fas fa-fw fa-plus',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        //JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue
                    /pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
