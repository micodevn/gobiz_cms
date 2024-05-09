function coreInit() {
    initApiSelect();
    const evt = new Event('bootstrap-done');
    document.dispatchEvent(evt);
    $('.file-selector').each(function (i, e) {
        $(e).fileSelector();
    });
}

function initSingleApiSelect(selector) {
    if ($(selector).hasClass('no-init')) {
        return true;
    }

    let tags = '';

    if ($(selector).hasClass('create-new')) {
        tags = {'tags': true};
    }

    if ($(selector).hasClass('no-default')) {
        const fields = $(selector).attr('data-selected');
        !fields && $(selector).append("<option value='' selected='selected'></option>");
        return;
    }

    const init = $(selector).attr('init');

    if (init && init === '1') {
        return true;
    }

    const valueField = $(selector).attr('data-value-field');
    const labelField = $(selector).attr('data-label-field');
    const paramsFilterDefault = $(selector).attr('params-filter-default');
    const url = $(selector).attr('data-url');
    const placeholder = $(selector).attr('placeholder') ?? "Search for an Item";

    let selecteds = [];

    try {
        selecteds = JSON.parse($(selector).attr('data-selected-json'));
    } catch (e) {
    }

    const options = {
        placeholder: placeholder,
        allowClear: true,
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
                let paramDefaults = paramsFilterDefault ? JSON.parse(paramsFilterDefault) : {};
                return {
                    search: params.term,
                    per_page: 15,
                    page: params.page,
                    ...paramDefaults
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
                        return {id: obj[valueField], text: obj[valueField] + " | " + obj[labelField]};
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
    }

    if ($(selector).attr('html-template')) {
        options.templateResult = function (d) {
            return $(d.text);
        };
        options.templateSelection = function (d) {
            return $(d.text);
        };
    }
    $(selector).select2(options);

    $(selector).attr('init', 1);
    if (selecteds.length > 0) {
        if ($(selector).val('multiple')) {
            selecteds.forEach(function (item) {
                if (item) {
                    let newState = new Option(item.name || item.title, item.id, true, true);
                    $(selector).append(newState).trigger('change');
                }
            });
        } else {
            const selected = selecteds[0]
            let newState = new Option(selected[valueField], selected[labelField], true, true);
            $(selector).append(newState).trigger('change');
            $(selector).val(selected[valueField]).trigger('change');
        }
    }
}

function initApiSelect() {
    $('.api-select').each(function (i, e) {
        initSingleApiSelect(e);
    });
}

function initSelect2(elem, url = null, params = {
    value: 'id',
    field: 'name',
    placeholder,
    tags: false,
    multiple: false,
    specialSource: null
}, paramsFilterDefault = {}, dataDefault = null, dataSelected = null) {
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
                let paramsFilter = {
                    search: params.term,
                    per_page: 15,
                    page: params.page
                };
                if(paramsFilterDefault) {
                    paramsFilter = {...paramsFilter, ...paramsFilterDefault}
                }
                return paramsFilter;
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
                            text: obj[params.value] + " | " +obj[params.field],
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

window.addEventListener('DOMContentLoaded', function () {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + API_TOKEN;
    (function ($) {
        $('select').not('.no-init').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: "Search for an Item",
            allowClear: true,
        });
        $('input[data-toggle="toggle"]').bootstrapToggle();
    })(jQuery);

    initApiSelect();
    const evt = new Event('bootstrap-done');
    document.dispatchEvent(evt);
});
