<?php
$exam = $exam ?? new \Modules\Contest\Entities\Exam();
$exerciseSelectedArr = $exam->exercise ? [
    collect([
        'id' => $exam->exercise->id,
        'name' => $exam->exercise->name
    ])
] : [];
$contestSelectedArr = $exam->round?->contest ? [collect($exam->round->contest)] : [];
$contestId = $exam->round?->contest?->id ?? ':id';
$contestRoundSelected = $exam->round ? [collect($exam->round)] : [];
$contestSelected = json_encode($contestSelectedArr);
$hasContestRoundId = request()->has('contest_round_id');
if (request()->has('contest_round_id')) {
    $contestRoundId = request()->get('contest_round_id');
    $contestRoundSelected = \Modules\Contest\Entities\Round::query()->find($contestRoundId);
    $contestSelectedArr = $contestRoundSelected->toArray();
    $contestSelected = $contestRoundSelected->contest;
    $contestSelectedArr = $contestSelected->toArray();
}
?>
@if(!isset($createFromContest) || !$createFromContest)
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">
                    @yield('contest-title')
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
                                    Danh sách bài thi
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @endif
                <div class="row form-group mb-3">
                    <div class="col-4">
                        {!! Form::label('title','Title:') !!}
                        {!! Form::text('title', null, ['class' => 'form-control','required' => 'required']) !!}
                    </div>

                    <div class="col-4">
                        <div>
                            {!! Form::label('is_active', 'Status:', []) !!}
                        </div>
                        {!! Form::hidden('is_active', 0, false) !!}
                        {!! Form::checkbox('is_active', 1, $exam->is_active,  ['data-toggle' => 'toggle']) !!}
                    </div>
                </div>

                <div class="mb-3 row mb-3">
                    <div class="mb-3 col-sm-4">
                        {!! Form::label('exercise_id','Chọn bài thi:') !!}
                        <x-api-select
                            :url="route('list-exercises')"
                            name="exercise_id"
                            :selected="$exerciseSelectedArr"
                            placeholder="Search Exercise"
                            class="exercise_id"
                            id="exercise_id"
                        ></x-api-select>
                    </div>
                    <div class="col-3">
                        {!! Form::label('max_turn','Số lần được phép thi:') !!}
                        {!! Form::number('max_turn', null, ['class' => 'form-control','required' => 'required','min' => 0]) !!}
                    </div>
                    <div class="form-group mb-0 col-sm-4 col-md-2">
                        <label for="subject_id">Môn học:</label>
                        <select data-placeholder="-- Môn học --" name="subject_id" class="form-control select2bs4"
                                style="width: 100%;">
                            <option value="">
                                Môn học
                            </option>
                            @foreach($subjects as $subject)
                                <option
                                    {{$exam->subject_id == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">{{ $subject->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-sm-4">
                        {!! Form::label('contest','Chọn nhóm bài thi:') !!}
                        <x-api-select
                            :url="route('contest-list')"
                            name="contest_id"
                            :selected="$contestSelectedArr"
                            placeholder="Search contest"
                            class="contest_id"
                            id="contest_id"
                            labelField="title"
                            :attributes="['disabled' => $hasContestRoundId]"
                        ></x-api-select>
                        @if($hasContestRoundId)
                            <input name="contest_id" type="hidden" value="{{$contestSelected->id}}">
                        @endif
                    </div>
                    <div class="mb-3 col-sm-4">
                        {!! Form::label('round_id','Chọn tháng:') !!}
                        <x-api-select
                            :url="route('contest-round-list', $contestId)"
                            name="round_id"
                            :selected="$contestRoundSelected"
                            labelField="title"
                            placeholder="Search round"
                            class="round_id"
                            id="round_id"
                            :attributes="['disabled' => $hasContestRoundId]"
                        ></x-api-select>
                        @if($hasContestRoundId)
                            <input name="round_id" type="hidden" value="{{request()->get('contest_round_id')}}">
                        @endif
                    </div>
                </div>
                <div class="d-flex form-group row mb-3">
                    <div class="form-group col-sm-4">
                        {!! Form::label('start_time','Start Time') !!}
                        <input type="text" class="form-control flatpickr flatpickr-input" name="start_time" value="{{$exam->start_time}}"
                               id="start_time">
                    </div>
                    <div class="form-group col-sm-4">
                        {!! Form::label('end_time','End Time') !!}
                        <input type="text" class="form-control flatpickr flatpickr-input" name="end_time" value="{{$exam->end_time}}"
                               id="end-time">
                    </div>
                </div>
                @if(!isset($createFromContest) || !$createFromContest)
            </div>
        </div>
    </div>
@endif

@push('page_scripts')
    <script>
        $(function () {
            $(".flatpickr").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                time_24hr: true,
            });
        });
    </script>

@endpush
