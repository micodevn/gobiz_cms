const context = require.context('./', true, /\.(js)$/);
const files = [];

context.keys().forEach((filename)=>{
    if (filename.endsWith('index.js')) {
        return true;
    }

    const pathSplit = filename.replace(/\.[^/.]+$/, "").split('/');
    files.push({
        name: pathSplit[pathSplit.length - 1],
        class: context(filename)
    });
});

export default files;
