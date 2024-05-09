<?php
$label = $label ?? new \App\Models\Label();
?>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/labels.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('slug', __('models/labels.fields.slug').':') !!}
    {!! Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) !!}
</div>

<!-- Short Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('attribute', __('models/labels.fields.attribute').':') !!}
    {!! Form::text('attribute', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    <div>
        {!! Form::label('status', __('models/labels.fields.status').':', []) !!}
    </div>
    {!! Form::hidden('status', 0, false) !!}
    {!! Form::checkbox('status', 1, $label->status, ['data-toggle' => 'toggle']) !!}
</div>

@push('page_scripts')

    <script>
        function toLowerCaseNonAccentVietnamese(str) {
            str = str.toLowerCase();
            str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
            str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
            str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            str = str.replace(/đ/g, "d");
            // Some system encode vietnamese combining accent as individual utf-8 characters
            str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // Huyền sắc hỏi ngã nặng
            str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư
            str = str.replace(/\s+/g, "-");
            return str;
        }
        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $('#name').on('change',function () {
                   $('#slug').val(toLowerCaseNonAccentVietnamese($(this).val()));
                });
            })(jQuery);
        });
    </script>

@endpush
