@extends("layout")

@section("content")


    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="img/screenshot.png" class="img-responsive" width="300" alt="{{ $site_name }}">

                </div>
                <div class="col-md-8">

                    <h2 class="text-primary">Make everything at once</h2>
                    <h3>Simplify your way to publish photos from the photostream</h3>
                    <p>Schedule when you want to make your photos public just following the steps:</p>

                    <ol>
                        <li>Upload all your photos as private and tag them in your <a href="http://www.flickr.com" rel="nofollow" target="_blank">Flickr</a> account</li>
                        <li>Sign in to <a href="{{ url('/') }}">{{ $site_name }}</a> using Flickr</li>
                        <li>Select the photos and when your followers will see them, then press Publish!</li>
                    </ol>
                    <p><strong>Your photos will appear as posted at that moment.</strong></p>

                    <p>AVOID the frequent sign in to Flickr in order to make your photos public for your followers.</p>


                </div>

            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <h2 class="text-primary">Add to Groups automatically</h2>
                    <h3>Boost your audience</h3>
                    <p>For a greater impact and making everything more simple, you can select groups where your photos will be added immediately after they became public.</p>

                    <p>Before hitting Publish button, press on the <strong>Add to Groups</strong> and a pop-up with your subscribed groups will be opened, just like in the right image .</p>

                    <p>Select the appropriate groups for the photos previously selected, then press the <strong>Save Changes</strong> button.
                </div>
                <div class="col-md-6">
                    <img src="img/groups.png" width="500" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
    @endsection