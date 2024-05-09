class RenderForm {
    renderDataAttr(render = null, dataFill = {},resetRender = false, element = 'render_attr',option_value_render = null) {
        if (option_value_render) {
            render = option_value_render;
        }

        if (!render) resetRender = true;

        if (render && typeof render != 'object') resetRender = true;
        Formio.createForm(document.getElementById(element), {
            components: !resetRender ? render : []
        }).then((form) => {
            coreInit();
            form.submission = {
                data: dataFill
            };
        });
    }
}

const renderForm = new RenderForm();
