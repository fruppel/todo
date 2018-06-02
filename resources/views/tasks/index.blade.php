@extends('layouts.app')

@section('content')
    <div class="container">
        <task-list :task-days="{{ $taskDays }}"></task-list>
    </div>
@endsection
