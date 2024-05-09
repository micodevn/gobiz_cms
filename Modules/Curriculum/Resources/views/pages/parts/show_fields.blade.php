<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $part->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $part->description }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $part->is_active }}</p>
</div>

<!-- Lesson Id Field -->
<div class="col-sm-12">
    {!! Form::label('lesson_id', 'Lesson Id:') !!}
    <p>{{ $part->lesson_id }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $part->type }}</p>
</div>

