<div class="modal fade" id="example-response-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Json example</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <pre id="review-response"></pre>
            </div>
            <div class="modal-footer">
{{--                <button type="button" id="copy-example" class="btn btn-primary">Copy</button>--}}
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script>

        class ResponseExample {
            constructor() {
                this.question_id = null;
                this.platform_id = null;
            }

            init() {
                jQuery.fn.responseExample = function () {
                    this.each(function (index, ele) {
                        jQuery(ele).click(() => {
                            responseExample.show(ele, true);
                        });
                    });
                };

                $(".responseExample").responseExample();
                this.question_id = $(".responseExample").attr('data-id-questions') ?? null;

                $('#copy-example').on('click',() => {
                    responseExample.copyToClipboard('#review-response')
                });
            }

            formItemsToJson(FormElement) {
                let formDataEntries = new FormData(FormElement).entries();
                const handleChild = function (obj, keysArr, value) {
                    let firstK = keysArr.shift();
                    firstK = firstK.replace(']', '');
                    if (keysArr.length == 0) {
                        if (firstK == '') {
                            if (!Array.isArray(obj)) obj = [];
                            obj.push(value);
                        } else obj[firstK] = value;
                    } else {
                        if (firstK == '') obj.push(value);
                        else {
                            if (!(firstK in obj)) obj[firstK] = {};
                            obj[firstK] = handleChild(obj[firstK], keysArr, value);
                        }
                    }
                    return obj;
                };
                let result = {};
                for (const [key, value] of formDataEntries)
                    result = handleChild(result, key.split(/\[/), value);
                return result;
            }

            copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).html()).select();
                document.execCommand("copy");
                // $temp.remove();
            }

            show() {
                const formData = new FormData();
                const radar = document.getElementById('radar');
                const form = $(radar).parents('form')[0];

                const attributeTypes = {};
                const modelTypeField = $('<input/>').attr('type', 'hidden');
                modelTypeField.attr('name', 'attribute_types');

                const typeElements = $(form).find('[data-attribute-type]');

                typeElements.each(function (i, e) {
                    const ele = $(e);
                    attributeTypes[ele.attr('name')] = {
                        type: ele.attr('data-attribute-type'),
                        type_option: ele.attr('data-attribute-type-option')
                    };
                });
                modelTypeField.val(JSON.stringify(attributeTypes));

                $(radar).parents('form').append(modelTypeField);

                const data = this.formItemsToJson($(radar).parents('form')[0])

                this.platform_id = $(".responseExample").attr('data-id-platform') ?? null;

                formData.append('data',JSON.stringify(data))
                formData.append('question_id',this.question_id)
                formData.append('platform_id',this.platform_id)

                responseExample.load(formData);
                $("#example-response-modal").modal();

            }

            load(formData) {
                axios.post("{{route('question.response.attribute.example')}}", formData)
                    .then((response) => {
                        if (!response.data.success) {
                            return;
                        }
                        console.log('response.data.data',JSON.stringify(response.data.data))
                        $("#review-response").text(JSON.stringify(response.data.data, null, "\t"));
                    }).catch(function (response) {

                }).then((response) => {
                });
            }
        }

        const responseExample = new ResponseExample();
        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                responseExample.init()
            })(jQuery);
        });
    </script>
@endpush
