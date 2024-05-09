<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
</div>
@push('page_scripts')
    <script>
        const FieldComponent = Formio.Components.components.field;
        const editForm = Formio.Components.components.nested.editForm;

        /**
         * Here we will derive from the base component which all Form.io form components derive from.
         *
         * @param component
         * @param options
         * @param data
         * @constructor
         */
        class FileSelectorCustom extends FieldComponent {
            constructor(component, options, data) {
                super(component, options, data);
                this.input = null;
                this.value = null;
                this.fileData = null;
            }

            static schema() {
                return FieldComponent.schema({
                    type: 'fileSelector'
                });
            }

            static builderInfo() {
                return {
                    title: 'File Selector',
                    group: 'basic',
                    icon: 'fa fa-table',
                    weight: 70,
                    schema: FileSelectorCustom.schema()
                };
            }

            attach(element) {
                const input = $(element).find('.file-selector').first();
                const that = this;
                if(input) {
                    $(input).on('file-selected', function (e, fileData) {
                        that.value = fileData.id;
                        that.fileData = fileData;
                    });
                }
                return super.attach(element);
            }

            render(child) {
                const attrs = super.elementInfo().attr;
                const inputId = super.elementInfo().component.id + '_input';
                const wrapper = document.createElement('div');
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('id', inputId);
                //init attributes
                for (let key in attrs) {
                    hiddenInput.setAttribute(key, attrs[key]);
                }

                if (this.value) {
                    hiddenInput.value = this.value;
                }

                hiddenInput.setAttribute('type', 'hidden');

                this.input = document.createElement('a');
                this.input.classList.add('file-selector');
                this.input.classList.add('with-input');
                this.input.setAttribute('data-input-id', inputId);
                hiddenInput.setAttribute('data-attribute-type', '{{\App\Models\QuestionAttributes::TYPE_RELATION}}');

                hiddenInput.setAttribute('data-attribute-type-option', '<?= str_replace('\\', '\\\\', \App\Models\File::class) ?>');

                if(super.elementInfo().component.type_file) {
                    $(this.input).attr('data-filter-type',this.component.type_file.toLowerCase())
                }

                if (this.fileData) {
                    $(this.input).fileSelector('setFile', this.fileData);
                }

                wrapper.appendChild(hiddenInput);
                wrapper.appendChild(this.input);
                this.events.onAny(function (event) {
                    if (event === 'formio.componentChange') {
                        const fileSelectorCustom = new FileSelectorCustom;
                        $('[data-input-id="'+inputId+'"]').first().off('file-selected');
                        $('[data-input-id="'+inputId+'"]').first().on('file-selected', function (e, fileData) {
                            fileSelectorCustom.addSelectTimeStamp(this,fileData);
                        });
                    }
                });
                return super.render(wrapper.outerHTML);
            }

            // /**
            //  * Get the value of the component from the dom elements.
            //  *
            //  * @returns {Array}
            //  */
            // getValue() {
            //     return this.value;
            // }


            /**
             * Set the value of the component into the dom elements.
             *
             * @param value
             * @returns {boolean}
             */
            setValue(value) {
                if (value) {
                    this.value = value;
                    this.getDetailFile(value,(file) => {
                        this.fileData = file;
                        const inputId = super.elementInfo().component.id + '_input';
                        const attr = $('#' + inputId).next();
                        this.addSelectTimeStamp(attr,file);
                    });
                }
            }

            addSelectTimeStamp(elem,fileData) {
                if (fileData.type === VIDEO_TIMESTAMPS) {

                   let valueQuestion =  $("#value-question").val()
                    if(valueQuestion) {
                        valueQuestion = JSON.parse(valueQuestion);
                    }

                    $("#video_timestamps_custom").remove();
                    const file = new UploadFile(fileData);
                    const videoTimestampSelected = valueQuestion.question_content && valueQuestion.question_content.video_timestamps ? valueQuestion.question_content.video_timestamps : null;
                    const options = file.getTimestampOptions(videoTimestampSelected);

                    const selectAll = `<div class="form-check">
                                    <input class="form-check-input" name="data[question_content][all_type_timestamp]" value="1" id="all_timestamp" type="checkbox">
                                        <label class="form-check-label" for="all_timestamp">
                                            Select All
                                        </label>
                                </div>`;
                    var select = '<div id="video_timestamps_custom">' + selectAll +
                        ' <select class="form-control" id="select_video_timeStamps"  multiple name="data[question_content][video_timestamps][]"></select></div>';
                    $(elem).after(select)

                    if (valueQuestion.question_content && valueQuestion.question_content.all_type_timestamp != 0) {
                        $("#all_timestamp").prop("checked","checked").trigger('change')
                        $("#select_video_timeStamps").prop('disabled',true)
                    }

                    $("#all_timestamp").on('click',() => {
                        if ($("#all_timestamp").prop("checked")) {
                            $("#select_video_timeStamps").prop('disabled','true');
                        }else {
                            $("#select_video_timeStamps").prop('disabled',false);
                        }
                    })

                    $("#select_video_timeStamps").select2({
                        placeholder: "Search for an Item",
                        allowClear: true,
                        theme: 'bootstrap4',
                        width: '100%',
                    });


                    options.forEach((element) => {
                        $('#select_video_timeStamps').append(element);
                    });
                    $(elem).trigger('change')
                }
            }

            getDetailFile(id,callBack) {
                axios.get('/api/file/' + id)
                    .then((response) => {
                        if (!response.data.success) {
                            return;
                        }
                        if (response.data.data.file) {
                            const inputElement = $(this.element).find('input')
                            inputElement.val(id);
                            const attr = inputElement.next();
                            $(attr).fileSelector('setFile', response.data.data.file)
                            callBack(response.data.data.file)
                        }

                    })
                    .catch(function (error) {
                        console.log('error', error)
                    })
            }

        }

        const fieldEditForm = FileSelectorCustom.editForm;

        FileSelectorCustom.editForm = function() {
            var editForm = fieldEditForm();
            editForm.components[0].components[0].components
                .splice(1, 0,
                    {
                        type: 'select',
                        key: 'type_file',
                        id: 'type_file_component',
                        label: 'Type File Selector Component',
                        input: true,
                        dataSrc: "values",
                        data: {
                            values: typeFileSelect
                        },
                        validate: {
                            required: true
                        }
                    });
            return editForm;
        };

        Formio.use({
            components: {
                fileSelector: FileSelectorCustom
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {

            })(jQuery);
        });

    </script>
@endpush