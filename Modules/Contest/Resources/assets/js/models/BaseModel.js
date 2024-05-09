export default class BaseModel {
    constructor(data = {}) {
        this.is_new = true;
        this.load(data);
    }

    load(data) {
        Object.keys(data).forEach((key) => {
            this[key] = data[key];
        });

        this.is_new = false;
    }
}
