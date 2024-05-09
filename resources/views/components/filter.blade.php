<?php
$filterAble = $filterAble ?? [];
$baseOptions = [
    'name' => '',
    'emptyValue' => null,
    'inlineAttributes' => ''
];
?>
<div class="row mb-2 justify-content-between mx-3">
    <div class="card w-100 card-default">

        <div class="card-body">
            <div class="row">
                <form action="" method="get" class="w-100" id="filter-init">
                    @csrf
                    <div class="col-12 row">
                        <div class="form-group mb-0 col-1">
                            <div class="form-group">
                                <input value="{{request()->get('id')}}" placeholder="ID" name="id" type="number" min="0"
                                       class="form-control">
                            </div>
                        </div>

                        @foreach($filterAble as $key => $val)
                            @php
                                $type_filter = $val['filter_type'] ??'absolute';
                            @endphp
                            <div class="form-group mb-0 col-2">
                                <div class="form-group">
                                    @if($val['type'] != 'component')
                                        <input data-type-filter="{{$type_filter}}"
                                               value="{{request()->get($key)}}"
                                               placeholder="{{!empty($val['placeholder']) ? $val['placeholder'] : ''}}"
                                               name="{{$key}}" type="{{$val['type']}}" class="form-control">
                                    @else
                                        @php
                                            $baseOptions['name'] = $key;
                                            $options = [...$baseOptions, ...$val['options']];
                                        @endphp
                                        {{\View::make('components.'.$val['componentName'], $options)}}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group mb-0 col-1">
                            <button type="submit" class="btn color-edupia"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('page_scripts')
    <script>
        function collectParams() {
            const data_filter = {};
            const filterForm = $("#filter-init");

            const fields = filterForm.find('[data-type-filter]');
            fields.each(function (i, e) {
                const field = e.getAttribute('data-type-filter');
                data_filter[e.name] = {"type":field,"value" : $(e).val()};
            });
            return JSON.stringify(data_filter);
        }


        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                const filterForm = $("#filter-init");

                filterForm.on('submit', function (e) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'filters',
                        value: collectParams()
                    }).appendTo(filterForm);
                });
            })(jQuery);
        });
    </script>
@endpush