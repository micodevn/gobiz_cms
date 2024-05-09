{!! Form::select($id, [], null, ['class' => 'form-control no-init', 'name' => $id . '[]']) !!}
@push('page_css')
    <style>
        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
            margin-right: 1px;
            margin-left: 0;
            color: #bdc6d0;
            border: none;
            border-radius: 2px;
        }
    </style>
@endpush
@push('page_scripts')
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', function () {
            $("#{{ $id }}").select2({
                theme: 'bootstrap4',
                ajax: {
                    url: "{{ $url }}",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            kw: params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items,
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for an item',
                minimumInputLength: 1,
                multiple: true,
                // templateResult: formatRepo,
                // templateSelection: formatRepoSelection
            });

            // function formatRepo (repo) {
            //     if (repo.loading) {
            //         return repo.text;
            //     }
            //
            //     var $container = $(
            //         "<div class='select2-result-repository clearfix'>" +
            //             "<div class='select2-result-repository__meta'>" +
            //                 "<div class='select2-result-repository__title'></div>" +
            //                 "<div class='select2-result-repository__description'></div>" +
            //             "</div>" +
            //         "</div>"
            //     );
            //
            //     $container.find(".select2-result-repository__title").text(repo.id);
            //     $container.find(".select2-result-repository__description").text(repo.text);
            //
            //     return $container;
            // }
            //
            // function formatRepoSelection (repo) {
            //     return repo.full_name || repo.text;
            // }

            // Fetch the preselected item, and add to the control
            let studentSelect = $('#{{ $id }}');
            $.ajax({
                type: 'GET',
                url: '{{ $defaultValuesUrl }}',
                data: {
                    kw: ''
                }
            }).then(function (data) {
                data.items.forEach((item) => {
                    // create the option and append to Select2
                    let option = new Option(item.text, item.id, true, true);
                    studentSelect.append(option)
                    return item;
                }).then((item) => {
                    // create the option and append to Select2
                    studentSelect.trigger('change');
                    // manually trigger the `select2:select` event
                    studentSelect.trigger({
                        type: 'select2:select',
                        params: {
                            data: item
                        }
                    });
                });
            });
        });
    </script>
@endpush
