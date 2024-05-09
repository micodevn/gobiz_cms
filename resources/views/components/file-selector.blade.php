<style>
    :root {
        --item-size: 150px;
    }

    .file-selector {
        width: 37px;
        height: 37px;
        border: dodgerblue 3px dashed;
        display: flex;
        cursor: pointer;
        position: relative;
    }

    .file-selector:before {
        font-family: "Font Awesome 5 Free";
        content: "\f067";
        display: inline-block;
        font-weight: 900;
        color: dodgerblue;
        margin: auto;
        font-size: 100%;
    }

    .file-selector.selected:after {
        content: attr(data-file-name);
        display: inline-block;
        font-weight: 600;
        color: dodgerblue;
        margin-top: auto;
        margin-bottom: 0;
        margin-left: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #file-selector-modal .modal-dialog .modal-body {
        width: 80vw;
        height: 70vh;
        display: flex;
        flex-direction: column;
    }

    #file-selector-modal .modal-dialog {
        margin-top: 5vh;
        margin-left: 10vw;
        max-width: 80vw;
    }

    .file-list {
        display: grid;
        grid-gap: 5px;
        grid-template-columns: repeat(auto-fit, minmax(var(--item-size), var(--item-size)));
        grid-template-rows: repeat(2, minmax(var(--item-size), var(--item-size)));
        grid-auto-rows: minmax(var(--item-size), auto);
        padding: 10px;
    }

    .file-list-viewport {
        overflow-y: scroll;
        width: 75%;
        float: left;
        height: 100%;
    }

    .file-info-viewport {
        width: 25%;
        overflow-y: auto;
        float: left;
        height: 100%;
    }

    .file-item {
        aspect-ratio: 1;
        cursor: pointer;
        background-color: gray;
        background-size: contain;
        user-select: none;
        position: relative;
    }

    .file-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .file-item-name {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgb(255 255 255 / 75%);
        font-size: 13px;
        padding: 0 10px;
        padding-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-item.selecting {
        position: relative;
    }

    .file-item.selecting::after {
        content: '';
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        border: var(--primary) thick solid;
    }

    .file-info {
        padding: 10px 10px;
    }

    .icon-image {
        width: 100%;
        height: 200px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-color: lightgray;
    }

    .file-selector.selected {
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        border: none;
    }

    .file-selector.selected::before {
        display: none;
    }

    .file-info .file-name {
        word-break: break-all;
    }

    .tab-content {
        height: calc(100% - 62px);
    }

    .tab-pane {
        height: 100%;
    }

    #myTabContent {
        flex: 1;
    }

    #drop-area {
        border: 2px dashed #ccc;
        border-radius: 20px;
        width: 100%;
        height: 100%;
        font-family: sans-serif;
        padding: 20px;
        margin-top: 10px;
        justify-content: center;
        align-items: center;
        display: flex;
        cursor: pointer;
    }

    #drop-area.highlight {
        border-color: purple;
    }

    #drop-area.uploading .upload-show {
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
        justify-content: center;
        align-items: center;
    }

    #drop-area .upload-show {
        display: none;
        background-color: white;
    }

    #drop-area .drag-text {
        font-size: 38px;
        color: rgb(128 128 128 / 50%);
    }

    #drop-area.uploading .drag-text {
        display: none;
    }

    #file-selector-tabs .search-form {
        display: flex;
        margin-left: 20px;
        align-items: center;
    }

    #file-selector-tabs .search-form b {
        line-height: 15px;
        white-space: nowrap;
        margin-right: 5px;
    }
