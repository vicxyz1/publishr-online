@extends("layout")

@section("content")

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-left"> Statistics!
                        <small>check performance</small>
                    </h1>
                    <p class="lead text-left"> Most viewed photos</p>
                </div>
            </div>

            <div class="row">
                @foreach ($photos as $i=>$photo)

                    <div class="col-xs-6 col-md-2">
                        <div class="thumbnail">
                            <img src="{{ $photo['url_q'] }}" alt="{{ $photo['title'] }}">
                            <div class="caption">
                                <h3>{{ $photo['title'] }}</h3>
                                <p>{{  $photo['views'] }} views</p>

                            </div>
                        </div>
                    </div>
                    @if ($i%6 == 5)</div>
            <div class="row">@endif
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Total views: {{ $total }}</h3>
                </div>

            </div>
        </div>

    </div>
@endsection