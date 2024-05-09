<?php
$unique = uniqid();
$uniqueId = "api-select-" . $unique;
$selected = $selected ? collect($selected) : collect();
$selectedJson = $selected->toJson();
$valueField = $valueField ?? '';
$labelField = $labelField ?? '';
$selectedJson = $selectedJson ?? '';
$placeholder = $placeholder ?? null;
$paramsFilterDefault = $paramsFilterDefault ? collect($paramsFilterDefault) : collect();
$fieldSourceAttribute = $fieldSourceAttribute ?? null;
?>
<div class="api-select-wrapper w-100">
    {{ Form::hidden($name, $emptyValue) }}

    <select
        name="{{$name}}"
        id="{{$uniqueId}}" {!! $inlineAttributes !!}
        class="api-select form-control {{$class}}"
        data-value-field="{{$valueField}}"
        data-label-field="{{$labelField}}"
        data-selected-json="{{$selectedJson}}"
        data-field-source-attr="{{$fieldSourceAttribute}}"
        data-url="{{$url}}"
        placeholder="{{$placeholder}}"
        params-filter-default="{{$paramsFilterDefault}}"
    >
        @if(!empty($selectedValue) && is_array($selectedValue))
            @foreach($selectedValue as $key => $val)
                <option value="{{$key}}">{{$val}}</option>
            @endforeach
        @elseif(!empty($selectedValue))
            <option value="{{$selectedValue}}">{{$selectedLabel}}</option>
        @endif
    </select>
</div>
