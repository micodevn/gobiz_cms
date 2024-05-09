<?php
/**
 * @var $url
 * @var $labelField
 * @var $valueField
 * @var $selected
 * @var $emptyValue
 * @var $name
 */

$unique = uniqid();
$uniqueId = "api-select-" . $unique;
$selected = $selected ? collect($selected) : collect();
$selectedJson = $selected->toJson();
$valueField = $valueField ?? '';
$labelField = $labelField ?? '';
$selectedJson = $selectedJson ?? '';
$placeholder = $placeholder ?? null;

?>
<div>
    {{ Form::hidden($name, $emptyValue) }}

    <select
            name="{{$name}}"
            id="{{$uniqueId}}" {!! $inlineAttributes !!}
            class="api-select form-control {{$class}}"
            data-value-field="{{$valueField}}"
            data-label-field="{{$labelField}}"
            data-selected-json="{{$selectedJson}}"
            data-url="{{$url}}"
            placeholder="{{$placeholder}}"
    >
        @if(!empty($selectedValue) && is_array($selectedValue))
            @foreach($selectedValue as $key =>$val)
                <option value="{{$key}}">{{$val}}</option>
            @endforeach
        @elseif(!empty($selectedValue))
            <option value="{{$selectedValue}}">{{$selectedLabel}}</option>
        @endif
    </select>
</div>
@push('page_scripts')
    <script>
        //See app.blade.php - initApiSelect()
    </script>
@endpush
