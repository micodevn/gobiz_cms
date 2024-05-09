<!-- Goal Field -->
<div class="col-sm-12">
    {!! Form::label('goal', __('models/learningObjectives.fields.goal').':') !!}
    <p>{{ $learningObjective->goal }}</p>
</div>

<!-- Conditional Field -->
<div class="col-sm-12">
    {!! Form::label('conditional', __('models/learningObjectives.fields.conditional').':') !!}
    <p>{{ $learningObjective->conditional }}</p>
</div>

