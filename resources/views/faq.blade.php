@extends("layout")

@section("content")
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a name="faq"></a><h1 class="text-primary">Frequent Answered Questions</h1>
                <p>The website should be simple to use, but here are some answers to questions you may have:</p>

                <h3>Is this application FREE of charge?</h3>
                <p>YES, it is totally free to use. But, if you like the application, the donation will support the hosting and future development.
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="9LKG64GTJF99U">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
                </p>
                <h3>Does it save or cache my private photos ?</h3>
                <p><strong>NO</strong>. All your photos are yours and displayed directly from your Flickr account. Please check our <a href="{{ url('/terms#privacy') }}">Privacy Policy</a>.
                <h3>I see only a part of my private photos, why?</h3>
                <p>The Flickr limits the requests to 300 photos per response, so right now, you'll only the latest 300 private photos from your account.<br/>
                    Future development of the application may support unlimited private photos.
                </p>
                <h3>I have scheduled several photos for the same day, but not all of them became public, why?</h3>
                <p>Most probably, you have scheduled the remaining photos to a different time (hour:minute). For convenience, the scheduled photos are grouped by day, also we recommend planning the photos publication by day as some groups have limits per day.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection