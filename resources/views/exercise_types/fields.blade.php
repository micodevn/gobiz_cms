<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/exerciseTypes.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', __('models/exerciseTypes.fields.code').':') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', __('models/exerciseTypes.fields.description').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('doc_link', __('models/exerciseTypes.fields.doc_link').':') !!}
    {!! Form::text('doc_link', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
{{--<div class="form-group col-sm-12">--}}
{{--    {!! Form::label('game_name', __('models/exerciseTypes.fields.game_name').':') !!}--}}
{{--    {!! Form::text('game_name', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}
