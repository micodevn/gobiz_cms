<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Tiêu đề:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Mô tả:') !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'maxlength' => 1000]) !!}
</div>

<!-- License Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('license_code', 'License code:') !!}
    {!! Form::text('license_code', null, ['class' => 'form-control', 'maxlength' => 1000]) !!}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_active', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_active', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_active', 'Kích hoạt', ['class' => 'form-check-label']) !!}
    </div>
</div>
