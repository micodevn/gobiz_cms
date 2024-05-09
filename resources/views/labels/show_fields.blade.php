<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/labels.fields.created_at').':') !!}
    <p>{{ $label->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/labels.fields.updated_at').':') !!}
    <p>{{ $label->updated_at }}</p>
</div>

