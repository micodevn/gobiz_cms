<?php
    $file = $file ?? new \App\Models\File();
    $labelsSelected = $file->labels ? $file->labels->toArray() : null;
//    dd($labelsSelected);
?>
<div id="form-child"></div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', __('models/files.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'file-name']) !!}
</div>

<!-- Description Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('description', __('models/files.fields.description').':') !!}--}}
{{--    {!! Form::text('description', null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- File Field -->
<div class="col-sm-12 mt-4">
    <x-file-picker :url="$file->file_path_url" :type="$file->type" name="file_path" id="file_path"></x-file-picker>
</div>

<!-- Icon File Path Field -->
{{--<div class="col-sm-6">--}}
{{--    <x-image-picker name="icon_file_path" :url="$file->icon_file_path_url"></x-image-picker>--}}
{{--</div>--}}
{{--<div class="clearfix"></div>--}}



<!-- Name Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('url_static_options', __('models/files.fields.url_options').':') !!}--}}
{{--    {!! Form::text('url_static_options', $file->file_path_url, ['class' => 'form-control' ,'id' => 'static_url', 'disabled' => true]) !!}--}}
{{--</div>--}}


<!-- label Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('labels', __('models/files.fields.label').':') !!}--}}
{{--    <x-api-select--}}
{{--            :attributes="['multiple' => 'multiple']"--}}
{{--            :url="route('list-labels')"--}}
{{--            :selected="$labelsSelected"--}}
{{--            class="api-select"--}}
{{--            emptyValue=""--}}
{{--            name="label_ids[]"--}}
{{--    ></x-api-select>--}}
{{--</div>--}}

<!-- 'bootstrap / Toggle Switch Is Active Field' -->
<div class="form-group col-sm-12 mt-4">
    <div>
        {!! Form::label('is_active', __('models/files.fields.is_active').':', []) !!}
    </div>
    {!! Form::hidden('is_active', 0, false) !!}
    {!! Form::checkbox('is_active', 1, $file->is_active, ['data-toggle' => 'toggle']) !!}
</div>

{{--<div class="col-sm-12" id="video-property">--}}
{{--    <x-video-property :file="$file"></x-video-property>--}}
{{--</div>--}}

@push('page_scripts')
    <script>
        function getTimestampData(inputs, type) {
            const row = {};
            inputs.each(function (i, input) {
                const inputType = $(input).attr('type');
                const name = $(input).attr('data-' + type + '-name');
                switch (inputType) {
                    case 'checkbox':
                        row[name] = input.checked;
                        break;
                    case 'number':
                        row[name] = parseInt($(input).val());
                        break;
                    default:
                        row[name] = $(input).val();
                }
            });

            return row;
        }

        function getVideoProperties() {
            const root = $("#video-property");
            const videoProperty = {};

            //Get Timestamp
            const timestampTable = root.find('.timestamp-video .timestamp-table').first();
            const timestampData = [];
            timestampTable.find('tbody tr').each(function (i, e) {
                const rowData = getTimestampData($(e).find('[data-timestamp]'), 'timestamp');
                timestampData.push(rowData);
            });

            //Get subtitle
            const subtitleTable = root.find('.subtitle-video .subtitle-table').first();
            const subtitleData = [];
            subtitleTable.find('tbody tr').each(function (i, e) {
                const rowData = getTimestampData($(e).find('input[data-subtitle]'), 'subtitle');
                subtitleData.push(rowData);
            });

            videoProperty.timestamps = JSON.stringify(timestampData);
            videoProperty.subtitles = JSON.stringify(subtitleData);

            return videoProperty;
        }

        function submitForm(form) {
            const formData = new FormData(form);
            // const videoProperties = getVideoProperties();

            // $(form).find('input[name="video_timestamps"]').first().val(videoProperties.timestamps);
            // $(form).find('input[name="subtitles"]').first().val(videoProperties.subtitles);

            $(form).unbind().submit();
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#video-property").hide();
                $("#file-type-select").change(function (e) {
                    if ($(this).val() === 'VIDEO_TIMESTAMP') {
                        $("#video-property").show();
                        return;
                    }

                    $("#video-property").hide();
                });

                if ($("#file-type-select").val() === 'VIDEO_TIMESTAMP') {
                    $("#video-property").show();
                }

                //Update file name
                $("#file_path").on('change', function (e) {
                    const fileName = $("#file-name").val();

                    if (fileName.trim() !== '') {
                        return true;
                    }

                    const uploadFileName = e.target.files.length > 0 ? e.target.files[0].name : null;
                    $("#file-name").val(uploadFileName);
                });

                const form = $("#form-child").closest('form').first();
                form.submit(function (e) {
                    e.preventDefault();
                    // console.log($(e.target).serializeArray());
                    submitForm(e.target);
                });
            })(jQuery);
        });
    </script>
@endpush
