<html>
    <head>
        <title><?= $this->site_name ?> - <?= ucwords($this->menu) ?></title>
        <meta name="description" content="Upload your photos as private, make them public when you want! Simplify your way to publish photos from the photostream.<?= ucwords($this->menu) ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="//pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
		
    </head>
    <body>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= $this->base_url ?>"><span><?= $this->site_name ?></span></a>
                </div>
                <!--<form method="post" id="frmLogout">-->
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://www.flickr.com" rel="nofollow" target="_blank">Back to Flickr</a></li>
                        <li <?php if ($this->menu == 'home'): ?>class="active"<?php endif; ?>>
                            <a href="index.php">Home</a>
                        </li>
                        <li <?php if ($this->menu == 'contact'): ?>class="active"<?php endif; ?>>
                            <a href="contact.php#contact">Contact</a>
                        </li>
                        <li>
                            <a href="index.php?logout=1" ><i class="fa fa-fw fa-sign-out"></i>Logout</a>
                            <input type="hidden" name="action" value="logout" />
                        </li>
                    </ul>
                </div>
                <!--</form>-->
            </div>
        </div>
        <?php $this->display($this->tpl) ?>
        <!--FOOTER-->
        <footer class="section section-primary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>
                            <a href="contact.php#contact" class="text-inverse">
                                Give Us Your Feedback
                            </a>
                            <i class="fa fa-fw fa-comment"></i></h2>
                        <p>Help us improving the application by letting us know about your suggestions or feature requests, issues discovered while using it.</p>
                        <p><a href="faq.php#faq" class="text-inverse">FAQ</a> 
                            <a href="terms.php" class="text-inverse">Privacy Policy</a></p>
                        <p class="">This product uses the Flickr API but is not endorsed or certified by Flickr.</p>

                    </div>
                    <div class="col-sm-6">

                        <div class="row">
                            <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                                <h3>
                                    <a href="contact.php#contact" class="text-inverse">
                                        Buy me a beer
                                    </a>
                                    <i class="fa fa-fw fa-beer "></i></h3>
                                <p>If you like and you want to support the development</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 hidden-xs text-right"> 

                                <h2>
                                    Buy me a beer
                                    <i class="fa fa-fw fa-beer "></i></h2>
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="9LKG64GTJF99U">
                                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>

                                <p>If you like the app and you want to support the development</p>

                            </div>
                        </div>
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