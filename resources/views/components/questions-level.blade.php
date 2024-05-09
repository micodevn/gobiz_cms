@php
    $questionLevel = !empty($exercises->exerciseDetail) ?$exercises->exerciseDetail : [];
@endphp
@push('page_css')
    <style>

    </style>
@endpush
<div class="{{$class}} card">
    <div class="card-body">
        <div class="d-flex pb-2">
            <h5 class="card-title">Questions Level</h5>
        </div>
        <table class="table table-bordered ql-table" id="ql-table" data-name="questionsLevel">
            <thead>
            <tr>
                <td width="80px">STT</td>
                <td>Độ Khó</td>
                <td>Số lượng câu hỏi</td>
                <td>Platform</td>
                <td>#</td>
            </tr>
            </thead>
            <tbody>
            @foreach($questionLevel as $key => $val)
                <?php
                if ($val['other_platform']) {
                    $val['platform_id'] = true;
                    $val['platform'] = [
                        'id' => -1,
                        'name' => 'Other Platform'
                    ];
                }
                ?>

                @if(!empty($val['platform_id']))
                    <?php
                    /** @var $val */
                    $selectedPlatform = [$val['platform']];
                    ?>
                @else
                    <?php
                    $selectedPlatform = []
                    ?>
                @endif
                <tr>
                    <td width="80px">
                        <input readonly type="number" name="questionsLevel[{{$key}}][index]" value="{{$key}}"
                               class="form-control" data-ql-field="id">
                    </td>
                    <td>
                        {!! Form::select("questionsLevel[$key][level]",\App\Models\Question::LEVEL_QUESTIONS,Arr::get($val,'level'), ['class' => 'form-control']) !!}
                    </td>
                    <td>
                        {!! Form::number("questionsLevel[$key][question_number]", Arr::get($val,'question_number'), ['class' => 'form-control question-number','min' => 0]) !!}
                    </td>
                    <td>
                        <x-api-select
                                :url="route('question-platform.group-options')"
                                :selected="$selectedPlatform"
                                emptyValue=""
                                name="questionsLevel[{{$key}}][platform_id]"
                        ></x-api-select>
                    </td>
                    <td>
                        <button onclick="removeRowEx(this)" type="button" class="btn btn-danger">x</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right mt-2">
            <button type="button" class="btn btn-outline-secondary btn-sm add-question-level">+ Add
            </button>
        </div>
    </div>
</div>
@push('page_scripts')
    <script>
        function reIndex() {
            $("#ql-table").find('tbody tr').each(function (i, e) {
                $(e).find('input[data-ql-field="id"]').first().val(i + 1);
            });
        }

        function addQuestionsLevelRow() {
            $(".add-question-level").click(function () {
                var table = $("#ql-table");
                var tableName = table.attr('data-name');
                var newSelect;
                var index = table.find("tr").length;
                var select = '<select class="select2 form-control select-item" data-placeholder="-- Chọn --" name="%name%[%index%][level]" style="width: 100%;"><option value="">-- Chọn --</option>';

                @foreach(\App\Models\Question::LEVEL_QUESTIONS as $key => $value)
                    select += '<option value="{{$key}}"  >{{$value}}</option>';
                @endforeach
                    select += '</select>';

                newSelect = select.replace('%name%', tableName);
                newSelect = newSelect.replace('%index%', index);
                const selectPlatform = addSelectPlatform(table);


                var row2 = '<tr class="new-create">' +
                    '<td width="80px"><input readonly type="number" name="' + tableName + '[' + index + '][index]" value="' + index + '" class="form-control" /></td>' +
                    '<td>' + newSelect + '</td>' +
                    '<td><input data-index="' + index + '" type="number" name="' + tableName + '[' + index + '][question_number]" value="0" min="0" placeholder="Số lượng câu hỏi" class="form-control question-number" /></td>' +
                    '<td>' + selectPlatform + '</td>' +
                    '<td>' +
                    '<button onclick="removeRowEx(this)" type="button" class="btn btn-danger">x</button>' +
                    '</td>'
                '</tr>';
                table.append(row2);
                initSelect2('platform_' + index);
                reIndex();
                validate()
            })
        }

        function validate() {
            $('.question-number').each(function (i, elm) {
                $(elm).on('change', function () {
                    if ($(this).val() < 0) {
                        $(this).val(0);
                        alert('Must be greater than 0')
                        return;
                    }
                })
            })
        }

        function addSelectPlatform(table) {
            var tableName = table.attr('data-name');
            var newSelect;
            var index = table.find("tr").length;

            const id = "platform_" + index;

            var select = '<select  id="' + id + '" class="form-control" name="questionsLevel[%index%][platform_id]"></select>';
            newSelect = select.replace('%name%', tableName);
            newSelect = newSelect.replace('%index%', index);
            return newSelect;
        }

        function initSelect2(id) {
            $("#" + id).select2({
                placeholder: "Search for an Item",
                allowClear: true,
                theme: 'bootstrap4',
                width: '100%',
                ajax: {
                    headers: {
                        'Authorization': 'Bearer ' + API_TOKEN,
                    },
                    url: "{{ route('question-platform.group-options') }}",
                    dataType: 'json',
                    quietMillis: 100,
                    delay: 500,
                    data: function (term, page) {
                        return {
                            search: term
                        };
                    },
                    processResults: function (result, page) {
                        let more = result.data.current_page < result.data.last_page;

                        let data = [];

                        if (Array.isArray(result.data)) {
                            data = result.data;
                        }

                        if (result.data && result.data.data && result.data.data.length > 0) {
                            data = $.map(result.data.data, function (obj) {
                                return {id: obj['id'], text: obj['name']};
                            });

                            if (Array.isArray(result.data.data[0].children)) {
                                data = result.data.data;
                                more = false;
                            }
                        }
                        return {
                            results: data,
                            pagination: {
                                more: more
                            }
                        };
                    }
                },
            });
        }

        function removeRowEx(e) {
            $(e).closest('tr').first().remove();
            reIndex();
        }


        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                addQuestionsLevelRow();
                validate()
            })(jQuery);
        });
    </script>
@endpush
