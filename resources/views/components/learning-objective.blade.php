<style>
    :root {
        --item-size: 150px;
    }

    #exampleModalCenter .modal-dialog .modal-body {
        width: 80vw;
        height: 70vh;
        display: flex;
        flex-direction: column;
    }

    #exampleModalCenter .modal-dialog {
        margin-top: 5vh;
        margin-left: 10vw;
        max-width: 80vw;
        width: 100vw;
    }


    #exampleModalCenter {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        color: #2c2c2c;
    }

    #exampleModalCenter a {
        color: inherit;
        text-decoration: none;
    }

    .content-obj {
        width: 100%;
        height: 100%;
    }

    .content__title {
        margin-bottom: 40px;
        font-size: 20px;
        text-align: center;
    }

    .content__title--m-sm {
        margin-bottom: 10px;
    }

    .learning-obj-form__progress {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
        margin-top: 10px;
    }

    .learning-obj-form__progress-btn {
        transition-property: all;
        transition-duration: 0.15s;
        transition-timing-function: linear;
        transition-delay: 0s;
        position: relative;
        padding-top: 20px;
        color: rgba(108, 117, 125, 0.7);
        text-indent: -9999px;
        border: none;
        background-color: transparent;
        outline: none !important;
        cursor: pointer;
    }

    @media (min-width: 500px) {
        .learning-obj-form__progress-btn {
            text-indent: 0;
        }
    }

    .learning-obj-form__progress-btn:before {
        position: absolute;
        top: 0;
        left: 50%;
        display: block;
        width: 13px;
        height: 13px;
        content: '';
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%);
        transition: all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
        transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
        transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
        border: 2px solid currentColor;
        border-radius: 50%;
        background-color: #fff;
        box-sizing: border-box;
        z-index: 3;
    }

    .text_session {
        color: green;
        line-height: 4.0;
    }

    .result_label {
        line-height: 2.0;
    }

    .learning-obj-form__progress-btn:after {
        position: absolute;
        top: 5px;
        left: calc(-50% - 13px / 2);
        transition-property: all;
        transition-duration: 0.15s;
        transition-timing-function: linear;
        transition-delay: 0s;
        display: block;
        width: 100%;
        height: 2px;
        content: '';
        background-color: currentColor;
        z-index: 1;
    }

    .learning-obj-form__progress-btn:first-child:after {
        display: none;
    }

    .learning-obj-form__progress-btn.js-active {
        color: #007bff;
    }

    .learning-obj-form__progress-btn.js-active:before {
        -webkit-transform: translateX(-50%) scale(1.2);
        transform: translateX(-50%) scale(1.2);
        background-color: currentColor;
    }

    .learning-obj-form__form {
        position: relative;
    }

    .learning-obj-form__panel {
        /*position: absolute;*/
        /*top: 0;*/
        /*left: 0;*/
        width: 100%;
        /*height: 0;*/
        opacity: 0;
        visibility: hidden;
        display: none;
    }

    .learning-obj-form__panel.js-active {
        height: auto;
        opacity: 1;
        visibility: visible;
        display: block;
    }

    .learning-obj-form__panel[data-animation="scaleOut"] {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .learning-obj-form__panel[data-animation="scaleOut"].js-active {
        /*transition-property: all;*/
        /*transition-duration: 0.2s;*/
        /*transition-timing-function: linear;*/
        /*transition-delay: 0s;*/
        /*-webkit-transform: scale(1);*/
        /*transform: scale(1);*/
    }

    .learning-obj-form__panel[data-animation="slideHorz"] {
        left: 50px;
    }

    .learning-obj-form__panel[data-animation="slideHorz"].js-active {
        transition-property: all;
        transition-duration: 0.25s;
        transition-timing-function: cubic-bezier(0.2, 1.13, 0.38, 1.43);
        transition-delay: 0s;
        left: 0;
    }

    .learning-obj-form__panel[data-animation="slideVert"] {
        top: 30px;
    }

    .learning-obj-form__panel[data-animation="slideVert"].js-active {
        transition-property: all;
        transition-duration: 0.2s;
        transition-timing-function: linear;
        transition-delay: 0s;
        top: 0;
    }

    .learning-obj-form__panel[data-animation="fadeIn"].js-active {
        transition-property: all;
        transition-duration: 0.3s;
        transition-timing-function: linear;
        transition-delay: 0s;
    }

    .learning-obj-form__panel[data-animation="scaleIn"] {
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
    }

    .learning-obj-form__panel[data-animation="scaleIn"].js-active {
        transition-property: all;
        transition-duration: 0.2s;
        transition-timing-function: linear;
        transition-delay: 0s;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .list-verb :hover {
        cursor: pointer;
    }

    .list-verb {
        color: #0a6aa1;
        width: 10px;
        height: 10px;
        border-radius: 5px;
    }

    /* Custom Scrollbar using CSS */
    .custom-scrollbar-css {
        overflow-y: scroll;
    }

    /* scrollbar width */
    .custom-scrollbar-css::-webkit-scrollbar {
        width: 5px;
    }

    /* scrollbar track */
    .custom-scrollbar-css::-webkit-scrollbar-track {
        background: #eee;
    }

    /* scrollbar handle */
    .custom-scrollbar-css::-webkit-scrollbar-thumb {
        border-radius: 1rem;
        background-color: #00d2ff;
        background-image: linear-gradient(to top, #00d2ff 0%, #3a7bd5 100%);
    }

    .input-verb {
        border: 2px solid #053261;
        border-radius: 4px;
    }

    li input, li label {
        cursor: pointer;
        user-select: none;
        font-weight: normal;
    }

    .content__inner {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .learning-obj-form {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .learning-obj-form__content {
        flex: 1;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Tạo Learning Objective</h5>
                <button type="button" class="close ml-1" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="err_session" class="alert-danger"></div>
            <div class="modal-body">
                <div class="content-obj">
                    <div class="content__inner">
                        <div class="container">
                            {{--                            <h2 class="content__title content__title--m-sm">Result</h2>--}}
                            <form class="pick-animation my-4">
                                <div class="form-row">
                                    <div class="col-12 m-auto text-center result_label">
                                        Học sinh có thể <u class="text_session_verb text_session"> [ Hành động ] </u> <u
                                                class="text_session_content text_session"> [ Mục tiêu ] </u> <u
                                                class="text_session_conditional text_session"> [ Hoàn cảnh ] </u>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="container" style="flex: 1;">
                            <div class="learning-obj-form">
                                <div class="row">
                                    <div class="col-12 col-lg-10 ml-auto mr-auto mb-4">
                                        <div class="learning-obj-form__progress">
                                            <button class="learning-obj-form__progress-btn js-active" type="button"
                                                    title="Code">Mã
                                            </button>
                                            <button class="learning-obj-form__progress-btn" type="button"
                                                    title="Skill Info">Hành động
                                            </button>
                                            <button class="learning-obj-form__progress-btn" type="button"
                                                    title="Vers Info">Mục tiêu
                                            </button>
                                            <button class="learning-obj-form__progress-btn" type="button"
                                                    title="Conditions Info">Hoàn cảnh
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="learning-obj-form__content">
                                    <div class="col-12 col-lg-10 m-auto">
                                        <form class="learning-obj-form__form">
                                            <div class="learning-obj-form__panel p-4 rounded bg-white js-active"
                                                 data-animation="scaleIn">
                                                <div class="learning-obj-form__content">
                                                    <div class="form-row mt-8">
                                                        <input class="learning-obj-form__input form-control code-learning"
                                                               name="code" type="text"
                                                               placeholder="Mã learning objective"/>
                                                    </div>
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn btn-primary ml-auto js-btn-next"
                                                                type="button" title="Next">Tiếp theo
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="learning-obj-form__panel p-4 rounded bg-white"
                                                 data-animation="scaleIn">
                                                <div class="learning-obj-form__content">
                                                    <div class="col-12 col-sm-12 mt-12 mt-sm-0">
                                                        <div class="accordion" id="collapseSkill">

                                                        </div>
                                                    </div>
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn btn-primary js-btn-prev" type="button"
                                                                title="Prev">Trước
                                                        </button>
                                                        <button class="btn btn-primary ml-auto js-btn-next"
                                                                type="button"
                                                                title="Next">Tiếp
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="learning-obj-form__panel p-4 rounded bg-white"
                                                 data-animation="scaleIn">
                                                <div class="learning-obj-form__content">
                                                    <div class="col-12 col-sm-12 mt-12 mt-sm-0">
                                                        <x-api-select
                                                                :url="route('learning.goal.list')"
                                                                emptyValue=""
                                                                name="goal_id"
                                                                class="create-new goal_id"
                                                        ></x-api-select>
                                                    </div>
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn btn-primary js-btn-prev" type="button"
                                                                title="Prev">
                                                            Trước
                                                        </button>
                                                        <button class="btn btn-primary ml-auto js-btn-next"
                                                                type="button"
                                                                title="Next">Tiếp
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="learning-obj-form__panel p-4 rounded bg-white"
                                                 data-animation="scaleIn">
                                                <div class="learning-obj-form__content">
                                                    <div class="col-12 col-sm-12 mt-12 mt-sm-0">
                                                        <x-api-select
                                                                :url="route('learning.conditional.list')"
                                                                emptyValue=""
                                                                name="conditional_id"
                                                                class="create-new conditional_id"
                                                        ></x-api-select>
                                                    </div>
                                                    <div class="button-row d-flex mt-4">
                                                        <button class="btn btn-primary js-btn-prev" type="button"
                                                                title="Prev">
                                                            Trước
                                                        </button>
                                                        <button class="btn btn-success ml-auto create_learning"
                                                                title="Send">
                                                            Gửi
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>

            </div>
        </div>
    </div>
</div>
@push('page_scripts')
    <script type="text/javascript">
        class LearningObj {
            constructor() {
                this.DOMstrings = {
                    stepsBtnClass: 'learning-obj-form__progress-btn',
                    stepsBtns: document.querySelectorAll(`.learning-obj-form__progress-btn`),
                    stepsBar: document.querySelector('.learning-obj-form__progress'),
                    stepsForm: document.querySelector('.learning-obj-form__form'),
                    stepsFormTextareas: document.querySelectorAll('.learning-obj-form__textarea'),
                    stepFormPanelClass: 'learning-obj-form__panel',
                    stepFormPanels: document.querySelectorAll('.learning-obj-form__panel'),
                    stepPrevBtnClass: 'js-btn-prev',
                    stepNextBtnClass: 'js-btn-next',
                    id_verb: {
                        id: null,
                        name: null
                    },
                    list_id_input: [],
                    label_new: {
                        parent_skill_id: null,
                        label_child: null
                    },
                };
                this.skillVerbs = [];
            }

            init() {
                this.DOMstrings.stepsBar.addEventListener('click', e => {
                    const eventTarget = e.target;

                    if (!eventTarget.classList.contains(`${this.DOMstrings.stepsBtnClass}`)) {
                        return;
                    }

                    const activeStep = this.getActiveStep(eventTarget);

                    this.setActiveStep(activeStep);
                    this.setActivePanel(activeStep);
                });
                jQuery.fn.learningObj = function () {
                    this.each(function (index, ele) {
                        jQuery(ele).click(() => {
                            learningObj.showModal(ele, true);
                        });
                    });
                };
                learningObj.getInfoSkill((data) => {
                    const cart = $("#collapseSkill");

                    data.forEach((skill) => {
                        let children_new = ``;
                        if (skill.children) {
                            skill.children.forEach((child) => {
                                children_new += `<li class="list-group-item"><input type="radio" name="verb_input" id="children_${child.id}" value="${child.id}" class="btn btn-info"></input>
                                                   <label for="children_${child.id}">
                                                    ${child.text}
                                    </label></li>`;

                            });
                        }
                        const new_data = `
                                                                <button class="btn btn-primary col-sm-12 mb-1" type="button"
                                                                        data-toggle="collapse"
                                                                        data-target="#collapseLeaning_${skill.id}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                    ${skill.text}
                                                                </button>
                                                                  <div class="collapse" id="collapseLeaning_${skill.id}">
                                                                    <div class="card card-body">
                                                                       <ul class="list-group d-flex flex-row">${children_new}</ul>
                                                                        <h5>Thêm mới verb:</h5>
                                                                        <input class="learning-obj-form__input form-control verb-learning"
                                                                       name="new_verb" type="text"
                                                                       id="verb_learning_${skill.id}"
                                                                       placeholder="Nhập Label của verb để thêm mới"/>
                                                                    </div>
                                                                   <div>
                                                                    <br>
                                                                    </div>
                                                                `;
                        $(cart).before(new_data);

                        const id_input = "#verb_learning_"+skill.id;
                        const input = "#collapseLeaning_"+skill.id;

                        $(id_input).on('input',()=>{
                            learningObj.DOMstrings.label_new.label_child = $(id_input).val();
                            learningObj.DOMstrings.label_new.parent_skill_id = skill.id;

                            learningObj.DOMstrings.id_verb.id = $(id_input).val();

                            $(".text_session_verb").html(" [ " + $(id_input).val() + " ] ");

                            if($(id_input).val().length) {
                                $(input).find("input").prop('checked', false);
                                $(input).find("li input").prop('disabled', 'disabled');
                            }else {
                                $(input).find("li input").prop('disabled', false);
                            }

                        })

                        $(input).find("li input").on("click",()=>{
                            const input_checked =$("input[name='verb_input']:checked");

                            if(input_checked) {

                            }
                            learningObj.DOMstrings.id_verb.id = input_checked.val()
                            learningObj.DOMstrings.id_verb.name = input_checked.next("label").html();

                            $(".text_session_verb").html(" [ " + learningObj.DOMstrings.id_verb.name + " ] ");
                        })
                    });

                });

                $(".learning_obj").learningObj();

                $('.create_learning').on('click', function (e) {
                    const data = learningObj.validateForm(e);

                    data && learningObj.createLearningObj(data);
                    e.preventDefault();
                });


                this.DOMstrings.stepsForm.addEventListener('click', e => {

                    const eventTarget = e.target;

                    if (!(eventTarget.classList.contains(`${this.DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${this.DOMstrings.stepNextBtnClass}`))) {
                        return;
                    }

                    const activePanel = this.findParent(eventTarget, `${this.DOMstrings.stepFormPanelClass}`);

                    let activePanelNum = Array.from(this.DOMstrings.stepFormPanels).indexOf(activePanel);

                    if (eventTarget.classList.contains(`${this.DOMstrings.stepPrevBtnClass}`)) {
                        activePanelNum--;

                    } else {

                        activePanelNum++;

                    }

                    this.setActiveStep(activePanelNum);
                    this.setActivePanel(activePanelNum);

                });

                //changing animation
                const animationSelect = document.querySelector('.pick-animation__select');

                animationSelect && animationSelect.addEventListener('change', () => {
                    const newAnimationType = animationSelect.value;

                    this.setAnimationType(newAnimationType);
                });

                $(".skill_id").on('select2:select', function (e) {
                    const verb_text = $(".skill_id").find('option:selected').html();
                    $(".text_session_verb").html(" [ " + verb_text + " ] ");
                });

                $(".goal_id").on('select2:select', function (e) {
                    const content_text = $(".goal_id").find('option:selected').html();
                    $(".text_session_content").html(" [ " + content_text + " ] ");
                });

                $(".conditional_id").on('select2:select', function (e) {
                    const conditional_text = $(".conditional_id").find('option:selected').html();
                    $(".text_session_conditional").html(" [ " + conditional_text + " ] ");
                });
            }

            showModal() {
                $("#exampleModalCenter").modal();
            }


            removeClasses(elemSet, className) {
                elemSet.forEach(elem => {

                    elem.classList.remove(className);

                });
            }

            validateForm(e) {
                const data = {};
                const code = $(".code-learning").val();
                const goal_id = $(".goal_id").find('option:selected');
                const conditional_id = $(".conditional_id").find('option:selected');
                console.log('learningObj.DOMstrings.id_verb', learningObj.DOMstrings.id_verb.id);
                if ((!learningObj.DOMstrings.label_new.label_child && !learningObj.DOMstrings.id_verb.id) || !goal_id || !conditional_id) {
                    alert('Vui lòng nhập đầy đủ thông tin !');
                    return false;
                }
                data.code = code;

                data.skill_id = learningObj.DOMstrings.id_verb.id ?? null;
                data.label_new = learningObj.DOMstrings.label_new.label_child ?? null;
                data.label_new_parent_id = learningObj.DOMstrings.label_new.parent_skill_id ?? null;
                data.goal_id = goal_id.val();
                data.conditional_id = conditional_id.val() || '';

                let verb = learningObj.DOMstrings.id_verb.name ?? learningObj.DOMstrings.label_new.label_child;
                verb = (verb || '').trim();
                verb = verb.charAt(0).toLowerCase() + verb.slice(1);
                let goal = (goal_id.html() || '').trim();
                goal = goal.charAt(0).toLowerCase() + goal.slice(1);
                let conditional = (conditional_id.html() || '');
                conditional = conditional.charAt(0).toLowerCase() + conditional.slice(1);

                data.explain = "có thể " + verb + " " + goal + " " + conditional.trim();

                return data;
            }

            findParent(elem, parentClass) {
                let currentNode = elem;

                while (!currentNode.classList.contains(parentClass)) {
                    currentNode = currentNode.parentNode;
                }

                return currentNode;
            }

            getActiveStep(elem) {
                return Array.from(this.DOMstrings.stepsBtns).indexOf(elem);
            }

            setActiveStep(activeStepNum) {
                this.removeClasses(this.DOMstrings.stepsBtns, 'js-active');

                this.DOMstrings.stepsBtns.forEach((elem, index) => {

                    if (index <= activeStepNum) {
                        elem.classList.add('js-active');
                    }

                });
            }

            getActivePanel() {
                let activePanel;
                this.DOMstrings.stepFormPanels.forEach(elem => {
                    if (elem.classList.contains('js-active')) {
                        activePanel = elem;
                    }
                });

                return activePanel;
            }

            setActivePanel(activePanelNum) {
                this.removeClasses(this.DOMstrings.stepFormPanels, 'js-active');
                this.DOMstrings.stepFormPanels.forEach((elem, index) => {
                    if (index === activePanelNum) {
                        elem.classList.add('js-active');
                        // this.setFormHeight(elem);
                    }
                });
            }

            formHeight(activePanel) {
                const activePanelHeight = activePanel.offsetHeight;
                const height = activePanelHeight <= 0 ? 200 : activePanelHeight;

                // this.DOMstrings.stepsForm.style.height = `${height}px`;
            }

            setFormHeight() {

                const activePanel = learningObj.getActivePanel();

                learningObj.formHeight(activePanel);
            }

            setAnimationType(newType) {
                this.DOMstrings.stepFormPanels.forEach(elem => {
                    elem.dataset.animation = newType;
                });
            }

            createLearningObj(data) {
                const form = new FormData();
                form.append('code', data.code);
                form.append('skill_id', learningObj.DOMstrings.id_verb.id);
                form.append('goal_id', data.goal_id);
                form.append('conditional_id', data.conditional_id);
                form.append('explain', data.explain);
                form.append('parent_id', data.label_new_parent_id);
                axios.post("{{route('learningObjectives.store')}}", form)
                    .then((response) => {
                        console.log(!response.data.success);
                        if (!response.data.success) {
                            $("#err_session").html(response.data.message);
                            return;
                        }
                        const learningObj = response.data.data.learningObj

                        const ele = $(".learningObj_id");
                        let newOption = new Option(learningObj.code, learningObj.id, false, true);
                        $(ele).append(newOption).trigger('change');

                        $("#exampleModalCenter").modal('hide')

                    }).catch(function (response) {
                }).then((response) => {

                    return;
                });
            }

            getInfoSkill(callBack) {
                axios.get("{{route('skillVerb.list.filter')}}")
                    .then((response) => {
                        if (!response.data.success) {
                            return;
                        }
                        callBack(response.data.data);
                    })
                    .catch(function (error) {

                    })
                    .then(() => {
                    });
            }


        }

        const learningObj = new LearningObj();
        window.addEventListener('DOMContentLoaded', () => {
            (function ($) {
                learningObj.init()
                window.addEventListener('load', learningObj.setFormHeight, false);
                window.addEventListener('resize', learningObj.setFormHeight, false);
                // $('input[data-role=tagsinput]').tagsinput();
            })(jQuery);
        });
    </script>

@endpush
