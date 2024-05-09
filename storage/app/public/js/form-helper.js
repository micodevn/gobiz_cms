class FormHelper {

    static getSelectValue(e) {
        return e.select2('data');
    }

    static getValueByField(e) {
        e = $(e);
        console.log("wtf");
        const tagName = e.prop("tagName");

        switch (tagName) {
            case 'select':
                return this.getSelectValue(e);
            default:
                return e.val();
        }
    }
}
