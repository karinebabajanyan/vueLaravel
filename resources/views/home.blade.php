@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
             <h1> Welcome!</h1>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection
@section('style')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
