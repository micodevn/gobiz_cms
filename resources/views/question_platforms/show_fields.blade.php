<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/questionPlatforms.fields.name').':') !!}
    <p>{{ $questionPlatform->name }}</p>
</div>

<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', __('models/questionPlatforms.fields.code').':') !!}
    <p>{{ $questionPlatform->code }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/questionPlatforms.fields.description').':') !!}
    <p>{{ $questionPlatform->description }}</p>
</div>

<!-- Parent Id Field -->
<div class="col-sm-12">
    {!! Form::label('parent_id', __('models/questionPlatforms.fields.parent_id').':') !!}
    <p>{{ $questionPlatform->parent_id }}</p>
</div>

<!-- Image Id Field -->
<div class="col-sm-12">
    {!! Form::label('image_id', __('models/questionPlatforms.fields.image_id').':') !!}
    <p>{{ $questionPlatform->image_id }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/questionPlatforms.fields.is_active').':') !!}
    <p>{{ $questionPlatform->is_active }}</p>
</div>

