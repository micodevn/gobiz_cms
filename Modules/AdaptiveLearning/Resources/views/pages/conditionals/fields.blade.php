<?php
$conditional = $conditional ?? new \Modules\AdaptiveLearning\Entities\Conditional();
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name','Name:') !!}
    {!! Form::text('name', $conditional->name, ['class' => 'form-control']) !!}
</div>

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">
    <div>
        {!! Form::label('is_active', 'Active:', []) !!}
    </div>
    {!! Form::hidden('is_active', 0, false) !!}
    {!! Form::checkbox('is_active', 1, $conditional->is_active,  ['data-toggle' => 'toggle']) !!}
</div>