</style>
<div class="modal fade" id="file-selector-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">File Selector</h5>

                <div class="search-form text-right w-75 ml-auto">
                    <input placeholder="Search . . ." type="text" class="form-control w-25"
                           style="display: inline-block" id="search_file_input">
                </div>
                <button type="button" class="close ml-1" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <x-loading></x-loading>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="file-selector-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#quick-upload" role="tab"
                           aria-controls="home" aria-selected="false">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="file-list-tab" data-toggle="tab" href="#file-tab-content"
                           role="tab" aria-controls="profile" aria-selected="true">Files</a>
                    </li>
                </ul>
                <form class="form-inline" id="form-link-static">
                    <div class="form-group mx-sm-3 mb-2" style="margin-left: 0!important">
                        <label for="inputStaticLink" class="sr-only"></label>
                        <input type="text" class="form-control"  id="inputStaticLink" placeholder="Static link">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                </form>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="quick-upload" role="tabpanel" aria-labelledby="home-tab">
                        <div id="drop-area" class="">
                            <div class="drag-text">
                                Drag file here to upload . . .
                            </div>
                            <div class="upload-show text-center">
                                <div class="progress w-100" id="upload-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar">

                                    </div>
                                </div>
                                <div>{{__("Uploading...")}}</div>
                            </div>
                        </div>
                        <input type="file" id="drag-input" class="d-none">
                    </div>
                    <div class="tab-pane fade show active" id="file-tab-content" role="tabpanel"
                         aria-labelledby="profile-tab">
                        <div class="file-list-viewport" style="position: relative">
                            <div class="file-list">

                            </div>
                        </div>
                        <div class="file-info-viewport">
                            <div class="file-info">
                                <div class="icon-image mb-2"></div>
                                <div>
                                    <b>Url: </b>
                                    <div class="d-flex">
                                        <div style="flex: 1" class="mr-2">
                                            <input type="text" readonly class="file-url form-control"/>
                                        </div>
                                        <a href="" class="btn btn-outline-secondary file-edit" target="_blank">
                                            Sửa
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <label>Name: </label>
                                    <p class="file-name"></p>
                                </div>
                                <div>
                                    <label>Type: </label>
                                    <p class="file-type"></p>
                                </div>
                                <div>
                                    <label>Size: </label>
                                    <p class="file-size"></p>
                                </div>
                                <div>
                                    <label>Uploaded at: </label>
                                    <p class="file-created-at"></p>
                                </div>
                                <div>
                                    <label>Uploaded by: </label>
                                    <p class="file-created-by"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none" id="file-item-clone">
                <div class="file-item">
                    <img src="" alt="">
                    <div class="file-item-name">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger remove-file"
                        data-bs-dismiss="modal">{{__("Remove")}}</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
                <button type="button" class="btn btn-primary choose-file">{{__("Choose File")}}</button>
            </div>
        </div>
    </div>
