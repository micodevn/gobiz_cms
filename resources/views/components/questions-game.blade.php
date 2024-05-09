<?php
/**
// * @var \App\Models\Question $question
 */

$qAnswers = [];
$selectedQuestions = [];
$uniqueId = "questions-select-" . uniqid();
?>
@push('page_css')
    <style>

    </style>
@endpush
<div class="{{$class}} card">
    <div class="card-body">
        <div class="d-flex pb-2">
            <h5 class="card-title">Game Questions</h5>
        </div>
        <table class="table table-bordered qa-table" id="liveclass-table">
            <thead>
            <tr>
                <td>STT</td>
                <td>Questions</td>
                <td>Thời gian hiển thị</td>
                <td>Thời gian hiển thị BXH</td>
                <td>Version Matche</td>
                <td>#</td>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="text-right mt-2">
            <button onclick="addAnswerRow()" type="button" class="btn btn-outline-secondary btn-sm">+ Add Question
            </button>
        </div>
        <div class="d-none" id="live-class-row-clone">
            <table>
                <tbody>
                <tr>
                    <td width="90px">
                        <input type="number" class="form-control" data-live-class-field="id">
                    </td>
                    <td id="questions-select">
                        <select class="select2 form-control select-item" data-placeholder="-- Chọn --"
                                name="game_plan[][question_id]" style="width: 100%;">
                            <option value="">-- Chọn --</option>
                            @foreach($questions as $k => $value)
                                <option value="{{$k}}" >{{$value}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <input type="number" class="form-control">
                    </td>
                    <td>
                        <button onclick="removeRow(this)" type="button" class="btn btn-danger">x</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('page_scripts')
    <script>
        function reIndex() {
            $("#liveclass-table").find('tbody tr').each(function (i, e) {
                $(e).find('input[data-live-class-field="id"]').first().val(i + 1);
            });
        }

        function addAnswerRow() {
            var select = '<select class="select2 form-control select-item koẢnh" data-placeholder="-- Chọn --" name="%name%[%index%][question_id]" style="width: 100%;"><option value="">-- Chọn --</option>';
            @foreach($questions as $key => $value)
                select += '<option value="{{$key}}"  >{{$value}}</option>';
            @endforeach
                select += '</select>';

            const row = $("#live-class-row-clone").find("tr").first().clone();
            $("#liveclass-table").find('tbody').append(row);
            row.find('input[type="checkbox"]').attr('data-toggle', 'toggle');
            $('input[data-toggle="toggle"]').bootstrapToggle();
            $(".file-selector").fileSelector();
            $(".file-selector").on('file-selected', function (e, file) {
                const input = $(e.target).siblings('input').first();
                $(input).val(file.id);
            });
            reIndex();
        }

        function removeRow(e) {
            $(e).closest('tr').first().remove();
            reIndex();
        }

        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
            })(jQuery);
        });
    </script>
@endpush
