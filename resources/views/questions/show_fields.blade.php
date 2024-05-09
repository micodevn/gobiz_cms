<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', __('models/questions.fields.id').':') !!}
    <p>{{ $question->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/questions.fields.name').':') !!}
    <p>{{ $question->name }}</p>
</div>

<!-- Short Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/questions.fields.description').':') !!}
    <p>{{ $question->description }}</p>
</div>

<!-- Thumbnail Field -->
<div class="col-sm-12">
    {!! Form::label('thumbnail', __('models/questions.fields.thumbnail').':') !!}
    <p>{{ $question->thumbnail }}</p>
</div>

<!-- Metadata Version Field -->
<div class="col-sm-12">
    {!! Form::label('metadata_version', __('models/questions.fields.metadata_version').':') !!}
    <p>{{ $question->metadata_version }}</p>
</div>

<!-- Platform Id Field -->
<div class="col-sm-12">
    {!! Form::label('platform_id', __('models/questions.fields.platform_id').':') !!}
    <p>{{ $question->platform_id }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/questions.fields.is_active').':') !!}
    <p>{{ $question->is_active }}</p>
</div>

