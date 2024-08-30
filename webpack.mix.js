let mix = require('laravel-mix');

mix
    .sass('resources/scss/panel/app.scss', 'public/panel/css/app.css')
    .styles([
        'resources/css/panel/modules/bootstrap/css/bootstrap.min.css',
        'resources/css/panel/modules/jqvmap/dist/jqvmap.min.css',
        'resources/css/panel/modules/weather-icon/css/weather-icons.min.css',
        'resources/css/panel/modules/weather-icon/css/weather-icons-wind.min.css',
        'resources/css/panel/modules/summernote/summernote-bs4.css',
        'resources/css/panel/css/dark.css',
        'resources/css/panel/css/style.css',
        'resources/css/panel/css/components.css',
    ], 'public/panel/css/all.css')

    .scripts([
        'resources/css/panel/modules/jquery.min.js',
        'resources/css/panel/modules/popper.js',
        'resources/css/panel/modules/tooltip.js',
        'resources/css/panel/modules/bootstrap/js/bootstrap.min.js',
        'resources/css/panel/modules/nicescroll/jquery.nicescroll.min.js',
        'resources/css/panel/modules/moment.min.js',
        'resources/js/panel/stisla.js',
        'node_modules/sweetalert2/dist/sweetalert2.all.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'resources/css/panel/modules/simple-weather/jquery.simpleWeather.min.js',
        'resources/css/panel/modules/chart.min.js',
        'resources/css/panel/modules/jqvmap/dist/jquery.vmap.min.js',
        'resources/css/panel/modules/jqvmap/dist/maps/jquery.vmap.world.js',
        'resources/css/panel/modules/summernote/summernote-bs4.js',
        'resources/css/panel/modules/chocolat/dist/js/jquery.chocolat.min.js',
        'resources/js/panel/page/index-0.js',
        'resources/js/panel/scripts.js',
        'resources/js/panel/custom.js',
        'resources/js/panel/checkout.js'
    ], 'public/panel/js/scripts.js')

    .copyDirectory('resources/fonts', 'public/panel/fonts')
    .copyDirectory('resources/img/panel', 'public/panel/img')

    // Dashboard
    .sass('resources/scss/dashboard/app.scss', 'public/dashboard/css/app.css')
    .styles([
        'resources/css/dashboard/modules/bootstrap/css/bootstrap.min.css',
        'resources/css/dashboard/modules/jqvmap/dist/jqvmap.min.css',
        'resources/css/dashboard/modules/weather-icon/css/weather-icons.min.css',
        'resources/css/dashboard/modules/weather-icon/css/weather-icons-wind.min.css',
        'resources/css/dashboard/modules/summernote/summernote-bs4.css',
        'resources/css/dashboard/css/style.css',
        'resources/css/dashboard/css/components.css',
    ], 'public/dashboard/css/all.css')

    .scripts([
        'resources/css/dashboard/modules/jquery.min.js',
        'resources/css/dashboard/modules/popper.js',
        'resources/css/dashboard/modules/tooltip.js',
        'resources/css/dashboard/modules/bootstrap/js/bootstrap.min.js',
        'resources/css/dashboard/modules/nicescroll/jquery.nicescroll.min.js',
        'resources/css/dashboard/modules/moment.min.js',
        'resources/js/dashboard/stisla.js',
        'node_modules/sweetalert2/dist/sweetalert2.all.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'resources/css/dashboard/modules/simple-weather/jquery.simpleWeather.min.js',
        'resources/css/dashboard/modules/chart.min.js',
        'resources/css/dashboard/modules/jqvmap/dist/jquery.vmap.min.js',
        'resources/css/dashboard/modules/jqvmap/dist/maps/jquery.vmap.world.js',
        'resources/css/dashboard/modules/summernote/summernote-bs4.js',
        'resources/css/dashboard/modules/chocolat/dist/js/jquery.chocolat.min.js',
        'resources/js/dashboard/page/index-0.js',
        'resources/js/dashboard/scripts.js',
        'resources/js/dashboard/custom.js',
        'resources/js/dashboard/jquery-ui.js',
    ], 'public/dashboard/js/scripts.js')

    .copyDirectory('resources/fonts', 'public/dashboard/fonts')
    .copyDirectory('resources/img/dashboard', 'public/dashboard/img')

    // Web
    .sass('resources/scss/web/app.scss', 'public/web/css/app.css')
    .styles([
        'resources/css/web/flaticon.css',
        'resources/css/web/magnific-popup.css',
        'resources/css/web/nice-select.css',
        'resources/css/web/bootstrap.min.css',
        'resources/css/web/swiper.min.css',
        'resources/css/web/odometer.css',
        'resources/css/web/themify.css',
        'resources/css/web/animate.css',
        'resources/css/web/jquery.animatedheadline.css',
        'resources/css/web/style.css',
        'resources/css/web/custom.css',
        'resources/css/web/bootstrap-fileinput.css',
        'resources/css/web/color.css',
    ], 'public/web/css/all.css')

    .scripts([
        'resources/js/web/jquery-3.6.0.min.js',
        'resources/js/web/jquery-migrate-3.0.0.js',
        'resources/js/web/bootstrap.min.js',
        'resources/js/web/jquery.magnific-popup.js',
        'resources/js/web/jquery.nice-select.js',
        'resources/js/web/swiper.min.js',
        'resources/js/web/plugin.js',
        'resources/js/web/chart.js',
        'resources/js/web/viewport.jquery.js',
        'resources/js/web/odometer.min.js',
        'resources/js/web/wow.min.js',
        'resources/js/web/main.js',
    ], 'public/web/js/scripts.js')

    .copyDirectory('resources/img/web', 'public/web/img')

    .version()
    .disableNotifications()
