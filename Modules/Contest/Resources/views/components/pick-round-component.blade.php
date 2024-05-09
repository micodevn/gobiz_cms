<?php
/** @var $contest */

$selectedContestRounds = $contest?->rounds()->get();
$selectedContestRounds->load('exams');
$selectedIcon = null;
?>
<div>
    <div id="contest-round-container">
        <div class="d-none" id="exam-template">
            <div class="col-6">
                <div>
                    <span class="exam-name"></span> - <span class="exam-type"></span>
                    <a target="_blank" class="edit-exam-button" href="{{route('exams.edit', ['exam' => ':exam'])}}"><i
                            class="mdi mdi-lead-pencil"></i></a>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span class="start-time"></span>
                </div>
            </div>
            <div class="col-3">
                <div>
                    <span class="end-time"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="mt-2">
                <button onclick="addRowInForRound()" type="button" class="btn btn-primary">+ Tạo vòng thi</button>
            </div>
        </div>
    </div>
</div>
@push('page_scripts')
    <script type="text/template" id="templateCloneContestRound">
        <div class="contest-round-item" id="rowToCloneRound">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="rounds" class="text-danger"><b>Vòng thi:</b></label>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-contest-round-btn">
                                x Xóa
                            </button>
                        </div>
                    </div>
                    <small>
                        <i class="add-exam-note text-danger">Cần tạo thời gian bài thi theo tháng trước, sau đó gán bài
                            tập vào từng bài thi vừa tạo</i>
                    </small>
                    <div class="row form-group">
                        <input type="hidden" name="contest_round_id[]">
                        <input type="hidden" name="contest_id[]" value="{{$contest->id}}">
                        <div class="row form-group">
                            <div class="col col-sm-4">
                                {!! Form::label("Tên vòng thi") !!}
                                {!! Form::text('contest_round_info[]', null, ['class' => 'form-control contest-round-info']) !!}
                            </div>
                        </div>
                        <div class="col col-sm-6 col-md-2">
                            {!! Form::label("Ảnh") !!}
                            <x-api-select
                                :emptyInput="false"
                                :url="route('api.file.search')"
                                name="thumbnail[]"
                                placeholder="Search ảnh"
                                class="file-list select-list"
                                value-field="url"
                            ></x-api-select>
                            <img src="" alt="" class="round-icon-img pt-1" width="100%" height="auto">
                        </div>
                        <div class="col col-sm-10 col-md-4">
                            {!! Form::label("Thời gian bắt đầu") !!}
                            {!! Form::datetimelocal('round_start_time[]', null, ['class' => 'form-control flatpickr', 'min' => 'today','autocomplete' => 'off']) !!}
                        </div>
                        <div class="col col-sm-10 col-md-4">
                            {!! Form::label("Thời gian kết thúc") !!}
                            {!! Form::datetimelocal('round_end_time[]', null, ['class' => 'form-control flatpickr', 'min' => 'today','autocomplete' => 'off']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::label('Danh sách bài tập') !!}
                        </div>
                        <div class="col-sm-12 mt-2">
                            <div class="row text-left">
                                <div class="col-sm-6">
                                    <b>Tên bài thi</b>
                                </div>
                                <div class="col-sm-3">
                                    <b>Thời gian bắt đầu</b>
                                </div>
                                <div class="col-sm-3">
                                    <b>Thời gian kết thúc</b>
                                </div>
                            </div>
                            <div class="exams-container">

                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <a target="_blank" href="{{route('exams.create', ['contest_round_id' => null])}}"
                               class="btn btn-primary d-none add-exam-button" type="button">
                                + Thêm bài tập
                            </a>
                        </div>
                    </div>

                    <hr style="width: 80%; margin-left: auto; margin-right: auto">
                </div>
            </div>

        </div>
    </script>
    <script>
        const contestRounds = @json($selectedContestRounds);

        function initApiSelect() {
            $('.api-select').each(function (i, e) {
                initSingleApiSelect(e);
            });
        }


        function setApiSelected(element, selected) {
            const labelField = $(element).attr('data-label-field');
            const valueField = $(element).attr('data-value-field');

            let newState = new Option(selected[labelField], selected[valueField], true, true);
            $(element).append(newState).trigger('change');
            $(element).val(selected[valueField]).trigger('change');
        }

        function loadContestRound(contestRound) {
            try {
                const container = $(addRowInForRound(false, {'public_time': contestRound.public_time}));
                const iconSelect = container.find('select[name="thumbnail[]"]').first();
                const iconImg = container.find('img.round-icon-img').first();
                const roundStartTime = container.find('input[name="round_start_time[]"]').first();
                const roundEndTime = container.find('input[name="round_end_time[]"]').first();
                const contestRoundIdInput = container.find('input[name="contest_round_id[]"]').first();
                const addExamButton = container.find('.add-exam-button').first();
                const addExamNote = container.find('.add-exam-note').first();
                const detailRuleRound = container.find('input[name="contest_round_info[]"]').first();
                $(addExamButton).removeClass('d-none');
                const createLink = '{{route('exams.create', ['contest_round_id' => 'xid'])}}';
                $(addExamButton).attr('href', createLink.replace('xid', contestRound.id));
                $(addExamNote).addClass('d-none');
                $(contestRoundIdInput).val(contestRound.id);
                $(detailRuleRound).val(contestRound.title);
                $(iconImg).attr('src', contestRound.thumnail);
                $(roundStartTime).val(contestRound.start_time);
                $(roundEndTime).val(contestRound.end_time);
                setApiSelected(iconSelect, {
                    url: contestRound.thumbnail,
                    name: 'Image'
                });
                loadExams(container, contestRound);
            } catch (e) {
                console.log("loadContestRound e: ", e);
            }
        }

        function loadContestRounds() {
            const ContestRound = window.modules.Contest.models.ContestRound;
            contestRounds.forEach(function (contestRoundData, index) {
                const contestRound = new ContestRound(contestRoundData);
                loadContestRound(contestRound);
            });
        }

        function addRowInForRound(addNew = true, option = {}) {
            const cloned = $('#templateCloneContestRound');

            $("#contest-round-container").append($(cloned).html());
            const appended = $("#contest-round-container .contest-round-item").last();
            const index = $(appended).index() - 1;

            $(appended).find('span.select2').remove();
            $(appended).find('select').each(function (index, select) {
                // $(select).select2('destroy');
                $(select).removeClass('no-init');
                $(select).attr('id', "api-select-" + uid());

                initSingleApiSelect(select);
            });
            $(appended).find('select[name="thumbnail[]"]').on('select2:select', function (e) {
                $(appended).find('img.round-icon-img').attr('src', $(this).val());
            });
            $(appended).removeAttr('id');
            $(appended).find('button.remove-contest-round-btn').click(function (e) {
                const btn = $(e.target);
                if (confirm("Bạn có muốn xóa vòng thi này không ?")) {
                    $(appended).remove();
                }
            });

            $(appended).find('input[type="text"][name="contest_round_info[]"]').attr('name', 'contest_round_info[]');

            $(appended).find('select').not('.api-select').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Search for an Item",
                allowClear: true,
            });
            $(appended).find('input[type="datetime-local"]').flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                defaultDate: "today"
            });
            $('input[data-toggle="toggle"]').bootstrapToggle();
            return appended;
        }

        function createSingleExam(data) {
            const template = $($("#exam-template").clone());

            template.find('.exam-name').html(data.title);
            template.find('.exam-type').html(data.type_name);
            template.find('.start-time').html(data.start_time);
            template.find('.end-time').html(data.end_time);
            const editExamButton = template.find('.edit-exam-button').first();
            const editLink = '{{route('exams.edit', ['exam' => ':exam'])}}';

            editExamButton.attr('href', editLink.replace(':exam', data.id));

            return template;
        }

        function loadExams(contestRoundItem, contestRound) {
            const examsContainer = $(contestRoundItem).find('.exams-container').first();
            const examData = contestRound.exams;

            $(examsContainer).html("");
            examData.forEach(function (element, index) {
                const row = $("<div>").addClass('row');
                $(row).append(createSingleExam(element).html())

                $(examsContainer).append(row.prop('outerHTML'));
            });
        }

        function loadAllExams() {
            const contestRoundItems = $(".contest-round-item");

            contestRoundItems.each(function (index, element) {
                loadExams(element);
            });
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $("#contest-exam").submit(function (e) {
                    e.preventDefault();
                });
                document.addEventListener('bootstrap-done', function (e) {
                    loadContestRounds();
                }, false);
            })(jQuery)
        });
    </script>
@endpush

<style>
    .contest-round-item .row {
        margin-top: 10px;
    }

    legend {
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        font-size: unset;
        float: none;
        width: auto;
    }

    fieldset {
        min-width: 0;
        padding: 20px 25px;
        margin: 30px 0 25px;
        border: 1px solid #999;
    }

    hr {
        color: #4b38b3;
    }
</style>
