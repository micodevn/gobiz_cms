const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

const moduleName = 'contest';

mix.setPublicPath('../../public/assets').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/' + moduleName + '/contest.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/' + moduleName + '/contest.css');

if (mix.inProduction()) {
    mix.version();
}
