<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $grade->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $grade->description }}</p>
</div>

<!-- Level Field -->
<div class="col-sm-12">
    {!! Form::label('level', 'Level:') !!}
    <p>{{ $grade->level }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', 'Is Active:') !!}
    <p>{{ $grade->is_active }}</p>
</div>

