@extends('layouts.app')

@section('content')
    <div class="container">
        <tasks :todo="{{ $todo }}" :archived="{{ $archived }}"></tasks>
    </div>
@endsection
