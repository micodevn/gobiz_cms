<?php
/**
 * @var $name
 * @var $url
 */
$uniqueId = "img-picker-" . uniqid();
?>
<style>
    .image-preview-box {
        width: 170px;
        height: 170px;
        margin-right: 10px;
    }

    .image-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: gray;
    }

    <?= '#'.$uniqueId ?>  .input-group {
        display: flex;
    }

    <?= '#'.$uniqueId ?> .input-group .custom-file {
        flex: 1;
        align-items: start;
        flex-direction: column;
    }
</style>
<div id="{{$uniqueId}}">
    {!! Form::label('icon_file_path', __('models/files.fields.icon_file_path').':') !!}
    <div class="input-group">
        <div class="image-preview-box">
            <img width="100%" src="<?= $url ?? '/images/image-default.jpg' ?>" class="img-preview" alt="">
        </div>
        <div class="custom-file">
            <div>
                {!! Form::file('icon_file_path', ['class' => 'custom-file-input', 'name' => $name, 'accept' => 'image/*']) !!}
                {!! Form::label('icon_file_path', 'Choose file', ['class' => 'custom-file-label']) !!}
            </div>
            <small id="icon-file-name"></small>
        </div>
    </div>
</div>
@push("page_scripts")
    <script>
        const uniqueId = "{{$uniqueId}}";

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#" + uniqueId).find(".custom-file-input").change(function (e) {
                    if (e.target.files.length === 0) {
                        e.preventDefault();
                        return;
                    }

                    const file = e.target.files[0];
                    const fileUrl = URL.createObjectURL(file);
                    $("#" + uniqueId).find(".img-preview").attr('src', fileUrl);
                    $("#icon-file-name").html(file.name);
                });
            })(jQuery);
        });
    </script>
@endpush
