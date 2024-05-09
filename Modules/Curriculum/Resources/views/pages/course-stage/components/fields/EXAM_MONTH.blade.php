@if(isset($oldStages))
    <div class="col-4">
        <input value="{{@$item[$program_type_view]['target_url']}}" 
        type="text" class="form-control" name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][target_url]" @if(!$checkTimeStage) readonly @endif>
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][start_time_program]', @$item[$program_type_view]['start_time_program'], ['class' => 'form-control' ,'min' => 'today','autocomplete' => 'off']) !!}
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][end_time_program]', @$item[$program_type_view]['end_time_program'], ['class' => 'form-control', 'min' => 'today','autocomplete' => 'off']) !!}
    </div>
@else
    <div class="col-4">
        <input value="{{@$item->target_url}}" 
        type="text" class="form-control" name="stage[{{$key_stage-1}}][content][{{$keyRd}}][{{$program_type_view}}][target_url]" @if(!$checkTimeStage) readonly @endif>
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][start_time_program]', @$item->start_time, ['class' => 'form-control' ,'min' => 'today','autocomplete' => 'off']) !!}
    </div>
    <div class="col-2 @if(!$checkTimeStage) disabled__select @endif">
        {!! Form::datetimelocal('stage['.($key_stage-1).'][content]['.$keyRd.']['.$program_type_view.'][end_time_program]', @$item->end_time, ['class' => 'form-control', 'min' => 'today','autocomplete' => 'off']) !!}
    </div>
@endif