<?php
$attributeOptions = $attributeOptions ?? '';
$attributeParent = $attributeParent ?? '';

?>
<div>
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" id="buttonCollapse" data-toggle="collapse"
                            data-target="#questionTypeCollapse" aria-expanded="false"
                            aria-controls="questionTypeCollapse">
                        Question Attribute Options
                    </button>
                </h5>
            </div>
            <div id="questionTypeCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <div id="builder"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            (function ($) {
                let parent = '{!! $attributeParent !!}';
                parent = repairedJson(parent);
                const attrParent  = parent ? JSON.parse(JSON.stringify(parent)) : [];

                if (attrParent) {
                    const {keyParent,keyComponentSingle} = detachAttr(attrParent);
                    addOptionForm(keyParent,keyComponentSingle);
                }

                let components = '{!! $attributeOptions !!}';
                components = repairedJson(components);
                Formio.builder(document.getElementById('builder'), {
                        components: components ? JSON.parse(components) : [],
                    }, {
                        noDefaultSubmitButton: true,
                        builder: {
                            resource: false,
                            basic: {
                                title: 'Options Attribute',
                                weight: 0,
                                components: {
                                    password: false,
                                    button: false,
                                    textField:false,
                                    tag:true,
                                    datetime:true,
                                    day:true,
                                    time:true,
                                    survey:true,
                                    columns:true,
                                    table:true,
                                    panel:true,
                                    datagrid:true,
                                    container:true,
                                    fileSelector: FileSelectorCustom.builderInfo()
                                }
                            },
                            advanced: false,
                            layout: false,
                            data: false,
                            premium: false,
                        }
                    }
                ).then(function (form) {
                    if (components) {
                        $('.question-attributes').val(components);
                    }
                    form.on("change", function (schema) {
                        if(form.schema.components.length) {
                            $('.question-attributes').val(JSON.stringify(form.schema.components));
                        }else {
                            $('.question-attributes').val('');
                        }
                    });
                });


                function updateApiNameField(editForm) {
                    const components = editForm.components[0].components;
                    let apiIndex = null;
                    const apiComponent = components.filter((c, i) => {
                        const isApi = c.key === 'api';
                        if (!isApi) {
                            return false;
                        }

                        apiIndex = i;

                        return true;
                    })[0];

                    if (!apiComponent) {
                        return;
                    }
                    let exits = checkDuplicateKeyOptions(apiComponent.components,'api_name');
                    if (exits > 0) {
                        return editForm;
                    }

                    apiComponent.components.splice(1, 0, {
                        type: 'textfield',
                        key: 'api_name',
                        tooltip: 'The name of this field in the API endpoint.',
                        id: 'api_name',
                        persistent: true,
                        input: true,
                        label: 'API Name',
                        dataSrc: "values",
                        validate: {
                            required: true,
                            pattern: '(\\w|\\w[\\w-.]*\\w)',
                            patternMessage: 'The property name must only contain alphanumeric characters, underscores, dots and dashes and should not be ended by dash or dot.',
                        }
                    });

                    apiComponent.components[0].tooltip = null;
                    editForm.components[0].components[3] = apiComponent;
                }


                function checkDuplicateKeyOptions(components,key = 'after_component') {
                    const hasField = components.filter((elem) => {
                        return elem.id === key;
                    });

                    return hasField.length;
                }

                function repairedJson(string) {
                    return string.replace(/[\u0000-\u0019]+/g,"");
                }

                function addOptionForm(keyParent,keyComponentSingle) {
                    for (const [field, option] of Object.entries(Formio.Components.components)) {
                        if (typeof option.editForm !== 'function') {
                            continue;
                        }
                        const fieldEditForm = option.editForm;

                        Formio.Components.components[field].editForm = function() {
                            var editForm = fieldEditForm();
                            updateApiNameField(editForm);
                            let exits = checkDuplicateKeyOptions(editForm.components[0].components[0].components,'after_component');
                            if (exits > 0) {
                                return editForm;
                            }
                            editForm.components[0].components[0].components
                                .splice(1, 0,
                                    {
                                        type: 'select',
                                        key: 'after',
                                        id: 'after_component',
                                        label: 'After Component',
                                        input: true,
                                        dataSrc: "values",
                                        data: {
                                            values: keyComponentSingle
                                        },
                                    });

                            editForm.components[0].components[0].components
                                .splice(1, 0,
                                    {
                                        type: 'select',
                                        key: 'parent',
                                        id: 'parent_component',
                                        input: true,
                                        label: 'In Parent',
                                        dataSrc: "values",
                                        data: {
                                            values: keyParent
                                        },
                                    });
                            return editForm;
                        };
                    }
                }

                function getInfoAttrParent(id) {
                    axios.get('{{route('question-platform.detail')}}', {
                        params: {'id': id}
                    })
                        .then((response) => {
                            if (!response.data.success) {
                                return;
                            }
                            if (response.data.data.platform) {
                                const attributeOptions = response.data.data.platform.attribute_options;
                                console.log('attributeOptions',attributeOptions);
                                if(attributeOptions) {
                                    const {keyParent,keyComponentSingle} = detachAttr(attributeOptions);
                                    addOptionForm(keyParent,keyComponentSingle);
                                }else {

                                }
                            }
                        })
                        .catch(function (error) {
                            console.log('error', error)

                        })
                }

                function detachAttr(attrParent) {
                    const keyParent = [];
                    const keyComponentSingle = [];
                    if(typeof attrParent != 'object') {
                        attrParent = repairedJson(attrParent);
                        attrParent = JSON.parse(attrParent);
                    }

                    Formio.Utils.eachComponent(attrParent, function(component) {
                        if (component.components) {
                            keyParent.push({"label":component.key,"value":component.key});

                            keyComponentSingle.push({"label":component.key,"value":component.key});

                            component.components.forEach((child)=>{
                                keyComponentSingle.push({"label":child.key,"value":child.key})
                            })
                        }
                    })

                    return {"keyParent" :keyParent,"keyComponentSingle" :keyComponentSingle};
                }


                $("#buttonCollapse").on('click', function (e) {
                    e.preventDefault();
                })

                const element = document.querySelectorAll(`[id^="api-select-"]`);
                $(element).on('select2:select', function (e) {
                    const optionSelected = $(this).find('option:selected');

                    if (optionSelected.val()) {
                        getInfoAttrParent(optionSelected.val());
                    }
                });


            })(jQuery)

        });
    </script>
@endpush
