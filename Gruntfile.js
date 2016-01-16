module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    var watchFiles = {
        sass: ['webapp/scss/**/*.scss'],
        js: ['webapp/js/**/*.js'],
        views: ['webapp/views/**/*.php'],
        assets: ['webapp/assets/**/*']
    };
    grunt.initConfig({
        jshint: {
            default: {
                src: watchFiles.js,
                options: {
                    jshintrc: true
                }
            }
        },
        sass: {
            public: {
                files: {
                    'dist/css/app.min.css': 'sass/app.scss'
                },
                options: {
                    style: 'compressed',
                    trace: true
                }
            },
            admin: {
                files: {
                    'dist/css/admin.min.css': 'sass/admin.scss'
                },
                options: {
                    style: 'compressed',
                    trace: true
                }
            }
        },
        uglify: {
            admin: {
                files: {
                    'dist/js/app.header.admin.js': [
                    ]
                },
                options: {
                    sourceMap: true,
                    preserveComments: false,
                    compress: true,
                    mangle: true,
                    reserveDOMProperties: true
                }
            },
            main: {
                files: {
                    'dist/js/app.main.min.js': [
                    ]
                },
                options: {
                    sourceMap: true,
                    preserveComments: false,
                    compress: true,
                    mangle: true,
                    reserveDOMProperties: true
                }
            }
        },
        watch: {
            views: {
                files: watchFiles.views,
                options: {
                    livereload: true
                }
            },
            js: {
                files: watchFiles.js,
                tasks: ['jshint','uglify:main'],
                options: {
                    livereload: true
                }
            },
            sass: {
                files: watchFiles.sass,
                tasks: ['sass'],
                options: {
                    livereload: true
                }
            },
            files: {
                files: watchFiles.assets,
                tasks: ['imagemin'],
                options: {
                    livereload: true
                }
            }
        }
    });

    // Default task, run jshint, copy custom client side js scripts, then start server and watch
    grunt.registerTask('dev', [
        'newer:uglify',
        'newer:sass',
        'watch'
    ]);

};