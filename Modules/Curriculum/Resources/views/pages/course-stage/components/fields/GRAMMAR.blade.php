@php
    $lessons = \App\Models\Lesson::query()->where('type', \App\Models\Lesson::TYPE_MINI_TEST)->select(['id', 'source', 'name'])->where('is_active', 1)->get();
@endphp
@if(isset($oldStages))
    @php
        $lesson_id = @$item[$program_type_view]['lesson_id'];
    @endphp
    <div class="col-4 @if(!$checkTimeStage) disabled__select @endif">
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][lesson_id][]"
                class="form-control lession__item__selected">
            @foreach($lessons as $option)
                <option @if($lesson_id == $option->id) selected @endif value="{{$option->id}}"> {{@$option->source}} </option>
            @endforeach
        </select>
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][start_time_program]', @$item[$program_type_view]['start_time_program'], ['class' => 'form-control' ,'min' => 'today','autocomplete' => 'off']) !!}
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][end_time_program]', @$item[$program_type_view]['end_time_program'], ['class' => 'form-control', 'min' => 'today','autocomplete' => 'off']) !!}
    </div>
@else
    @php
        $lesson_id = isset($item) ? \Illuminate\Support\Arr::get($item, 'getProgramGrammar.lesson_id') : null;
    @endphp
    <div class="col-4">
        <select required name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][lesson_id][]"
                class="form-control lession__item__selected">
            @foreach($lessons as $option)
                <option @if($lesson_id == $option->id) selected @endif value="{{$option->id}}"> {{@$option->source}} </option>
            @endforeach
        </select>
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][start_time_program]', @$item->start_time, ['class' => 'form-control','min' => 'today','autocomplete' => 'off']) !!}
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][end_time_program]', @$item->end_time, ['class' => 'form-control','min' => 'today','autocomplete' => 'off']) !!}
    </div>
@endif
