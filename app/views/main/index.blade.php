@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => route('main.do'), 'method' => 'post', 'files' => true]) }}
            <div class="form-group form-group-default">
                {{Form::label('image', 'Image')}}
                {{Form::file('image', [ 'class' => 'form-control' ])}}
            </div>

            <div class="form-group form-group-default">
                {{Form::label('aspect', 'Aspect Ratio')}}
                {{Form::text('aspect', '3.171666666666667', [ 'class' => 'form-control' ])}}
                <span class="inline-help">Ratio = Width / Height</span>
            </div>

            <div class="form-group form-group-default">
                {{Form::label('directory', 'Directory')}}
                {{Form::text('directory', 'http://rwwd.newbz.co.uk/wp-content/themes/tbi-theme/img/slider/', [ 'class' => 'form-control' ])}}
                <span class="inline-help">Ratio = Width / Height</span>
            </div>

            {{ Form::submit('Generate', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>

    @if( Session::has( "output" ) )
        <div class="row">
            <div class="col-md-12">
                <pre>{{ htmlentities(Session::get( "output" )) }}</pre>
            </div>
        </div>
    @endif

    @if( Session::has( "test" ) )
        <div class="row">
            <div class="col-md-12">
                {{ Session::get( "test" ) }}
            </div>
        </div>
    @endif
@stop