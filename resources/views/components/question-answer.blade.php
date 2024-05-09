<?php
$qAnswers = $question->question_answers_parsed;
?>
<div class="d-flex py-2 text-center justify-content-center align-items-center" style="background-color: lightsteelblue">
    <h5 class="card-title">{{__('Question Answers')}}</h5>
</div>
<div class="{{$class}}">
    <table class="table table-bordered qa-table" id="qa-table">
        <thead>
        <tr>
            <td>ID</td>
            <td>Text</td>
            <td>Image</td>
            <td>Voice</td>
            <td>Anim File</td>
            <td>Position</td>
            <td>Right Response</td>
            <td>#</td>
        </tr>
        </thead>
        <tbody>
        @foreach($qAnswers as $qAnswer)
            <?php
            /** @var $qAnswer */
            $id = Arr::get($qAnswer, 'id');
            $text = Arr::get($qAnswer, 'text.value');
            $image = Arr::get($qAnswer, 'image.id');
            $imageData = Arr::get($qAnswer, 'image', []);
            $imageUrl = Arr::get($qAnswer, 'image.url');
            $audio = Arr::get($qAnswer, 'audio.id');
            $audioData = Arr::get($qAnswer, 'audio');
            $audioUrl = Arr::get($qAnswer, 'audio.url');
            $rightResponse = Arr::get($qAnswer, 'right_response');
            $animUrl = Arr::get($qAnswer, 'animation.url');
            $animData = Arr::get($qAnswer, 'animation');
            $animId = Arr::get($qAnswer, 'animation.id');
            $animPosX = Arr::get($qAnswer, 'animation.position.x');
            $animPosY = Arr::get($qAnswer, 'animation.position.y');
            ?>
            <tr>
                <td width="60px">
                    <input value="{{$id}}" readonly type="text" class="form-control" data-qa data-qa-field="id">
                </td>
                <td>
                    <input value="{{$text}}" type="text" class="form-control" data-qa data-qa-field="text">
                </td>
                <td width="70px">
                    <input data-type="image" value="{{$image}}" type="hidden"
                           class="form-control" data-qa data-qa-field="image">
                    <button
                        data-url="{{$imageUrl}}"
                        data-file="{{json_encode($imageData)}}"
                        data-input="input[data-qa-field='image']"
                        style="width: 70px; height: 70px"
                        class="file-selector"
                        type="button"
                        data-file-id="{{$image}}"
                        data-filter-type="image"
                    ></button>
                </td>
                <td width="70px">
                    <input data-type="audio" value="{{$audio}}" type="hidden"
                           class="form-control" data-qa data-qa-field="audio">
                    <button
                        data-url="{{$audioUrl}}"
                        data-file="{{json_encode($audioData)}}"
                        data-input="input[data-qa-field='audio']" style="width: 70px; height: 70px" class="file-selector"
                        data-file-id="{{$audio}}"
                        type="button" data-filter-type="audio"></button>
                </td>
                <td width="70px">
                    <input type="hidden" value="{{$animId}}" class="form-control" data-qa data-qa-field="anim-File">
                    <button data-input="input[data-qa-field='anim-File']" style="width: 70px; height: 70px"
                            data-url="{{$animUrl}}"
                            data-file="{{json_encode($animData)}}"
                            data-file-id="{{$animId}}"
                            class="file-selector" type="button" data-filter-type="asset_bundle"></button>
                </td>
                <td>
                    <input type="text" class="form-control" value="{{$animPosX}}" data-qa data-qa-field="anim-PosX">
                    <input type="text" class="form-control" value="{{$animPosY}}" data-qa data-qa-field="anim-PosY">
                </td>
                <td>
                    <textarea class="form-control" rows="3" data-qa
                              data-qa-field="right_response">{{$rightResponse}}</textarea>
                </td>
                <td>
                    <button onclick="removeRow(this)" type="button" class="btn btn-danger">x</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-right mt-2">
        <button onclick="addAnswerRow()" type="button" class="btn btn-outline-secondary btn-sm">+ Add Answer
        </button>
    </div>
    <div class="d-none" id="qa-row-clone">
        <table>
            <tbody>
            <tr>
                <td width="80px">
                    <input readonly type="text" class="form-control" data-qa data-qa-field="id">
                </td>
                <td>
                    <input type="text" class="form-control" data-qa data-qa-field="text">
                </td>
                <td width="70px">
                    <input type="hidden" class="form-control" data-qa data-qa-field="image">
                    <button data-input="input[data-qa-field='image']" style="width: 70px; height: 70px"
                            class="file-selector" type="button" data-filter-type="image"></button>
                </td>
                <td width="70px">
                    <input type="hidden" class="form-control" data-qa data-qa-field="audio">
                    <button data-input="input[data-qa-field='audio']" style="width: 70px; height: 70px"
                            class="file-selector" type="button" data-filter-type="audio"></button>
                </td>
                <td width="70px">
                    <input type="hidden" class="form-control" data-qa data-qa-field="anim-File">
                    <button data-input="input[data-qa-field='anim-File']" style="width: 70px; height: 70px"
                            class="file-selector" type="button" data-filter-type="asset_bundle"></button>
                </td>
                <td>
                    <input type="text" class="form-control" data-qa data-qa-field="anim-PosX">
                    <input type="text" class="form-control" data-qa data-qa-field="anim-PosY">
                </td>
                <td>
                    <textarea class="form-control" rows="3" data-qa data-qa-field="right_response"></textarea>
                </td>
                <td>
                    <button onclick="removeRow(this)" type="button" class="btn btn-danger">x</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@push('page_scripts')
    <script>
        function reIndex() {
            $("#qa-table").find('tbody tr').each(function (i, e) {
                $(e).find('input[data-qa-field="id"]').first().val(i + 1);
            });
        }

        function addAnswerRow() {
            const row = $("#qa-row-clone").find("tr").first().clone();
            $("#qa-table").find('tbody').append(row);
            row.find('input[type="checkbox"]').attr('data-toggle', 'toggle');
            $('input[data-toggle="toggle"]').bootstrapToggle();
            $(".file-selector").fileSelector();
            $(".file-selector").on('file-selected', function (e, file) {
                const input = $(e.target).siblings('input').first();
                $(input).val(file.id);
            });
            loadAllResourceInput();
            addResourceInputEvent();
            reIndex();
        }

        function removeRow(e) {
            $(e).closest('tr').first().remove();
            reIndex();
        }

        function loadAllResourceInput() {
            $("#qa-table").find('.file-selector').each(function (i, e) {
                loadResource(e);
            });
        }

        function loadResource(e) {
            const url = $(e).data('url');
            const data = $(e).data('file');
            const type = $(e).data('type');
            if (!data) {
                return;
            }
            data.id && $(e).fileSelector('setFile', data);
        }

        function addResourceInputEvent() {
            $('.file-selector').on('file-selected', function (e, file) {
                const self = $(this);
                const inputSelector = self.attr('data-input');
                const input = self.siblings(inputSelector).first();
                if (!input) {
                    return false;
                }

                $(input).val(file.id);
            });
        }

        $(document).ready(function() {
            loadAllResourceInput();
            addResourceInputEvent();
        })
    </script>
@endpush
