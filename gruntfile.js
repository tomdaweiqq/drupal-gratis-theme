var timer = require("grunt-timer");
module.exports = function (grunt) {
  timer.init(grunt);
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      options: {
        includePaths: require('node-neat').includePaths
      }, // watch options
      sass: {
        files: ['sass/**/*.{scss,sass}', 'sass/_base/**/*.{scss,sass}'],
        tasks: ['sass:render']
      }, //sass
      livereload: {
        files: ['*.html', '*.php', 'templates/**/*.{tpl,php}', 'js/**/*.{js,json}', 'css/*.css', 'images/**/*.{png,jpg,jpeg,gif,webp,svg}'],
        options: {
          livereload: true
        } // options
      } // livereload
    }, //watch
    sass: {
      render: {
        options: {
          includePaths: require('node-neat').includePaths,
          sourceMap: true,
          sourceComments: false,
          outputStyle: 'expanded'
        },
        files: {
          'css/normalize.css': 'sass/normalize.scss',
          'css/styles.css': 'sass/styles.scss',
          'css/hacks.css': 'sass/hacks.scss',
          'css/color-palettes.css': 'sass/color-palettes.scss'
        } //files
      } // render
    } // sass
  });
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default', ['sass:render', 'watch']);
};
