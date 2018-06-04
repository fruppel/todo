{{ csrf_field() }}

<div class="form-group">
    {{ Form::label('description', 'Beschreibung') }}
    {{ Form::text('description', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('day', 'Datum') }}
    {{ Form::date('day', $edit->day ?? \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) }}
</div>

<div class="form-group mt-5">
    <input type="submit" name="submit" value="Speichern" class="btn btn-primary "/>
    <a class="btn btn-outline-danger" href="{{ route('tasks.index') }}">Abbrechen</a>
</div>