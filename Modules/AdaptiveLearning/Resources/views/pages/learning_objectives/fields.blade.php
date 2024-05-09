<?php

$learningObjective = $learningObjective ?? new \Modules\AdaptiveLearning\Entities\LearningObjective();

$selectedKillVerb = $learningObjective->skillVerb ? [
    [
        'id' => $learningObjective->skillVerb->id,
        'name' => $learningObjective->skillVerb->name
    ]
] : [];

$selectedGoal = $learningObjective->learningGoal ? [
    [
        'id' => $learningObjective->learningGoal->id,
        'name' => $learningObjective->learningGoal->name
    ]
] : [];

$selectedConditional = $learningObjective->learningConditional ? [
    [
        'id' => $learningObjective->learningConditional->id,
        'name' => $learningObjective->learningConditional->name
    ]
] : [];

?>
<div class="learning-obj-sudo-el"></div>

<!-- explain Field -->
<div class="form-group col-sm-6">
    {!! Form::label('explain', __('models/learningObjectives.fields.explain').':') !!}
    {!! Form::text('explain', null, ['class' => 'form-control','required' => 'required' ,'disabled']) !!}
</div>


<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', __('models/learningObjectives.fields.code').':') !!}
    {!! Form::text('code', null, ['class' => 'form-control','required' => 'required']) !!}
</div>

<!-- Skill Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('skill_id', __('models/learningObjectives.fields.verb').':') !!}
    <x-api-select
            :url="route('skillVerb.list.filter')"
            :selected="$selectedKillVerb"
            emptyValue=""
            name="skill_id"
    ></x-api-select>
</div>

<!-- Goal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('goal', __('models/learningObjectives.fields.goal').':') !!}
    <x-api-select
            :url="route('learning.goal.list')"
            :selected="$selectedGoal"
            emptyValue=""
            name="goal_id"
            class="create-new"
    ></x-api-select>
</div>

<!-- Conditional Field -->
<div class="form-group col-sm-6">
    {!! Form::label('conditional', __('models/learningObjectives.fields.conditional').':') !!}
    <x-api-select
            :url="route('learning.conditional.list')"
            :selected="$selectedConditional"
            emptyValue=""
            name="conditional_id"
            class="create-new"
    ></x-api-select>
</div>

@push('page_scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const CreateForm = $(".learning-obj-sudo-el").first().parents('form').first();

            CreateForm.on('submit', function (e) {
                const skillVerb = CreateForm.find('select[name="skill_id"] option:selected').html() || '';
                const Goal = CreateForm.find('select[name="goal_id"] option:selected').html() || '';
                const Conditional = CreateForm.find('select[name="conditional_id"] option:selected').html() || '';
                const explain = skillVerb.trim() + " " + Goal.trim() + " " + Conditional.trim() ;
                CreateForm.find('input[name="explain"]').first().val(explain);
                $("<input />").attr("type", "hidden")
                    .attr("name", "explain")
                    .attr("value", explain)
                    .appendTo(CreateForm);
            });

            CreateForm.on('change',()=> {
                const skillVerb = CreateForm.find('select[name="skill_id"] option:selected').html() ?? '';
                const Goal = CreateForm.find('select[name="goal_id"] option:selected').html() ?? '';
                const Conditional = CreateForm.find('select[name="conditional_id"] option:selected').html() ?? '';
                const explain = skillVerb.trim() + " " + Goal.trim() + " " + Conditional.trim() ;
                CreateForm.find('input[name="explain"]').first().val(explain);
            })
        });
    </script>
@endpush
