const { src, dest, parallel } = require('gulp');
const rename = require('gulp-rename');
const minifyJS = require('gulp-uglify');
const minifyCSS = require('gulp-uglifycss');
const imageOptimize = require('gulp-image');

/*-------------------------------------System----------------------------------------------------*/
function JavascriptSystem(){
    return src('resources/assets/js/*.js')
    .pipe(minifyJS())
    .pipe(rename({extname:'.min.js'}))
    .pipe(dest('public/assets/js/'));
}

function CssSystem(){
    return src('resources/assets/css/*.css')
    .pipe(minifyCSS({"maxLineLen": 80, "uglyComments": true}))
    .pipe(rename({extname:'.min.css'}))
    .pipe(dest('public/assets/css/'));
}
/*-----------------------------------------------------------------------------------------------*/

/*-------------------------------------Panel-----------------------------------------------------*/
function JavascriptPanel(){
    return src('resources/assets/js/admin/*.js')
    .pipe(minifyJS())
    .pipe(rename({extname:'.min.js'}))
    .pipe(dest('public/assets/js/admin/'));
}

function CssPanel(){
    return src('resources/assets/css/admin/*.css')
    .pipe(minifyCSS({"maxLineLen": 80, "uglyComments": true}))
    .pipe(rename({extname:'.min.css'}))
    .pipe(dest('public/assets/css/admin/'));
}
/*-----------------------------------------------------------------------------------------------*/

/*-------------------------------------Images----------------------------------------------------*/
function imagesJPG(){
    return src('resources/assets/images/*.jpg')
    .pipe(imageOptimize())
    .pipe(dest('public/assets/images/'));
}
function imagesPNG(){
    return src('resources/assets/images/*.png')
    .pipe(imageOptimize())
    .pipe(dest('public/assets/images/'));
}
function imagesTrophies(){
    return src('resources/assets/images/trophies/*.png')
    .pipe(imageOptimize())
    .pipe(dest('public/assets/images/trophies/'));
}
/*-----------------------------------------------------------------------------------------------*/


exports.default = parallel(JavascriptSystem, JavascriptPanel, CssSystem, CssPanel, imagesJPG, imagesPNG, imagesTrophies);