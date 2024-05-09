<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $subject->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $subject->description }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $subject->is_active }}</p>
</div>

<!-- Grade Id Field -->
<div class="col-sm-12">
    {!! Form::label('grade_id', 'Grade Id:') !!}
    <p>{{ $subject->grade_id }}</p>
</div>

