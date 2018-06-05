{{ csrf_field() }}

<div class="form-group">
    <label for="description">Beschreibung</label>
    {{ Form::text('description', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    <label for="day">Datum</label>
    <input type="date" id="day" name="day" :value.prop="'{{ old('day', $task->day ?? \Carbon\Carbon::now()->format('Y-m-d')) }}'" class="form-control">
</div>

<div class="form-group mt-5">
    <input type="submit" name="submit" value="Speichern" class="btn btn-primary "/>
    <a class="btn btn-outline-danger" href="{{ route('tasks.index') }}">Abbrechen</a>
</div>