<?php
$skillVerb = $skillVerb ?? new \Modules\AdaptiveLearning\Entities\SkillVerb();

$selectedParent = [
    $skillVerb->parent ? $skillVerb->parent->toArray() : null
];

$class = 'platforms_parent';

?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/skillVerbs.fields.label').':') !!}
    {!! Form::text('name', $skillVerb->name, ['class' => 'form-control']) !!}
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', 'parent:') !!}
    <x-api-select
            :selected="$selectedParent"
            :url="route('skillVerb.child.list')"
            :selectedValue="$skillVerb->parent_id"
            :selectedLabel="$skillVerb->parent_name"
            name="parent_id"
    ></x-api-select>
</div>

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-6">
    <div>
        {!! Form::label('is_active', __('models/skillVerbs.fields.is_active').':', []) !!}
    </div>
    {!! Form::hidden('is_active', 0, false) !!}
    {!! Form::checkbox('is_active', 1, $skillVerb->is_active,  ['data-toggle' => 'toggle']) !!}
</div>



