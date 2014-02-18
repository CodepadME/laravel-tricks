@extends('layouts.main')

@section('title','Error')

@section('content')
    <div class="container">
        <div class="row push-down">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <h1 class="page-title">Whoops... That's an error...</h1>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                @include('partials.search')
            </div>
        </div>

        <div class="col-lg-12">
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        </div>
    </div>
@stop
