<?php
$goal = $goal ?? new \Modules\AdaptiveLearning\Entities\Goal();
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', $goal->name, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    <div>
        {!! Form::label('is_active','Active:', []) !!}
    </div>
    {!! Form::hidden('is_active', 0, false) !!}
    {!! Form::checkbox('is_active', 1, $goal->is_active,  ['data-toggle' => 'toggle']) !!}
</div>



