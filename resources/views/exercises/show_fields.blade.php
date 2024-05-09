<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', __('models/exercises.fields.id').':') !!}
    <p>{{ $exercise->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/exercises.fields.name').':') !!}
    <p>{{ $exercise->name }}</p>
</div>

<!-- Short Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/exercises.fields.description').':') !!}
    <p>{{ $exercise->description }}</p>
</div>

<!-- Questions Field -->
@if($exercise->questions && count($exercise->questions))
<div class="col-sm-12">
    {!! Form::label('questions', 'Questions:') !!}
    @foreach($exercise->questions as $k => $val)
        <p>{{$val->name}}</p>
    @endforeach

</div>
@endif


