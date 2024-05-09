<?php
$question = $question ?? new \App\Models\Question();
$exercise = $exercise ?? new \App\Models\Exercise();
$file_path_url = !empty($exercise->image_url) ? $exercise->image_url : '';
$file_name = !empty($exercise->imagePath) ? $exercise->imagePath->name : '';
$image = $exercise->imagePath ?? [];
$appImage = $exercise->appImage ?? [];

$video_path_url = !empty($exercise->video_url) ? $exercise->video_url : '';
$video = $exercise->videoPath ?? [];

$audio_path_url = !empty($exercise->audio_url) ? $exercise->audio_url : '';
$audio = $exercise->audioPath ?? [];

$selectedQuestions = $exercise->questions ?? collect();
$selectedQuestions = $selectedQuestions->sortBy('pivot.position')->values();

$selectedPlatform = $exercise->platform ? [
    [
        'id' => $exercise->platform->id,
        'name' => $exercise->platform->name
    ]
] : [];

$selectedProduct = $exercise->product ? [
    [
        'id' => $exercise->product->id,
        'name' => $exercise->product->name
    ]
] : [];

$selectedType = $exercise->type ? [
    [
        'id' => $exercise->type->id,
        'name' => $exercise->type->name
    ]
] : [];

$selectedLearning = $exercise->learningObjectives;
$selectedQ = json_encode($selectedQuestions);
?>
<x-questions-exercise-map></x-questions-exercise-map>
<div class="col-6">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group my-2 col-sm-6">
            {!! Form::label('name', __('models/exercises.fields.name').':') !!}
            {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>

        <!-- Description Field -->
        <div class="form-group my-2 col-sm-6">
            {!! Form::label('description', __('models/exercises.fields.description').':') !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Level Field -->
        <div class="form-group my-2 col-sm-6">
            {!! Form::label('level', __('models/users.fields.level').':') !!}
            {!! Form::hidden('level', '') !!}
            {!! Form::select('level',\App\Models\Exercise::LEVEL, $exercise->level ?? null, ['class' => 'form-control no-default api-select', 'data-selected' => $exercise->level]) !!}
        </div>

        <div class="form-group my-2 col-sm-6">
            {!! Form::label('duration', __('models/exercises.fields.duration').':') !!}
            {!! Form::number('duration', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Platform Id Field -->
        <div class="form-group my-2 col-sm-6">
            {!! Form::label('platform_id',__('models/exercises.fields.platform_id').':') !!}

            <x-api-select
                :url="route('question-platform.group-options')"
                :selected="$selectedPlatform"
                emptyValue=""
                name="platform_id"
            ></x-api-select>
        </div>

        <div class="form-group my-2 col-sm-6">
            {!! Form::label('duration_show', 'Thời gian câu hỏi được hiển thị (số giây):') !!}
            {!! Form::number('duration_show', $exercise->time_show, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group my-2 col-sm-12">
            <div>
                {!! Form::label('is_active', __('models/exercises.fields.is_active').':', []) !!}
            </div>
            {!! Form::hidden('is_active', 0, false) !!}
            {!! Form::checkbox('is_active', 1, $exercise->is_active,  ['data-toggle' => 'toggle']) !!}
        </div>
    </div>
</div>
<div class="col-6">
    <div class="row">

        <!-- Product Field -->
        <div class="form-group my-2 col-sm-6">
            {!! Form::label('type_id', 'Loại bài tập:') !!}
            <x-api-select
                :url="route('exerciseType.list')"
                :selected="$selectedType"
                emptyValue=""
                name="type_id"
            ></x-api-select>
        </div>
        <!-- Vide Field -->
        <div class="form-group my-2 col-sm-12">
            {!! Form::label('video', __('models/exercises.fields.video').':') !!}
            {!! Form::number('video', null, ['class' => 'form-control d-none', 'id' => 'video_field', 'data-file' => json_encode($video)]) !!}
            <button id="video_selector" style="width: 150px; height: 150px" class="btn file-selector" type="button"
                    data-file-id="{{$exercise->video}}"
                    data-filter-type="video"></button>
        </div>

        <div class="form-group my-2 col-sm-6">
            {!! Form::label('question_ids','Questions :') !!}
            <x-api-select
                :attributes="['multiple' => 'multiple']"
                :url="route('questions.list-active')"
                :selected="$selectedQuestions"
                emptyValue=""
                name="question_ids[]"
                class="questionExercise"
            ></x-api-select>
            <div class="mt-2">
                <button id="questionExerciseMap" class="btn btn-primary questionExerciseMap"
                        data-questions-selected="{{$selectedQ}}" type="button">
                    Quản lý câu hỏi
                </button>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <link rel="stylesheet" href="/app-assets/css/plugins/input-tags/tagsinput.css"/>
    <script src="/js/tags-input/tagsinput.js"></script>
    <script>
        function collectQCFields() {
            const content = $(".qc-content");
            const fields = content.find('[data-qc-field]');
            const qc_content_data = {};
            const resourceFields = [
                'image', 'audio', 'video', 'document'
            ];
            const textValueFields = [
                'title', 'value', 'description', 'explanation'
            ];
            fields.each(function (i, e) {
                const field = e.getAttribute('data-qc-field');
                const value = e.value;
                qc_content_data[field] = {};

                if (resourceFields.includes(field)) {
                    qc_content_data[field].id = value;
                } else if (textValueFields.includes(field)) {
                    qc_content_data[field].value = value;
                } else {
                    qc_content_data[field] = value;
                }
            });

            return JSON.stringify(qc_content_data);
        }

        function collectQAFields() {
            const content = $(".qa-content");
            const table = content.find("#qa-table");
            const rows = table.find("tbody tr");
            const qa_content_data = [];

            const resourceFields = [
                'image', 'audio'
            ];
            const textValueFields = [
                'text'
            ];

            rows.each(function (i, e) {
                const row = $(e);
                const fields = row.find('[data-qa-field]');
                const rowData = {};
                fields.each(function (i, e) {
                    const field = e.getAttribute('data-qa-field');
                    const value = e.value;
                    rowData[field] = {};

                    if (resourceFields.includes(field)) {
                        rowData[field].id = value;
                    } else if (textValueFields.includes(field)) {
                        rowData[field].value = value;
                    } else {
                        rowData[field] = value;
                    }
                });

                qa_content_data.push(rowData);
            });

            return JSON.stringify(qa_content_data);
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#topic_select").select2({
                    multiple: true,
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Search for an Item",
                    allowClear: true,
                })

                $("#thumbnail_selector").on('file-selected', function (e, file) {
                    const id = file && file.id ? file.id : null;
                    $("#thumbnail_field").val(id);
                });
                const imageId = $("#thumbnail_field").val();
                if (imageId) {
                    const data = $("#thumbnail_field").data('file');
                    data && $("#thumbnail_selector").fileSelector('setFile', data);
                }

                $("#app_image_selector").on('file-selected', function (e, file) {
                    const id = file && file.id ? file.id : null;
                    $("#app_image").val(id);
                });
                const app_image = $("#app_image").val();
                if (app_image) {
                    const data = $("#app_image").data('file');
                    data && $("#app_image_selector").fileSelector('setFile', data);
                }

                $("#video_selector").on('file-selected', function (e, file) {
                    const id = file && file.id ? file.id : null;
                    $("#video_field").val(id);
                });
                const videoId = $("#video_field").val();
                if (videoId) {
                    $("#video_selector").fileSelector('setFile', $("#video_field").data('file'));
                }

                $("#audio_selector").on('file-selected', function (e, file) {
                    const id = file && file.id ? file.id : null;
                    $("#audio_field").val(id);
                });
                const audioId = $("#audio_field").val();
                if (audioId) {
                    $("#audio_selector").fileSelector('setFile', $("#audio_field").data('file'));
                }

                const form = $(".question_pointer").first().parents('form').first();
                form.on('submit', function (e) {
                    form.find('input[name="question_content"]').first().val(collectQCFields());
                    form.find('input[name="answers"]').first().val(collectQAFields());
                });
            })(jQuery);
        });
    </script>

@endpush

