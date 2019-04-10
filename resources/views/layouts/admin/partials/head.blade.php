<!DOCTYPE html><!-- 

<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />

        @yield('seo-title')

        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="/css/fonts.css" rel="stylesheet" type="text/css"/>
        <!--begin::Base Styles -->
        <link href="/templates/metronic/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/templates/metronic/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

        <!--end::Base Styles -->

        <link rel="apple-touch-icon" sizes="180x180" href="/templates/metronic/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/templates/metronic/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/templates/metronic/favicon/favicon-16x16.png">
        <link rel="manifest" href="/templates/metronic/favicon/manifest.json">
        <link rel="mask-icon" href="/templates/metronic/favicon/mask-icon.svg" color="#">
        <meta name="msapplication-TileColor" content="#">
        <meta name="msapplication-TileImage" content="/templates/metronic/favicon/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="shortcut icon" href="https://threedium.co.uk/assets/img/logo.svg" />
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
                WebFont.load({
                google: {
                    "families":[
                        "Poppins:300,400,500,600,700",
                        "Roboto:300,400,500,600,700"
                    ]
                },
                active: function() {
                    sessionStorage.fonts = true;
                }
                });
        </script>
        <script src="/fonts/main.js"></script>
        <!--end::Web font -->
        @stack('page-css')
    </head>
    <!-- end::Head -->
    <!-- begin::Body -->
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">        
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">