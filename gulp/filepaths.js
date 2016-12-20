var base = './../wp-content/themes/Divi-child/app/';

var basePaths = {
    src: base,
    dest: base +'build/',
    bower: base +'bower_components/'
};

console.log( basePaths.src);

var paths = {
    styles: {
        src: basePaths.src + 'sass/',
        dest: basePaths.dest + 'css/'
    }
};
var src = {
    styles: paths.styles.src + '**/*.scss',
};

var dest = {
    styles: paths.styles.dest,
};

module.exports = {
	src: src,
	dest:dest
}