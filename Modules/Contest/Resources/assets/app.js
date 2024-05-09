import Models from './models';
if (!window.modules) {
    window.modules = {};
}

window.modules['Contest'] = {
    models: {},
    services: {}
};

function loadModels() {
    Models.forEach(function (model) {
        window.modules.Contest.models[model.name] = model.class.default;
    });
}

function loadServices() {
    Models.forEach(function (service) {
        window.modules.Contest.services[service.name] = service.class.default;
    });
}

loadModels();
loadServices();
