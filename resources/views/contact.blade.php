@extends('layouts/app')

@section('content')
    <h1>Contact</h1>

    @if(count($people))
        @foreach($people as $person)
            <li>{{$person}}</li>
        @endforeach
    @endif

@stop


@section('footer')
    <script>alert('Hello')</script>
@stop