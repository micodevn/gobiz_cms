<?php
    /**
     * @var \App\Models\File $file
     */
    $timestamps = $file->videoTimestamps ?? [];
    $subtitles = $file->videoSubtitles ?? [];
//    dd($timestamps->toArray());
?>
<style>
    thead tr td {
        font-weight: bold;
    }
    .file-selector.timestamp-icon {
        width: 80px;
        height: 80px;
    }
</style>
<hr>
<div class="timestamp-video">
    <h5>
        Video Timestamps
    </h5>
    <table class="table table-bordered timestamp-table" id="timestamp-table">
        <thead>
        <tr>
            <td>Title</td>
            <td>Description</td>
            <td>Start time</td>
            <td>End time</td>
            <td>Icon</td>
            <td>Full Text</td>
            <td>Float Left</td>
            <td>Questions</td>
            <td>#</td>
        </tr>
        </thead>
        <tbody>
            @foreach($timestamps as $timestamp)
                <?php

                    /** @var array $timestamp */
                    $id = Arr::get($timestamp, 'id');
                    $title = Arr::get($timestamp, 'title');
                    $description = Arr::get($timestamp, 'description');
                    $start = Arr::get($timestamp, 'start');
                    $end = Arr::get($timestamp, 'end');
                    $iconId = Arr::get($timestamp, 'icon.id');
                    $icon = Arr::get($timestamp, 'icon');
                    $fulltext = Arr::get($timestamp, 'fulltext');
                    $isLeft = Arr::get($timestamp, 'is_left');
                    $timestampQuestions = Arr::get($timestamp, 'timestampQuestions');
                ?>
                <tr>
                    <td>
                        <input value="{{$id}}" type="hidden" data-timestamp data-timestamp-name="id">
                        <input value="{{$title}}" type="text" class="form-control" data-timestamp data-timestamp-name="title">
                    </td>
                    <td>
                        <input value="{{$description}}" type="text" class="form-control" data-timestamp data-timestamp-name="description">
                    </td>
                    <td>
                        <input value="{{$start}}" type="number" class="form-control" data-timestamp data-timestamp-name="start">
                    </td>
                    <td>
                        <input value="{{$end}}" type="number" class="form-control" data-timestamp data-timestamp-name="end">
                    </td>
                    <td>
                        <input value="{{$iconId}}" type="number" class="d-none" data-timestamp-name="icon_id" data-timestamp>
                        <button data-file="{{json_encode($icon)}}" class="btn file-selector timestamp-icon" type="button" data-filter-type="image"></button>
                    </td>
                    <td>
                        <input data-toggle="toggle" type="checkbox" data-timestamp-name="fulltext" data-timestamp {{$fulltext ? 'checked' : ''}}>
                    </td>
                    <td>
                        <input data-toggle="toggle" type="checkbox" data-timestamp-name="is_left" data-timestamp {{$isLeft ? 'checked' : ''}}>
                    </td>
                    <td>
                        <x-api-select
                            :attributes="['multiple' => 'multiple', 'data-timestamp-name' => 'question_ids', 'data-timestamp' => true]"
                            :url="route('questions.list-active')"
                            :selected="$timestampQuestions"
                            class="timestamp-questions"
                            emptyValue=""
                        ></x-api-select>
                    </td>
                    <td>
                        <button onclick="removeRowFile(this)" type="button" class="btn btn-danger">x</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-right">
        <button onclick="addTimestampRow()" type="button" class="btn btn-outline-secondary btn-sm">+ Add Timestamp
        </button>
    </div>
    <div class="d-none" id="timestamp-row-clone">
        <table>
            <tbody>
            <tr>
                <td>
                    <input type="hidden" data-timestamp data-timestamp-name="id">
                    <input type="text" class="form-control" data-timestamp data-timestamp-name="title">
                </td>
                <td>
                    <input type="text" class="form-control" data-timestamp data-timestamp-name="description">
                </td>
                <td>
                    <input type="number" class="form-control" data-timestamp data-timestamp-name="start">
                </td>
                <td>
                    <input type="number" class="form-control" data-timestamp data-timestamp-name="end">
                </td>
                <td>
                    <input type="number" class="d-none" data-timestamp-name="icon_id" data-timestamp>
                    <button class="btn file-selector timestamp-icon" type="button" data-filter-type="image"></button>
                </td>
                <td>
                    <input type="checkbox" data-timestamp-name="fulltext" data-timestamp>
                </td>
                <td>
                    <input type="checkbox" data-timestamp-name="is_left" data-timestamp>
                </td>
                <td>
                    <x-api-select
                        :attributes="['multiple' => 'multiple', 'data-timestamp-name' => 'question_ids', 'data-timestamp' => true]"
                        :url="route('questions.list-active')"
                        class="timestamp-questions no-init"
                        emptyValue=""
                    ></x-api-select>
                </td>
                <td>
                    <button onclick="removeRowFile(this)" type="button" class="btn btn-danger">x</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@push('page_scripts')
    <script>
        function addTimestampRow() {
            const row = $("#timestamp-row-clone").find("tr").first().clone();
            $("#timestamp-table").find('tbody').append(row);
            makeUpTimestampRow(row);
        }

        function makeUpTimestampRow(row) {
            row.find('input[type="checkbox"]').attr('data-toggle', 'toggle');
            $('input[data-toggle="toggle"]').bootstrapToggle();
            $(".file-selector").fileSelector();
            $(".file-selector").on('file-selected', function (e, file) {
                const input = $(e.target).siblings('input').first();
                $(input).val(file.id);
            });
            const id = row.find('.timestamp-questions').attr('id');
            row.find('.timestamp-questions').attr('id', id + '-' + Math.random());
            row.find('.timestamp-questions').removeClass('no-init');

            initSingleApiSelect(row.find('.timestamp-questions')[0]);
        }

        function removeRowFile(e) {
            $(e).closest('tr').first().remove();
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#timestamp-table").find('tbody tr').each(function (i, e) {
                    makeUpTimestampRow($(e));
                    $(e).find('button.file-selector').each(function (i, e) {
                        const fileJson = $(e).data('file');

                        try {
                            $(e).fileSelector('setFile', fileJson);
                        } catch (e) {

                        }
                    });
                });
            })(jQuery);
        });
    </script>
