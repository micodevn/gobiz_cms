<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/files.fields.name').':') !!}
    <p>{{ $file->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/files.fields.description').':') !!}
    <p>{{ $file->description }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', __('models/files.fields.type').':') !!}
    <p>{{ $file->type }}</p>
</div>

<!-- File Path Field -->
<div class="col-sm-12">
    {!! Form::label('file_path', __('models/files.fields.file_path').':') !!}
    <p>{{ $file->file_path }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/files.fields.is_active').':') !!}
    <p>{{ $file->is_active }}</p>
</div>

<!-- Icon File Path Field -->
<div class="col-sm-12">
    {!! Form::label('icon_file_path', __('models/files.fields.icon_file_path').':') !!}
    <p>{{ $file->icon_file_path }}</p>
</div>

