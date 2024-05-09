<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/exercises.fields.name').':') !!}
    <p>{{ $targetLanguage->target_language }}</p>
</div>

<!-- Short Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/exercises.fields.description').':') !!}
    <p>{{ $targetLanguage->part }}</p>
</div>