@endpush

{{--=====================SUBTITLE=====================--}}

<hr>
<div class="subtitle-video">
    <h5>
        Video Subtitles
    </h5>
    <table class="table table-bordered subtitle-table" id="subtitle-table">
        <thead>
        <tr>
            <td>Title</td>
            <td>Description</td>
            <td>Start time</td>
            <td>End time</td>
            <td>#</td>
        </tr>
        </thead>
        <tbody>
            @foreach($subtitles as $subtitle)
                <?php
                    /** @var array $subtitle */
                    $id = Arr::get($subtitle, 'id');
                    $title = Arr::get($subtitle, 'title');
                    $description = Arr::get($subtitle, 'description');
                    $start = Arr::get($subtitle, 'start');
                    $end = Arr::get($subtitle, 'end');
                ?>
                <tr>
                    <td>
                        <input value="{{$id}}" type="hidden" data-subtitle data-subtitle-name="id">
                        <input value="{{$title}}" type="text" class="form-control" data-subtitle data-subtitle-name="title">
                    </td>
                    <td>
                        <input value="{{$description}}" type="text" class="form-control" data-subtitle data-subtitle-name="description">
                    </td>
                    <td>
                        <input value="{{$start}}" type="text" class="form-control" data-subtitle data-subtitle-name="start">
                    </td>
                    <td>
                        <input value="{{$end}}" type="text" class="form-control" data-subtitle data-subtitle-name="end">
                    </td>
                    <td>
                        <button onclick="removeRow(this)" type="button" class="btn btn-danger">x</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-right">
        <button onclick="addSubtitleRow()" type="button" class="btn btn-outline-secondary btn-sm">+ Add Subtitle
        </button>
    </div>
    <div class="d-none" id="subtitle-row-clone">
        <table>
            <tbody>
            <tr>
                <td>
                    <input type="hidden" data-subtitle data-subtitle-name="id">
                    <input type="text" class="form-control" data-subtitle data-subtitle-name="title">
                </td>
                <td>
                    <input type="text" class="form-control" data-subtitle data-subtitle-name="description">
                </td>
                <td>
                    <input type="text" class="form-control" data-subtitle data-subtitle-name="start">
                </td>
                <td>
                    <input type="text" class="form-control" data-subtitle data-subtitle-name="end">
                </td>
                <td>
                    <button onclick="removeRow(this)" type="button" class="btn btn-danger">x</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@push('page_scripts')
    <script>
        function addSubtitleRow() {
            const row = $("#subtitle-row-clone").find("tr").first().clone();
            $("#subtitle-table").find('tbody').append(row);
            row.find('input[type="checkbox"]').attr('data-toggle', 'toggle');
            $('input[data-toggle="toggle"]').bootstrapToggle();
        }

        function removeRow(e) {
            $(e).closest('tr').first().remove();
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {

            })(jQuery);
        });
    </script>
@endpush
