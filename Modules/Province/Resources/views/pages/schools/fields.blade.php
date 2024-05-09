<?php
$school = $school ?? new \Modules\Province\Entities\Schools();

$provinceSelected = $school?->district?->province ? [
    $school->district->province->code => $school->district->province->name
] : [];

$districtsSelected = $school?->district ?
    [
        $school->district->code => $school->district->name
    ] : [];
?>

<div class="col-sm-12 p-0">
    {!! Form::label('name','Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
</div>

<div class="col-sm-12 p-0">
    <div class="col-sm-12 pt-4">
        {!! Form::label('province_code','Province') !!}
        {!! Form::select("province_code",$provinceSelected,null, ['class' => 'form-control no-init province_code']) !!}
    </div>

    <div class="col-sm-12 pt-4">
        {!! Form::label('district_code','District') !!}
        {!! Form::select("district_code",$districtsSelected,null, ['class' => 'form-control no-init district_code']) !!}
    </div>
</div>

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

        function initSingleApiSelect(selector, setSource = null) {
            if ($(selector).hasClass('no-init')) {
                return true;
            }

            let tags = '';

            if ($(selector).hasClass('create-new')) {
                tags = {'tags': true};
            }
            let allowClear = true;
            if ($(selector).hasClass('no_clear')) {
                allowClear = false;
            }

            const valueField = $(selector).attr('data-value-field');
            const labelField = $(selector).attr('data-label-field');
            const sourceField = $(selector).attr('data-field-source-attr');
            const url = $(selector).attr('data-url');
            const placeholder = $(selector).attr('placeholder') ?? "Search for an Item";

            let selecteds = [];

            try {
                selecteds = JSON.parse($(selector).attr('data-selected-json'));
            } catch (e) {
            }

            $(selector).select2({
                placeholder: placeholder,
                allowClear: allowClear,
                theme: 'bootstrap4',
                width: '100%',
                tags,
                ajax: {
                    headers: {
                        'Authorization': 'Bearer ' + API_TOKEN,
                    },
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
                        if (Array.isArray(result.data)) {
                            data = result.data;
                        }
                        if (result.data && result.data.data && result.data.data.length > 0) {

                            data = $.map(result.data.data, function (obj) {
                                let source = {};

                                if (sourceField && obj[sourceField]) {
                                    source = obj[sourceField];
                                }
                                return {
                                    id: obj[valueField],
                                    text: obj[labelField],
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

            if ($(selector).hasClass('no-default')) {
                const fields = $(selector).attr('data-selected');
                !fields && $(selector).append("<option value='' selected='selected'></option>");
            }

            $(selector).attr('init', 1);

            if (typeof selecteds === 'object' || selecteds.length > 0) {
                if ($(selector).attr('multiple')) {
                    selecteds.forEach(function (item) {
                        if (item) {
                            let newState = new Option(item.name, item.id, true, true);
                            $(selector).append(newState).trigger('change');
                        }
                    });
                } else {
                    const selected = selecteds[0] || selecteds;
                    let newState = new Option(selected[labelField], selected[valueField], true, true);
                    $(selector).append(newState).trigger('change');
                    $(selector).val(selected[valueField]).trigger('change');
                }
            }
            $(selector).on('select2:select', function (e) {

            });
        }

        function initApiSelect() {
            $('.api-select').each(function (i, e) {
                initSingleApiSelect(e);
            });
        }

        function setApiSelected(element, selected) {
            const labelField = $(element).attr('data-label-field');
            const valueField = $(element).attr('data-value-field');

            let newState = new Option(selected[labelField], selected[valueField], true, true);
            $(element).append(newState).trigger('change');
            $(element).val(selected[valueField]).trigger('change');
        }

        function setSelected(element, selected) {
            // let newState = new Option(selected.name, selected.id, true, true);

            // $(element).append(newState).trigger('change');
            $(element).val(selected.id).trigger('change');
        }

        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                $('select').not('.no-init').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Search for an Item",
                    allowClear: true,
                });

                $('input[data-toggle="toggle"]').bootstrapToggle();
                initApiSelect();
                const evt = new Event('bootstrap-done');
                document.dispatchEvent(evt);
            })(jQuery);
        });

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
                initSelect2('.district_code', null, {value: 'code', field: 'name'}, []);

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
    </script>
@endpush
