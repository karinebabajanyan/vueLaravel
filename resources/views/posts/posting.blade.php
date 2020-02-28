@extends('layouts.app')

@section('content')
<div id="posts">
</div>
<script src="{{ mix('js/app.js') }}" async defer></script>
<link rel="stylesheet" href="{{ url(mix('/css/app.css')) }}">
@endsection
