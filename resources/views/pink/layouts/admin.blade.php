<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<!-- START HEAD -->
<head>

    <meta charset="UTF-8"/>
    <!-- this line will appear only if the website is visited with an iPad -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=yes"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- [favicon] begin -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(env('THEME')) }}/images/favicon.ico"/>
    <link rel="icon" type="image/x-icon" href="{{ asset(env('THEME')) }}/images/favicon.ico"/>
    <!-- Touch icons more info: http://mathiasbynens.be/notes/touch-icons -->
    <!-- For iPad3 with retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ asset(env('THEME')) }}/apple-touch-icon-144x.png"/>
    <!-- For first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{ asset(env('THEME')) }}/apple-touch-icon-114x.png"/>
    <!-- For first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset(env('THEME')) }}/apple-touch-icon-72x.png"/>
    <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset(env('THEME')) }}/apple-touch-icon-57x.png"/>
    <!-- [favicon] end -->

    <!-- CSSs -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(env('THEME')) }}/css/reset.css"/>
    <!-- RESET STYLESHEET -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(env('THEME')) }}/style.css"/>
    <!-- MAIN THEME STYLESHEET -->
    <link rel="stylesheet" id="max-width-1024-css" href="{{ asset(env('THEME')) }}/css/max-width-1024.css"
          type="text/css" media="screen and (max-width: 1240px)"/>
    <link rel="stylesheet" id="max-width-768-css" href="{{ asset(env('THEME')) }}/css/max-width-768.css" type="text/css"
          media="screen and (max-width: 987px)"/>
    <link rel="stylesheet" id="max-width-480-css" href="{{ asset(env('THEME')) }}/css/max-width-480.css" type="text/css"
          media="screen and (max-width: 480px)"/>
    <link rel="stylesheet" id="max-width-320-css" href="{{ asset(env('THEME')) }}/css/max-width-320.css" type="text/css"
          media="screen and (max-width: 320px)"/>

    <!-- CSSs Plugin -->
    <link rel="stylesheet" id="thickbox-css" href="{{ asset(env('THEME')) }}/css/thickbox.css" type="text/css"
          media="all"/>
    <link rel="stylesheet" id="styles-minified-css" href="{{ asset(env('THEME')) }}/css/style-minifield.css"
          type="text/css" media="all"/>
    <link rel="stylesheet" id="buttons" href="{{ asset(env('THEME')) }}/css/buttons.css" type="text/css" media="all"/>
    <link rel="stylesheet" id="cache-custom-css" href="{{ asset(env('THEME')) }}/css/cache-custom.css" type="text/css"
          media="all"/>
    <link rel="stylesheet" id="custom-css" href="{{ asset(env('THEME')) }}/css/custom.css" type="text/css" media="all"/>

    <!-- FONTs -->
    <link rel="stylesheet" id="google-fonts-css"
          href="http://fonts.googleapis.com/css?family=Oswald%7CDroid+Sans%7CPlayfair+Display%7COpen+Sans+Condensed%3A300%7CRokkitt%7CShadows+Into+Light%7CAbel%7CDamion%7CMontez&amp;ver=3.4.2"
          type="text/css" media="all"/>
    <link rel='stylesheet' href='{{ asset(env('THEME')) }}/css/font-awesome.css' type='text/css' media='all'/>

    <!-- JAVASCRIPTs -->
    <script ENGINE="text/javascript" src="{{ asset(env('THEME')) }}/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="{{ asset(env('THEME')) }}/js/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="{{ asset(env('THEME')) }}/js/ckeditor.js"></script>


</head>
<!-- END HEAD -->

<!-- START BODY -->
<body
    class="no_js responsive {{ (\Illuminate\Support\Facades\Route::currentRouteName() == "home") }} stretched">

<!-- START BG SHADOW -->
<div class="bg-shadow">

    <!-- START WRAPPER -->
    <div id="wrapper" class="group">

        <!-- START HEADER -->
        <div id="header" class="group">

            <div class="group inner">

                <!-- START LOGO -->
                <div id="logo" class="group">
                    <a href="index.html" title="Pink Rio"><img src="{{ asset(env('THEME')) }}/images/logo.png"
                                                               title="Pink Rio" alt="Pink Rio"/></a>
                </div>
                <!-- END LOGO -->

                <div id="sidebar-header" class="group">
                    <div class="widget-first widget yit_text_quote">
                        <blockquote class="text-quote-quote">&#8220;The caterpillar does all the work but the butterfly
                            gets all the publicity.&#8221;
                        </blockquote>
                        <cite class="text-quote-author">George Carlin</cite>
                    </div>
                </div>
                <div class="clearer"></div>

                <hr/>

                <!-- START MAIN NAVIGATION -->
            @yield('navigation')
            <!-- END MAIN NAVIGATION -->
                <div id="header-shadow"></div>
                <div id="menu-shadow"></div>
            </div>

        </div>
        <!-- END HEADER -->

        <div class="wrap_result">

        </div>
        <!-- START PAGE META -->
        @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'portfolios.index')
            <div id="page-meta">
                <div class="inner group">
                    <h3>Welcome to my portfolio page</h3>
                    <h4>... i hope you enjoy my works</h4>
                </div>
            </div>
        @endif
    <!-- END PAGE META -->

        <!-- START PAGE META -->
        @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'contacts')
            <div id="page-meta">
                <div class="inner group">
                    <h3>...Say Hello! :)</h3>
                    <h4>Get in touch with Pink Rio team</h4>
                </div>
            </div>
    @endif
    <!-- END PAGE META -->
        <!-- START PRIMARY -->
        <div id="primary" class="sidebar-{{ isset($bar) ? $bar : 'no'}}">
            <div class="inner group">
                <!-- START CONTENT -->
            @yield('content')
            <!-- END CONTENT -->
                <!-- START SIDEBAR -->
            </div>
        </div>
        <!-- END PRIMARY -->

        <!-- START COPYRIGHT -->
    @yield('footer')
    <!-- END COPYRIGHT -->
    </div>
    <!-- END WRAPPER -->
</div>
<!-- END BG SHADOW -->

</body>
<!-- END BODY -->
</html>
