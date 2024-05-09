<?php
$selectValue = \Modules\AdaptiveLearning\Entities\TargetLanguage::PARTS ?? [];
?>

<div class="card-body {{ $class }}">
    <div class="input-group w-100">
        <div style="width: 20% !important;">
            <select class="form-select" id="select_part" aria-label="Default select example">
                <option selected>Chọn Part</option>
                @if(!empty($selectValue))
                    @foreach($selectValue as $key =>  $val)
                        <option value="{{$key}}">{{$val}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <input type="text" class="form-control" id="target-input" placeholder=" Add new target Language ... "
               aria-label="Text input with dropdown button">
        <input type="text" class="form-control" id="explain-input" placeholder=" explain ... "
               aria-label="Text input with dropdown button">
        <button type="button" class="btn btn-info add-target" id="add_target_input">+</button>
    </div>
</div>


@push('page_scripts')
    <script>
        function addOptions() {
            const elem = $("#target-input");
            const target_new = elem.val();
            const part = $("#select_part").find('option:selected').val();
            if (!target_new || !part) {
                alert("Thiếu thông tin!")
                return false;
            }
            let newTargetOption = new Option(target_new, null, true, true);
            $(".target-language-select").append(newTargetOption).trigger('change');

        }
        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                $("#add_target_input").on('click',(e)=>{
                    e.preventDefault();
                    addOptions();
                })
            })(jQuery);
        });

    </script>
@endpush
