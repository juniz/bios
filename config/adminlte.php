<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => env('APP_NAME', 'Laravel'),
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>RSB</b> Makassar',
    'logo_img' => 'assets/img/logo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'RSB Makaasar Logo',

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'assets/img/logo.png',
            'alt' => 'RSB Nganjuk Preloader Image',
            'effect' => 'animation_wobble',
            'width' => 100,
            'height' => 100,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
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
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
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
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        // [
        //     'type'         => 'navbar-search',
        //     'text'         => 'search',
        //     'topnav_right' => true,
        // ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'Dashboard',
            'icon' => 'fas fa-fw fa-home',
            'url' => '/dashboard'
        ],
        [
            'text'    => 'SDM',
            'icon'    => 'fas fa-fw fa-user-md',
            'submenu' => [
                [
                    'text' => 'Perawat',
                    'url'  => '/sdm/perawat',
                ],
                [
                    'text' => 'Bidan',
                    'url'  => '/sdm/bidan',
                ],
                [
                    'text' => 'Laboratorium',
                    'url'  => '/sdm/laboratorium',
                ],
                [
                    'text' => 'Radiographer',
                    'url'  => '/sdm/radiographer',
                ],
                [
                    'text' => 'Nutritionist',
                    'url'  => '/sdm/nutritionist',
                ],
                [
                    'text' => 'Pharmacist',
                    'url'  => '/sdm/pharmacist',
                ],
                [
                    'text' => 'Professional Lainnya',
                    'url'  => '/sdm/profesionallainnya',
                ],
                [
                    'text' => 'Non Medis',
                    'url'  => '/sdm/nonmedis',
                ],
                [
                    'text' => 'Sanitarian',
                    'url'  => '/sdm/sanitarian',
                ],
                [
                    'text' => 'Non-Medis Administrasi',
                    'url'  => '/sdm/administrasi',
                ],
                [
                    'text' => 'Dokter Spesialis',
                    'url'  => '/sdm/spesialis',
                ],
                [
                    'text' => 'Dokter Gigi',
                    'url'  => '/sdm/doktergigi',
                ],
                [
                    'text' => 'Dokter Umum',
                    'url'  => '/sdm/dokterumum',
                ],
            ],
        ],
        [
            'text'    => 'Layanan',
            'icon'    => 'fas fa-fw fa-medkit',
            'submenu' => [
                [
                    'text' => 'Indeks Kepuasan Masyarakat (IKM)',
                    'url'  => '/layanan/ikm',
                ],
                [
                    'text' => 'Layanan Laboratorium (sampel)',
                    'url'  => '/layanan/laboratoriumsampel',
                ],
                [
                    'text' => 'Layanan Farmasi',
                    'url'  => '/layanan/farmasi',
                ],
                [
                    'text' => 'BOR (Bed Occupancy Ratio)',
                    'url'  => '/layanan/bor',
                ],
                [
                    'text' => 'TOI (Turn Over Interval)',
                    'url'  => '/layanan/toi',
                ],
                [
                    'text' => 'ALOS (Average Length of Stay)',
                    'url'  => '/layanan/alos',
                ],
                [
                    'text' => 'BTO (Bed Turn Over)',
                    'url'  => '/layanan/bto',
                ],
                [
                    'text' => 'Layanan Laboratorium (parameter)',
                    'url'  => '/layanan/laboratoriumparameter',
                ],
                [
                    'text' => 'Pasien Rawat Darurat',
                    'url'  => '/layanan/igd',
                ],
                [
                    'text' => 'Tindakan Operasi',
                    'url'  => '/layanan/operasi',
                ],
                [
                    'text' => 'Layanan Radiologi',
                    'url'  => '/layanan/radiologi',
                ],
                [
                    'text' => 'Layanan Forensik',
                    'url'  => '/layanan/forensik',
                ],
                [
                    'text' => 'Kunjungan Rawat Jalan',
                    'url'  => '/layanan/ralan',
                ],
                [
                    'text' => 'Pasien Rawat Inap',
                    'url'  => '/layanan/ranap',
                ],
                [
                    'text' => 'Pasien BPJS / Non-BPJS',
                    'url'  => '/layanan/bpjs_non_bpjs',
                ],
                [
                    'text' => 'Pasien Rawat Jalan/Poli',
                    'url'  => '/layanan/poli',
                ],
                [
                    'text' => 'Pelayanan Dokpol',
                    'url'  => '/layanan/dokpol',
                ],
            ],
        ],
        [
            'text'    => 'Keuangan',
            'icon'    => 'fas fa-fw fa-dollar-sign',
            'submenu' => [
                [
                    'text' => 'Operasional',
                    'url'  => '/keuangan/operasional',
                ],
                [
                    'text' => 'Pengelolaan Kas',
                    'url'  => '/keuangan/kas',
                ],
                [
                    'text' => 'Dana Kelolaan',
                    'url'  => '/keuangan/kelolaan',
                ],
                [
                    'text' => 'Penerimaan',
                    'url'  => '/keuangan/penerimaan',
                ],
                [
                    'text' => 'Pengeluaran',
                    'url'  => '/keuangan/pengeluaran',
                ],
            ],
        ],
        [
            'text'    => 'IKT',
            'icon'    => 'fas fa-fw fa-chart-pie',
            'submenu' => [
                [
                    'text' => 'Visite Pasien <= Jam 10.00',
                    'url'  => '/ikt/visite1',
                ],
                [
                    'text' => 'Visite Pasien > 10.00 s.d. 12.00',
                    'url'  => '/ikt/visite2',
                ],
                [
                    'text' => 'Visite Pasien > 12.00',
                    'url'  => '/ikt/visite3',
                ],
                [
                    'text' => 'Rasio POBO',
                    'url'  => '/ikt/pobo',
                ],
                [
                    'text' => 'Kegiatan Visite Pasien Pertama',
                    'url'  => '/ikt/visite_pertama',
                ],
                [
                    'text' => 'DPJP tidak visite',
                    'url'  => '/ikt/dpjp_non_visite',
                ],
                [
                    'text' => 'Kepuasan Pasien',
                    'url'  => '/ikt/kepuasan_pasien',
                ],
                [
                    'text' => 'Waktu Tunggu Rawat Jalan',
                    'url'  => '/ikt/waktu_tunggu_ralan',
                ],
                [
                    'text' => 'Penyelenggaran Rekam Medis Elektronik',
                    'url'  => '/ikt/penyelenggaraan_erm',
                ],
                [
                    'text' => 'Kepatuhan Penggunaan Alat Pelindung Diri (APD)',
                    'url'  => '/ikt/kepatuhan_penggunaan_apd',
                ],
                [
                    'text' => 'Penundaan Operasi Elektif',
                    'url'  => '/ikt/penundaan_operasi_elektif',
                ],
                [
                    'text' => 'Kepatuhan Terhadap Alur Klinis (Clinical Pathway)',
                    'url'  => '/ikt/kepatuhan_clinical_pathway',
                ],
                [
                    'text' => 'Kepatuhan Kebersihan Tangan',
                    'url'  => '/ikt/kepatuhan_kebersihan_tangan',
                ],
                [
                    'text' => 'Kepatuhan Penggunaan Formularium Nasional',
                    'url'  => '/ikt/kepatuhan_penggunaan_fornas',
                ],
                [
                    'text' => 'Kepatuhan Waktu Visite Dokter Penanggung Jawab Pelayanan/DPJP',
                    'url'  => '/ikt/kepatuhan_waktu_visite_dpjp',
                ],
                [
                    'text' => 'Kepatuhan Pelaksanaan Protokol Kesehatan',
                    'url'  => '/ikt/kepatuhan_pelaksanaan_prokes',
                ],
                [
                    'text' => 'Persentase Pembelian Alat Kesehatan Produksi Dalam Negeri',
                    'url'  => '/ikt/pembelian_alkes_dalam_negeri',
                ],
                [
                    'text' => 'Kepatuhan Identifikasi Pasien',
                    'url'  => '/ikt/kepatuhan_identifikasi_pasien',
                ],
                [
                    'text' => 'Kepatuhan Waktu Visite Dokter',
                    'url'  => '/ikt/kepatuhan_waktu_visite_dokter',
                ],
                [
                    'text' => 'Kecepatan Waktu Tanggap Komplain',
                    'url'  => '/ikt/kecepatan_waktu_tunggu_komplain',
                ],
                [
                    'text' => 'Pelaporan Hasil Kritis Laboratorium',
                    'url'  => '/ikt/pelaporan_hasil_kritis_laboratorium',
                ],
                [
                    'text' => 'Waktu Tanggap Operasi Seksio Sesarea Emergensi',
                    'url'  => '/ikt/waktu_tanggap_operasi_seksio_sesarea',
                ],
                [
                    'text' => 'Kepatuhan Upaya Pencegahan Resiko Pasien Jatuh',
                    'url'  => '/ikt/kepatuhan_upaya_pencegahan_risiko_pasien_jatuh',
                ],
                [
                    'text' => 'Pertumbuhan Realisasi Pendapatan dari Pengelolaan Aset BLU',
                    'url'  => '/ikt/pertumbuhan_realisasi_pendapatan_pengelolaan_aset_blu',
                ],
            ],
        ],
        [
            'text'    => 'Monitoring',
            'icon'    => 'fas fa-fw fa-server',
            'submenu' => [
                [
                    'text' => 'Scheduler',
                    'url'  => '/monitoring/scheduler',
                ]
            ],
        ],
        [
            'text' => 'Keluar',
            'icon' => 'far fa-fw fa-arrow-right',
            'url' => '/logout'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
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
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.bundle.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js',
                ],
            ],
        ],
        'ApexChart' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/apexcharts',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'TempusDominusBs4' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true,
];