</div>
@push('page_scripts')
    <script>
        class FileSelector {
            constructor() {
                this.multiple = {{isset($multile) && $multile === true ? 'true' : 'false'}};
                this.caller = null;
                this.filter = {};
                this.self = this;
                this.selectedFile = null;
                this.currentType = 'all';
                this.modal = null;
                this.loadMore = true;
                this.page = 1;
                this.waitToSearch = null;
            }

            chooseFile() {
                if (this.multiple) {
                    this.chooseFiles();
                }

                const file = $("#file-selector-modal").find(".file-list .file-item.selecting").first();
                let fileData = JSON.parse(file.attr('data-json') || '{}');
                fileData = new UploadFile(fileData);

                if (this.caller.hasClass('with-input')) {
                    const inputId = this.caller.attr('data-input-id');
                    $("#" + inputId).val(fileData.id);
                }

                this.caller.attr('data-file-id', fileData.id || '');
                this.caller.trigger('file-selected', [fileData]);
                if (!fileData.id) {
                    this.caller.removeClass("selected");
                    this.caller.removeAttr("data-file-id");
                    this.caller.css('background-image', 'unset');
                    return;
                }

                this.setFile(this.caller, fileData);
            }

            chooseFiles() {

            }

            setCaller(e) {
                this.caller = $(e);
            }

            getCaller() {
                return this.caller;
            }

            setFilter(filter) {
                this.filter = filter;
            }

            setFile(ele, file) {
                if (typeof file === 'string') {
                    file = JSON.parse(file);
                }

                if (!file) {
                    return;
                }
                $(ele).addClass("selected");
                $(ele).css('background-image', "url('" + file.icon_file_path_url || file.file_path_url + "'), url('/storage/images/default-file.jpg')");
                $(ele).data('file-name', file.name);
                $(ele).attr('data-file', JSON.stringify(file));
                $(ele).attr('data-file-name', file.name);
                $(ele).attr('title', file.name);
            }

            init() {
                const that = this;
                this.modal = $("#file-selector-modal");
                $("#form-link-static").hide();
                jQuery.fn.fileSelector = function (method = '', value = '',fileName = '') {
                    const ele = this[0];
                    if (this.length === 1) {
                        switch (method) {
                            case 'id':
                                return jQuery(ele).data('id');
                            case 'setFile':
                                that.setFile(ele, value);
                                return;
                        }
                    }
                    this.each(function (index, ele) {
                        jQuery(ele).click(() => {
                            fileSelector.showFileSelectorModal(ele, true);
                        });
                    });
                };

                $(".file-list-viewport").on("scroll", (event) => {
                    if (event.target.offsetHeight + event.target.scrollTop >=
                        event.target.scrollHeight - 2 && that.loadMore === true) {
                        fileSelector.load(that.page, that.loadMore);
                    }

                });

                $(".file-selector").fileSelector();
                this.modal.find("button.choose-file").click((e) => {
                    if ($("#file-selector-modal").find(".selecting").length === 0) {
                        alert("File must be chosen");
                        e.preventDefault();
                        return;
                    }
                    this.chooseFile();
                    $("#file-selector-modal").modal('toggle');
                })
                this.modal.find("button.remove-file").click(() => {
                    $(".file-item").removeClass('selecting');
                    this.chooseFile();
                })

                //On Select Modal Off
                this.modal.on('hide.bs.modal', function (e) {
                    if (quickUploader.isUploading()) {
                        const confirmClose = confirm("Upload is in progressing. Are you sure ?");

                        if (confirmClose) {
                            quickUploader.cancelUploadProgress();
                        }
                    }
                });

                $("#search_file_input").on('input', (even) => {
                    if (that.waitToSearch) {
                        clearTimeout(that.waitToSearch);
                    }

                    that.waitToSearch = setTimeout(function () {
                        let textSearch = $("#search_file_input").val();
                        if (textSearch.length) {
                            fileSelector.load(0, true, {
                                text_search: textSearch
                            });
                        } else {
                            fileSelector.load(0, true);
                        }
                    }, 900);
                });

                $('.nav-tabs a').on('shown.bs.tab', function (event) {
                    if ($(event.target).html() === 'Files') {
                        $("#search_file_input").show();
                        $("#form-link-static").hide();
                    }
                });
                $('.nav-tabs a').on('hide.bs.tab', function (event) {
                    if ($(event.target).html() === 'Files') {
                        $("#search_file_input").hide();
                        $("#form-link-static").show();
                    }
                });


                $('#form-link-static').on('submit',(e) => {
                    e.preventDefault();
                    const inputs = $('#form-link-static :input');
                    const url = inputs.val();
                    this.isValidURL(url);
                    const extension = this.get_url_extension(url);
                    const typeName = fileHelper.mapExtensionToTypeName(extension);
                    this.createObjFile(typeName , url);
                    inputs.val('');
                });
            }

            isValidURL(string) {
                if (!string) alert("Missing url ");
                var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
                 if(res == null) {
                     alert("Link không đúng định dạng !")
                 }
                 return;
            }

             get_url_extension( url ) {
                return url.split(/[#?]/)[0].split('.').pop().trim();
            }

            get_name_file_relative( url ) {
                return url.split(/[#?]/)[0].split('/').pop().trim();
            }

            createObjFile(name_type ,url) {
                const name_file = fileSelector.get_name_file_relative(url) ?? '';
                const form = new FormData();
                form.append('type', name_type);
                form.append('name', name_file);
                form.append('url_static_options', url);

                axios.post("{{route('files.store')}}", form)
                    .then((response) => {
                        if (!response.data.success) {
                            return;
                        }
                        const file = new UploadFile(response.data.data.file);
                        quickUploader.loadAndSelect(file);

                        $("#file-list-tab").click();
                    }).catch(function (response) {

                }).then((response) => {
                    $("#drop-area").removeClass('uploading');
                    this.uploading = false;
                });
            }

            getFileSelectorCaller() {
                return $(this.caller);
            }

            loadInfo(file) {
                const root = $("#file-selector-modal");
                root.find('.icon-image').first().css('background-image', `url('${file.icon_file_path_url}')`);
                root.find('.file-name').first().html(file.name);
                root.find('.file-description').first().html(file.description);
                root.find('.file-type').first().html(file.type);
                root.find('.file-size').first().html(file.size);
                root.find('.file-created-at').first().html(file.created_at);
                root.find('.file-created-by').first().html(file.creator?.name);
                root.find('.file-url').first().val(file.file_path_url);
                root.find('.file-edit').first().attr('href', '/files/' + file.id + '/edit');
            }

            resetInfo() {
                this.loadInfo(new UploadFile());
                quickUploader.cancelUploadProgress();
            }

            selectFile(file) {
                this.selectByElement($("#file-selector-" + file.id), file);
            }

            selectByElement(ele, file) {
                if (!this.multiple && !ele.hasClass('selecting')) {
                    $(".file-item").removeClass('selecting');
                }
                if (!ele.hasClass('selecting')) {
                    fileSelector.loadInfo(file);
                }
                fileSelector.selectedFile = file;

                ele.toggleClass('selecting');
            }

            insertFile(file, before = false) {
                file = new UploadFile(file);
                const clone = $("#file-item-clone").find('.file-item').first().clone();
                const list = $("#file-selector-modal").find('.modal-body .file-list').first();
                const that = this;
                clone.find('img').first().attr('src', file.icon_file_path_url || file.file_path_url);
                clone.find('.file-item-name').first().html(file.name);
                clone.attr('title', file.name);
                clone.attr('id', 'file-selector-' + file.id);

                $(clone).attr('data-json', JSON.stringify(file));
                if (before) {
                    list.prepend(clone);
                } else {
                    list.append(clone);
                }

                clone.click(function () {
                    const ele = $(this);
                    that.selectByElement(ele, file);
                });
            }

            load(page = 0, loadMore = false, options = {}, callback = null) {
                const that = this;
                const caller = this.caller;
                const filterType = $(caller).data('filter-type');
                const list = $("#file-selector-modal").find('.modal-body .file-list').first();
                if (page === 0) {
                    list.html('');
                }
                if (loadMore) {
                    fileSelector.page = page + 1;

                    let params = {
                        filter_type: filterType,
                        page: fileSelector.page,
                        limit: 40
                    }

                    if (options.text_search) {
                        params.name = options.text_search;
                    }

                    if (options.without_id) {
                        params.without_id = options.without_id;
                    }

                    axios.get('{{route('file.options')}}', {
                        params: params
                    })
                        .then((response) => {
                            $(".middle").css("display", "none");

                            if (response.data.data.data.length >= 1) {
                                response.data.data.data.forEach((file) => {
                                    this.insertFile(file);
                                });
                            } else {
                                that.loadMore = false;
                            }
                        })
                        .catch(function (error) {
                            // handle error
                        })
                        .then(() => {
                            callback && callback();
                        });
                }
            }

            loadSingle(id, callback) {
                if (!id) {
                    callback(null);
                    return;
                }

                axios.get('/api/file/' + id)
                    .then((response) => {
                        console.log(response)
                        callback(response.data.data.file);
                    })
                    .catch(function (error) {
                        callback(null);
                    })
                    .then(() => {
                        // always executed
                    });
            }

            showFileSelectorModal(e, loadMore, page) {
                this.resetInfo();
                $("#file-selector-modal").modal("show");
                $("#file-selector-modal").attr('caller', getUniqueSelector(e));
                const filterType = $(e).data('filter-type') || 'all';
                const selectedFileId = $(e).data('file-id');
                this.loadSingle(selectedFileId, (file) => {
                    this.currentType = filterType;
                    fileSelector.setCaller(e);
                    fileSelector.setFilter({
                        'type': filterType
                    })
                    const options = {};

                    if (file) {
                        options.without_id = selectedFileId;
                    }
                    console.log(page, loadMore)
                    fileSelector.load(page, loadMore, options, () => {
                        if (file) {
                            fileSelector.insertFile(file, true);
                            fileSelector.selectFile(file);
                        }
                    });
                });
            }
        }

        class UploadFile {
            constructor(data = {}) {
                this.loadData(data);
            }

            loadData(data) {
                this.description = data.description || '';
                this.file_path = data.file_path || '';
                this.file_path_url = data.file_path_url || '';
                this.icon_file_path = data.icon_file_path || '';
                this.icon_file_path_url = data.icon_file_path_url || '';
                this.id = data.id || '';
                this.name = data.name || '';
                this.size = data.size || '';
                this.type = data.type || '';
                this.video_timestamps = data.video_timestamps || [];
                this.video_subtitles = data.video_subtitles || [];
                this.uploader = null;
                this.created_at = data.created_at || '';
                this.creator = data.creator;
            }

            getTimestampOptions(selectedValue = null) {
                const options = [];
                let option = '';
                this.video_timestamps.forEach(function (e) {
                    if(selectedValue) {
                        selectedValue.find((elem) => {
                           if (elem == e.id) {
                               option = new Option(e.title, e.id,false,true);
                           }
                        })
                    }else {
                         option = new Option(e.title, e.id);
                    }

                    options.push(option);
                });

                return options;
            }
        }

        class QuickUploader {
            constructor() {
                this.cancelToken = null;
                this.uploading = false;
                this.progressBar = null;
            }

            init() {
                this.dropArea = document.getElementById('drop-area');
                this.progressBar = $("#upload-progress .progress-bar").first();
                const that = this;

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    this.dropArea.addEventListener(eventName, (e) => {
                        this.preventDefaults(e);
                    }, false)
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    this.dropArea.addEventListener(eventName, (e) => {
                        this.highlight(e);
                    }, false)
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    this.dropArea.addEventListener(eventName, (e) => {
                        this.unhighlight(e);
                    }, false)
                })

                this.dropArea.addEventListener('drop', (e) => {
                    this.handleDrop(e);
                }, false);

                $(this.dropArea).click(function (e) {
                    $("#drag-input").click();
                });

                $("#drag-input").change(function (e) {
                    let files = this.files;
                    if (files.length < 1) {
                        return;
                    }

                    that.uploadFile(files[0]);
                });
            }

            highlight(e) {
                this.dropArea.classList.add('highlight');
            }

            unhighlight(e) {
                this.dropArea.classList.remove('highlight');
            }

            preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                if (files.length < 1) {
                    return;
                }

                this.uploadFile(files[0]);
            }

            loadAndSelect(file) {
                fileSelector.insertFile(file, true);
                fileSelector.selectFile(file);
            }

            cancelUploadProgress() {
                if (this.cancelToken) {
                    this.cancelToken.cancel();
                }
            }

            resetUploadProgress() {

            }

            updateUploadProgress(percent) {
                this.progressBar.css('width', percent + "%")
            }

            isUploading() {
                return this.uploading;
            }

            uploadFile(file) {
                const form = new FormData();
                form.append('file_path', file);
                form.append('name', file.name);
                let type = fileHelper.getType(file);
                if (!type) {
                    alert('File type not support !');
                    return false;
                }

                type = type.toLowerCase();

                form.append('type', type);

                if (fileSelector.currentType !== type && fileSelector.currentType !== 'all') {
                    alert('Current file\'s type not allowed !');
                    return false;
                }
                $("#drop-area").addClass('uploading');

                this.cancelToken = axios.CancelToken.source();
                const config = {
                    onUploadProgress: progressEvent => {
                        const progress = (progressEvent.loaded / progressEvent.total) * 100;
                        this.updateUploadProgress(progress);
                    },
                    cancelToken: this.cancelToken.token
                };

                this.uploading = true;
                axios.post("{{route('files.store')}}", form, config)
                    .then((response) => {
                        if (!response.data.success) {
                            return;
                        }

                        const file = new UploadFile(response.data.data.file);
                        this.loadAndSelect(file);

                        $("#file-list-tab").click();
                    }).catch(function (response) {

                }).then((response) => {
                    $("#drop-area").removeClass('uploading');
                    this.uploading = false;
                });
            }
        }

        const fileSelector = new FileSelector();
        const quickUploader = new QuickUploader();

        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                fileSelector.init();
                quickUploader.init();
            })(jQuery);
        });
    </script>
@endpush
