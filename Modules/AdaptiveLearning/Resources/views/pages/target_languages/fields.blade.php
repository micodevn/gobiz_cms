<?php
$targetLanguage = $targetLanguage ?? new \Modules\AdaptiveLearning\Entities\TargetLanguage();
?>

<!-- Target Language Field -->
<div class="form-group col-sm-6">
    {!! Form::label('target_language', __('models/targetLanguages.fields.target_language').':') !!}
    {!! Form::text('target_language', null, ['class' => 'form-control']) !!}
</div>

<!-- Part Field -->
<div class="form-group col-sm-6">
    {!! Form::label('part', __('models/targetLanguages.fields.part').':') !!}
    {!! Form::select("part",\Modules\AdaptiveLearning\Entities\TargetLanguage::PARTS,$targetLanguage->part, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('explain', 'explain:') !!}
    {!! Form::text('explain', null, ['class' => 'form-control']) !!}
</div>
