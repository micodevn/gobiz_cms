function gcd(a, b) {
    if (b === 0) {
        return a;
    }

    return gcd (b, a % b)
}
function calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {

    const ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight);

    return { width: srcWidth*ratio, height: srcHeight*ratio };
}
class ImageEditor {
    constructor(configs) {
        const defaultConfigs = {
            background: '',
            width: 500,
            height: 500,
            target: "",
            ratio: [0, 0],
            id: "editor-canvas",
            selector: null,
        };

        this.configs = {...defaultConfigs, ...configs};
        this.items = [];
        this.canvas = null;
    }

    async setBackground(url) {
        const image = new Image;
        const editor = this;
        image.src = url;

        await image.decode();

        const width = image.width;
        const height = image.height;
        const r = gcd(width, height);

        editor.configs.ratio[0] = width / r;
        editor.configs.ratio[1] = height / r;
        editor.configs.width = width;
        editor.configs.height = height;
        editor.configs.background = image;
        editor.configs.backgroundUrl = url;
        console.log(editor);

        editor.init();
    }

    init(s = null) {
        if (!this.configs.background) {
            return;
        }

        if (s) {
            this.configs.selector = s;
        }

        const background = this.configs.background;

        this.configs.selector = $(this.configs.selector);
        const selector = this.configs.selector;

        const selectorWidth = selector.width();
        let selectorHeight = selector.height();

        if (selectorHeight === 0 || this.canvas === null) {
            selectorHeight = selectorWidth * (3 / 4);
            selector.height(selectorHeight);
        }

        let width = 0,height = 0,mul = 0;

        if (this.configs.width > this.configs.height) {
            width = selectorWidth;
            mul = selectorWidth / this.configs.width;
            height = this.configs.height * mul;
        } else {
            height = selectorHeight;
            mul = selectorHeight / this.configs.height;
            width = this.configs.width * mul;
        }

        const canvasEle = $("<canvas/>", {
            id: this.configs.id,
        });
        canvasEle.attr('width', width);
        canvasEle.attr('height', height);

        selector.empty();
        selector.append(canvasEle);

        const canvas = new fabric.Canvas(canvasEle.attr('id'));

        this.canvas = canvas;
        canvas.setDimensions({
            width: width,
            height: height,
        });

        fabric.Image.fromObject(background, function (img) {
            img.scaleToWidth(canvas.width);
            img.scaleToHeight(canvas.height);
            canvas.setBackgroundImage(img);
            canvas.requestRenderAll();
        });

        // var circle = new fabric.Circle({
        //     radius: 20, fill: 'green', left: 100, top: 100
        // });
        // var triangle = new fabric.Triangle({
        //     width: 20, height: 30, fill: 'blue', left: 50, top: 50
        // });
        //
        // canvas.add(circle, triangle);

        this.prepareEvents();
    }

    getCanvas() {
        return this.canvas;
    }

    randomID() {
        // Math.random should be unique because of its seeding algorithm.
        // Convert it to base 36 (numbers + letters), and grab the first 9 characters
        // after the decimal.
        return '_' + Math.random().toString(36).substr(2, 9);
    };

    addText(text, options = {}) {
        const textEle = new fabric.Text(text, options);
        textEle.name = this.randomID();
        textEle.set('text', "Some text here");
        textEle.set('fill', "#" + Math.floor(Math.random()*16777215).toString(16));
        this.canvas.add(textEle);
        this.items.push(textEle);
    }

    async addImage(imageUrl, options) {
        const img = await new Promise(function(resolve, reject) {
            fabric.Image.fromURL(imageUrl, function(img) {
                img.set(options);
                resolve(img);
            });
        });
        img.name = this.randomID();

        this.canvas.add(img);
        this.items.push(img);
    }

    on(name, callback) {
        var callbacks = this[name];
        if (!callbacks) this[name] = [callback];
        else callbacks.push(callback);
    }

    dispatch(name, event) {
        var callbacks = this[name];
        if (callbacks) callbacks.forEach(callback => callback(event));
    }

    prepareEvents() {
        this.canvas.on("mouse:down", () => {
            const activeEle = this.canvas.getActiveObject();
            if (!activeEle) {
                this.dispatch('selected:clear', null);
                return;
            }

            this.dispatch('selected:single', activeEle);

            const activeEles = this.canvas.getActiveObjects();
            this.dispatch('selected:multiple', activeEles);
        });
    }

    reRender() {
       this.canvas.renderAll();
    }

    clearItems() {
        this.items = [];
    }

    getItems() {
        return this.items;
    }
}
