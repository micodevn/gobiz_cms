<?php
    $unique = uniqid();
?>

<select name="{{$name}}"
        class="form-control select2bs4 {{$class}}"
        id="{{$unique}}"
>
    @if(!empty($options))
        @foreach($options as $key => $val)
        <option value="{{$key}}">{{$val}}</option>
        @endforeach
    @endif
</select>