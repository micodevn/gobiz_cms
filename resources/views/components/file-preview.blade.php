<?php
    /**
     * @var $withType
     * @var $name
     * @var $url
     * @var $type
     */
?>
<style>
    .preview-box {
        display: none;
        text-align: center;
    }
</style>

<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">File Previewer</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="preview-container">
                    <div id="audio-preview-box" class="preview-box">
                        <audio controls id="audio-preview"></audio>
                    </div>

                    <div id="video-preview-box" class="preview-box">
                        <video width="100%" controls id="video-preview"></video>
                    </div>

                    <div id="image-preview-box" class="preview-box">
                        <img width="100%" controls id="image-preview" />
                    </div>

                    <div id="pdf-preview-box" class="preview-box" style="height: 80vh;">
                        <object width="100%" height="100%" data="" id="pdf-preview"></object>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
    <script>
        class FilePreviewer {
            constructor() {

            }

            init() {
                $('#preview-modal').on('hide.bs.modal', (e) => {
                    this.resetPreviewBox();
                });
            }

            previewAudio(file) {
                $("#audio-preview-box").show();
                $("#audio-preview").attr('src', fileHelper.getFileUrl(file));
            }

            resetAudio() {
                $("#audio-preview").trigger('pause');
                $("#audio-preview").removeAttr("src");
            }

            previewVideo(file) {
                $("#video-preview-box").show();
                $("#video-preview").attr('src', fileHelper.getFileUrl(file));
            }

            previewImage(file) {
                $("#image-preview-box").show();
                $("#image-preview").attr('src', fileHelper.getFileUrl(file));
            }

            previewPdf(file) {
                $("#pdf-preview-box").show();
                const previewer = $("#pdf-preview").clone();
                $("#pdf-preview").remove();
                $("#pdf-preview-box").append(previewer);
                previewer.attr('data', fileHelper.getFileUrl(file));
            }

            resetVideo() {
                $("#video-preview").trigger('pause');
                $("#video-preview").removeAttr("src");
            }

            resetPreviewBox() {
                $(".preview-box").hide();
                this.resetAudio();
                this.resetVideo();
            }

            previewFile(f = null, type = null) {
                const file = fileHelper.getFileUrl(f);
                if (!file) {
                    return;
                }
                this.resetPreviewBox();

                switch (type) {
                    case AUDIO:
                        this.previewAudio(file);
                        break;
                    case VIDEO:
                    case VIDEO_TIMESTAMPS:
                        this.previewVideo(file);
                        break;
                    case IMAGE:
                        this.previewImage(file);
                        break;
                    case PDF:
                        this.previewPdf(file);
                        break;
                }

                $("#preview-modal").modal('show');
            }
        }

        const filePreviewer = new FilePreviewer();
        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                filePreviewer.init();
            })(jQuery);
        });
    </script>
@endpush
