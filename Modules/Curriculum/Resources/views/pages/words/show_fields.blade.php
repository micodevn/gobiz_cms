<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $course->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $course->description }}</p>
</div>

<!-- Level Field -->
<div class="col-sm-12">
    {!! Form::label('level', 'Level:') !!}
    <p>{{ $course->level }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $course->is_active }}</p>
</div>

<!-- Subject Id Field -->
<div class="col-sm-12">
    {!! Form::label('subject_id', 'Subject Id:') !!}
    <p>{{ $course->subject_id }}</p>
</div>

