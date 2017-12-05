<html lang="en">
<head>
    <title>{{ $site_name }} @if (isset($menu)): - {{ $menu }}@endif</title>
    <meta name="description"
          content="Upload your photos as private, make them public when you want! Simplify your way to publish photos from the photostream.">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="{{url('/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}"/>
</head>
<body>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
@if (isset($auth))

    <div class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}"><span>{{ $site_name }}</span></a>
            </div>
            <!--<form method="post" id="frmLogout">-->
            <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://www.flickr.com" rel="nofollow" target="_blank">Back to Flickr</a></li>
                    <li @if ($menu == 'home') class="active" @endif>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li @if ($menu == 'contact')class="active"@endif>
                        <a href="{{ url('/contact#contact') }}">Contact</a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}" ><i class="fa fa-fw fa-sign-out"></i>Logout</a>
                        <input type="hidden" name="action" value="logout" />
                    </li>
                </ul>
            </div>
            <!--</form>-->
        </div>
    </div>
@else
<div class="cover">
    <div class="navbar">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}" target="_blank"><span>{{ $site_name }}</span></a>

            </div>
            <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="navbar-brand" href="http://www.flickr.com" target="_blank"
                           rel="nofollow"><span>Flickr</span></a></li>
                    <li class="active">
                        <a href="{{ url('/contact#contact') }}">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="cover-image" style="background-image: url('{{ asset('img/cover.jpg') }}')"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-inverse">{{ $site_name }}</h1>
                <p class="text-inverse">Upload now, publish when you want!</p>
                <br>
                <br>
                <a class="btn btn-lg btn-primary" href="{{ url('/auth') }}"><i class="fa fa-fw fa-sign-in"></i>Login
                    using Flickr</a>
            </div>
        </div>
    </div>
</div>

@endif

@yield("content")

<footer class="section section-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 text-left">
                <h2>
                    <a href="{{ url('/contact.php#contact') }}" class="text-inverse">
                        Give Us Your Feedback
                    </a>
                    <i class="fa fa-fw fa-comment"></i></h2>
                <p>Help us improving the application by letting us know about your suggestions or feature requests,
                    issues discovered while using it.</p>

                <p class="text-info">
                    <a href="{{ url('/faq#faq') }}" class="text-inverse">FAQ</a>
                    <a href="{{ url('/terms#terms') }}" class="text-inverse">Privacy Policy</a>

                </p>


            </div>
            <div class="col-sm-6 text-right">
                <h2>
                    <a href="https://github.com/vicxyz1/publishr-online" class="text-inverse">
                        Follow us on Github <i class="fa  fa-fw fa-github text-inverse"></i>
                    </a>
                </h2>

                <p>Full Open Source code based on Flickr API using OAuth</p>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-74726680-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>