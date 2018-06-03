@extends('layouts.app')

@section('content')
    <div class="container">
        <task-list :task-days="{{ $taskDays }}"></task-list>
        <hr>
        <h3>Archiv</h3>
        <task-archive :tasks="{{ $archivedTasks }}"></task-archive>
    </div>
@endsection
