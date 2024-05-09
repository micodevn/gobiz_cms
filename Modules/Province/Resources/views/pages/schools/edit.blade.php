@extends('layouts.app')
@section('title')
    {{ $school->name }}
@endsection
@section('content')
{{--    @include('pages.error')--}}
    <div class="row">
        <div class="col-6">
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 flex-grow-1">
                            Create school
                        </h4>
                    </div>
                    {!! Form::model($school, ['route' => ['schools.update', $school->id], 'method' => 'patch']) !!}

                    <div class="card-body">
                        <div class="row">
                            @include('province::pages.schools.fields')
                        </div>
                    </div>

                    <div class="card-footer">
                        {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
                        <a href="{{ route('schools.index') }}" class="btn btn-default">
                            @lang('crud.cancel')
                        </a>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        function initSelect2(elem, url = null, params = {
            value: 'id',
            field: 'name',
            placeholder,
            tags: false,
            multiple: false,
            specialSource: null
        }, dataDefault = null, dataSelected = null) {
            let placeholder = params.placeholder ?? 'Select Item'
            let tags = params.tags;
            let multiple = params.multiple;
            let specialSource = params.specialSource ?? 'districts';
            if (dataDefault) {
                $(elem).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    theme: 'bootstrap4',
                    multiple: multiple,
                    width: '100%',
                    tags,
                })
                if (Array.isArray(dataDefault)) {
                    dataDefault.forEach(function (item) {
                        if (item) {
                            let newState = new Option(item.name, item.code, false, false);
                            $(elem).append(newState).trigger('change');
                        }
                    });
                }
                return;

            }

            $(elem).select2({
                placeholder: placeholder,
                allowClear: true,
                theme: 'bootstrap4',
                multiple: multiple,
                width: '100%',
                tags,
                ajax: {
                    url: url,
                    dataType: 'json',
                    quietMillis: 100,
                    delay: 500,
                    data: function (params) {

                        return {
                            search: params.term,
                            per_page: 15,
                            page: params.page
                        };
                    },
                    processResults: function (result, page) {
                        let more = result.data.current_page < result.data.last_page;

                        let data = [];

                        if (result.data) {
                            data = result.data;
                        }
                        if (result.data && result.data.data && result.data.data.length > 0) {
                            data = $.map(result.data.data, function (obj) {
                                let source = {};

                                if (obj[specialSource]) {
                                    source = obj[specialSource];
                                }
                                return {
                                    id: obj[params.value],
                                    text: obj[params.field],
                                    source: JSON.stringify(source)
                                };
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

        function initSelect() {
            initSelect2('.province_code', '{!! route('province-info') !!}', {value: 'code', field: 'name'});

            $('.province_code').on('select2:select', function (e) {
                let data = e.params.data;
                $('.district_code').empty().trigger("change");
                if (data.source) {
                    let district = JSON.parse(data.source);
                    initSelect2('.district_code', null, {value: 'code', field: 'name'}, district);
                }
            });


            $('.district_code').on('select2:select', function (e) {
                $('.school_code').empty().trigger("change");

                let newUrl = '{!! route('school.api.list') !!}' + '?district_code=' + $(this).val();
                initSelect2('.school_code', newUrl, {
                    value: 'id',
                    field: 'name',
                    placeholder: 'Search school',
                });
            })
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                {{--// initSelect()--}}
                let routerProvinceInfo = '{!! route('province-info') !!}';

                initSelect2('.province_code', routerProvinceInfo, {value: 'code', field: 'name'});
                // initSelect2('.district_code', null, {value: 'code', field: 'name'}, []);

                $('.province_code').on('change', function (e) {
                    $.ajax({
                        url: '{!! route('provinces.load-districts') !!}',
                        data: {province_code: this.value, district_code: '{!! $school->district_code !!}'},
                        type: 'get',
                        success: function (response) {
                            $(".district_code").html(response.data)
                        },
                        error: function (response) {
                            console.log(response)
                        }
                    });
                }).change()

            })(jQuery)
        });

        function changeProvince(data) {

        }
    </script>
@endpush
