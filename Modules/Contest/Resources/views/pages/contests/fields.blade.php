<?php
/** @var $contest */
$contest = $contest ?? new \Modules\Contest\Entities\Contest();

$contestTypeSelected = $contest->contestType ? [
    'code' => $contest->contestType->code,
    'name' => $contest->contestType->name
] : [];

$groupSelected = $contest?->group ? [
    'id' => $contest?->group->id,
    'name' => $contest?->group->name
] : [];

$selectedContestRounds = $contest?->rounds;
$sourceField = 'file_path_url';
?>

<div class="contest_pointer"></div>
<div class="card">
    <div class="card-header card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">
            Tạo danh sách bài thi
        </h4>
        <div class="flex-shrink-0">
            <div class="form-check form-switch form-switch-right form-switch-md">
                <a href="{{ route('contests.index') }}"
                   class="btn btn-secondary btn-label waves-effect waves-light">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-format-list-bulleted-square label-icon align-middle"></i>
                        </div>
                        <div class="flex-grow-1">
                            Danh sách bài thi theo tháng
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('title','Tên bài thi:') !!}
                {!! Form::text('title', null, ['class' => 'form-control','required' => 'required']) !!}
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('type','Loại bài thi:') !!}
                <select name="type" class="form-control">
                    <option value="">Chọn loại bài thi</option>
                    @foreach(\Modules\Contest\Entities\Contest::TYPE as $key => $value)
                        <option
                            value="{{$key}}" {{ $contest->type && $key == $contest->type ? 'selected' : ''}}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                {!! Form::label('grade_id','Khối lớp:') !!}
                <select name="grade_id" class="form-control">
                    <option value="">Chọn khối lớp</option>
                    @foreach($grades as $grade)
                        <option
                            value="{{$grade->id}}" {{ $contest->grade_id && $grade->id == $contest->grade_id ? 'selected' : ''}}>{{$grade->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                {!! Form::label('description','Mô tả:') !!}
                {!! Form::text('description', null, ['class' => 'form-control','placeholder' => 'Mô tả']) !!}
            </div>
            <div class="col-sm-3">
                <div>
                    {!! Form::label('is_active', 'Trạng thái:', []) !!}
                </div>
                {!! Form::hidden('is_active', 0, false) !!}
                {!! Form::checkbox('is_active', 1, $contest->is_active,  ['data-toggle' => 'toggle']) !!}
            </div>
        </div>
    </div>
</div>
<x-contest-pick-round-component :contest="$contest">
</x-contest-pick-round-component>
@push('page_scripts')
    <script src="{{asset('assets/js/contest/contest.js')}}" defer></script>
    <script src="{{asset('assets/js/contest/contest-model.js')}}" defer></script>
    <script src="{{asset('assets/js/contest/contest-service.js')}}" defer></script>
    <script>
        $(function () {
            $(".flatpickr").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
            });
        });
        function addRuleRowForRound() {
            $("#detail_round_table").find('tbody').append($('#rowToCloneRuleRound').html());
            let input = $("#detail_round_table").find('tbody tr:last > td > textarea');

            // initCkedit($(input)[0]);
            $("#detail_round_table").find('tbody tr:last select').each(function (i, elem) {
                initSingleApiSelect(elem);
            })
            addValueImage();
        }

        function removeRow(e) {
            $(e).closest('tr').first().remove();
        }

        function collectContestRoundFields() {
            const rows = $("#info_round_table").find("tbody tr");
            const round_info_data = [];

            rows.each(function (i, e) {
                let dataRoundInfo = {};
                $(e).children().each(function (i, elem) {
                    let val = null;
                    let nameElem = null;

                    if ($(elem).find('select').first().val()) {
                        val = $(elem).find('select').first().val() ?? null
                    } else {

                        val = $(elem).children().first().val() ?? null;
                    }

                    if ($(elem).find('select').first().attr('name')) {
                        nameElem = $(elem).find('select').first().attr('name');
                    } else {

                        nameElem = $(elem).children().first().attr('name');
                    }

                    if (nameElem && val) {
                        dataRoundInfo[nameElem] = val;
                    }
                })
                round_info_data.push(dataRoundInfo)
            });

            return JSON.stringify(round_info_data);
        }

        function addValueImage() {
            $('.file-list').on('select2:select', function (e) {
                let data = e.params.data;
                $(this).parent().parent().next().find('input:first').val(data.text)
                if (data.source) {
                    $(this).parent().parent().next().next().find('input:first').val(data.source)
                }
            })
        }


        function validateSubmit(e) {

            if (Date.parse($('.round_start_time').val()) > Date.parse($('.round_end_time').val())) {
                e.preventDefault();
                alert("Thời gian bắt đầu đăng ký không được lớn hơn thời gian kết thúc đăng ký !")
                return;
            }
        }
    </script>
@endpush
<style>
    .row {
        margin-bottom: 10px;
    }
</style>
