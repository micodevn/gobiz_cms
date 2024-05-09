<?php
    /**
     * @var $withType
     * @var $name
     * @var $url
     * @var $type
     */
?>
<div class="row">
    <!-- File Path Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('file_path', __('models/files.fields.file_path').':') !!}
        <div class="input-group">
            <div class="custom-file">
                {!! Form::file('file_path', ['class' => 'custom-file-input', 'id' => $id, 'class' => $class, 'name' => $name, 'accept' => 'image/*,audio/*,video/*,application/pdf,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document']) !!}
                {!! Form::label('file_path', 'Choose file', ['class' => 'custom-file-label']) !!}
            </div>
        </div>
{{--        <small id="file-name"></small>--}}
        <small id="name_file"></small>
        <div>
          <small id="file_size"></small>
        </div>
    </div>

    <!-- Type Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('type', __('models/files.fields.type').':') !!}
        {!! Form::select('type', \App\Models\File::getTypeListOptions(), null, ['class' => 'form-control', 'id' => 'file-type-select']) !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <button type="button" class="btn btn-default mb-1" id="preview-btn" onclick="preview()">
            <i class="fa fa-play-circle"></i> Xem trước
        </button>
    </div>
</div>

@push('page_scripts')
    <script>
        let filePreview = <?= $url ? '"'.$url.'"' : 'null' ?>;
        let fileType = <?= $type ? '"'.$type.'"' : 'null' ?>;

        function preview() {
            filePreviewer.previewFile(filePreview, fileType);
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#{{$id}}").change(function (e) {
                    if (e.target.files.length === 0) {
                        e.preventDefault();
                        return;
                    }
                    const type = fileHelper.getType(e.target);
                    if (type === null) {
                        alert('Định dạng tệp tin không hỗ trợ');
                        e.preventDefault();
                        $("#preview-btn").attr('disabled', true);
                        return;
                    }

                    filePreview = e.target.files[0];
                    fileType = type;
                    $("#preview-btn").attr('disabled', false);

                    $("#file-type-select").val(type).trigger('change');
                    $("#static_url").val('');

                    const name = fileHelper.getName(e.target);
                    const size = fileHelper.getSize(e.target);

                    const format_size = fileHelper.humanFileSize(size);

                    $("#name_file").html(name || "");
                    $("#file_size").html(format_size ? "Kích thước : "+ format_size : "");
                });
                if ((!filePreview && !fileType) || (fileType && fileType === 'ASSET_BUNDLE')) {
                    $("#preview-btn").prop('disabled', true);
                }
            })(jQuery);
        });
    </script>
@endpush
