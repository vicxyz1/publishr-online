@extends("layout")

@section("content")
    <script src="{{ url('/js/validator.min.js') }}"></script>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a name="contact"></a>
                    <h1>Contact Us</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (isset($result)):
                    @if ($result):?>
                    <div class="alert alert-dismissable alert-success"><strong>Well done!</strong> Your message was sent
                        succesfully.
                    </div>
                    @else:
                    <div class="alert alert-dismissable alert-danger"><strong>Error!</strong> Your message could not be
                        sent.
                    </div>
                    @endif

                    @endif
                </div>
                <div class="col-md-12">
                    <div class="section">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">


                                    {!! Form::open([ 'method' => 'post', 'route'=>'contact.send', 'url'=>url('contact#contact')]) !!}

                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        {!! Form::label('Name:') !!}
                                        {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>

                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        {!! Form::label('Email:') !!}
                                        {!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>

                                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                                        {!! Form::label('Message:') !!}
                                        {!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Enter Message']) !!}
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success">Submit</button>
                                    </div>

                                    {{--  <div class="form-group"><label class="control-label"
                                                                     for="exampleInput">Name</label>
                                          <input name="name" class="form-control" id="exampleInput"
                                                 placeholder="Enter your name" type="text" required></div>
                                      <div class="form-group"><label class="control-label" for="exampleInputEmail1">Email
                                              address</label>
                                          <input name="email" class="form-control" id="exampleInputEmail1"
                                                 placeholder="Enter your email" type="email" required></div>
                                      <div class="form-group has-feedback"><label class="control-label" for="message">Message</label><textarea
                                                  class="form-control input-sm" id="message" name="message"
                                                  placeholder="Your message" required></textarea></div>
                                      <button type="submit" class="btn btn-default">Submit</button>--}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
        <script>
            // $("#frmContact").validator();


        </script>
@endsection