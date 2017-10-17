@extends("layout")

@section("content")
    <!--<script src="js/jquery.datetimepicker.full.min.js" /></script>-->
    <style>
        @import url('css/image-picker.css');
        @import url('css/bootstrap-datetimepicker.min.css');
        @import url('css/ekko-lightbox.min.css');
        /*    @import url('css/bootstrap-responsive.min.css');*/

        #setGroups img {
            width: 48px
        }


    </style>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-left">Unpublished Photos</h1>
                    <p class="lead text-left">select photos you want to publish later</p>
                </div>
            </div>
            @if (Session::has('err1_msg'))

                <div class="alert alert-dismissable alert-danger">{{ session('err1_msg') }}</div>

            @endif
            @if (count($unpublished))
                <form id="frmUnpublished" method="post" data-toggle="validator"/>
                <div class="form-group">
                    <select multiple="multiple" class="image-picker show-html " name="photos[]" required>
                        @foreach ($unpublished as $photo)
                            <option data-img-src="{{ $photo['url_q'] }} " value=" {{ $photo['id']  }}"
                                    data-img-label='<a data-toggle="lightbox" href="{{ $photo['url_z']  }}">{{ $photo['title']  }}</a>'>
                                <a href="{{ $photo['url_o']  }}">{{ $photo['title']  }}</a></option>
                        @endforeach
                    </select>
                </div>
                <div class="container">
                    <div class="row">
                        <div id="upaginator" class="col-md-12 text-center"></div>
                    </div>
                </div>
        </div>
        <div class="container">
            <div class="row">
                <div class='col-md-6'>
                    <div class="form-group">
                        <label for="datetimepicker1" class="control-label"> Select when you make the photos
                            public</label>
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="pub_time" type='text' class="form-control" required/>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="setGroups" class=" fade modal ">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Add to Groups</h4>
                    </div>
                    <div class="modal-body">
                        <p contenteditable="true">Click on the group to add after publishing:</p>

                        <select id="groups" multiple="multiple" class="image-picker show-html " name="groups[]"
                                required>
                            @if (count($groups)):
                            @foreach ($groups as $id => $group):
                            {{ $src = !$group['iconfarm'] ? 'https://s.yimg.com/pw/images/buddyicon03_r.png' : "http://farm{$group['iconfarm']}.staticflickr.com/{$group['iconserver']}/buddyicons/{$group['nsid']}.jpg" }}
                            <option width=48 data-img-src="{{ $src }}"
                                    value="{{ $group['id'] }}"> {{$group['name'] }}</option>
                            @endforeach
                            @endif
                        </select>


                    </div>
                    <div class="modal-footer"><a id="btnGroups" class="btn btn-primary" data-dismiss="modal">Save
                            changes</a></div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">

                    <div class="col-md-12r text-center">
                        <a class="btn btn-default btn-lg" data-toggle="modal" data-target="#setGroups"><i
                                    class="fa fa-star fa-fw"></i>Add to Groups</a>
                        <a class="btn btn-lg btn-primary" id="btnPublish">Publish !</a>
                    </div>
                    <input type="hidden" name="action" value="publish"/>
                    <input id="tz" type="hidden" name="tz" value="0"/>
                    {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a name="scheduled"></a>
                        <h1 class="text-left">Scheduled Photos</h1>
                        <p class="lead text-left">select photos to cancel the publishing</p>
                    </div>
                </div>
                @if (Session::has('err2_msg'))


                <div class="alert alert-dismissable alert-danger">{{ session('err2_msg') }}</div>

                @endif

                @if (count($scheduled))
                    @foreach ($scheduled as $date => $photos_scheduled)
                        <form id="frmScheduled_{{ str_replace('-', '_', $date) }}" method="post" action="#scheduled"/>
                         {{ method_field('DELETE') }}
                        <input type="hidden" name="action" value="unpublish"/>
                        <input type="hidden" name="date" value="{{ $date }}"/>
                        {{ csrf_field() }}
                        <h4>
                            <span class="label label-default">{{ date('F, j Y', strtotime($date)) }}</span>
                            <a name="{{ str_replace('-', '_', $date) }}" href="#btn{{ str_replace('-', '_', $date) }}"
                               class="btn btn-danger btn-xs"
                               onclick="$(this).parent().parent().submit(); return false" type="button">Cancel</a>
                        </h4>
                        <select multiple="multiple" class="image-picker show-html" name="photos[]">
                            @foreach ($photos_scheduled as $photo): }}
                            <option data-img-src="{{ $photo['url_q'] }}"
                                    value="{{ $photo['id'] }}">{{ $photo['title'] }}</option>
                            @endforeach
                        </select>
                        </form>

                    @endforeach
                @endif


            </div>
            <div class="container">
                <div class="row">
                    <div id="spaginator" class="col-md-12 text-center"></div>

                </div>
            </div>
        </div>
    </div>
    <script src="js/image-picker.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/jquery.twbsPagination.min.js"></script>
    <script src="js/ekko-lightbox.min.js"></script>

    <script type="text/javascript">
        $("select").imagepicker({
            hide_select: true,
            show_label: true
        });


        $("#btnPublish").click(function () {
            $("#frmUnpublished").submit();
        });

        $("#btnGroups").click(function () {
            //aici tb sa iau toate groupurile si sa le pun intr-un camp...
            $("#setGroups").modal('toggle');
        });

        $("#frmUnpublished").validator();

        $("#btnCancel").click(function () {
            $(this).submit();

        });

        var d = new Date();
        $('#tz').val(d.getTimezoneOffset());

        $('#datetimepicker1').datetimepicker({
            // format: "YYYY-MM-DD HH:mm Z",
            stepping: 15,
            collapse: true,
            keepOpen: false,
            showTodayButton: true,
            showClose: true,
            sideBySide: true,
            useCurrent: true,
            defaultDate: moment(),
            minDate: moment().subtract(1, 'minutes')
        });

        var uoptions = {
            totalPages: {{ $upages }},
            visiblePages: 8,
            href: '?upage=@{{number}}'
        }

        var soptions = {
            totalPages: {{ $spages }},
            visiblePages: 8,
            href: '?spage=@{{number}}#scheduled'
        }


        if (uoptions.totalPages > 0)
            $('#upaginator').twbsPagination(uoptions);
        if (soptions.totalPages > 0)
            $('#spaginator').twbsPagination(soptions);
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

    </script>


@endsection