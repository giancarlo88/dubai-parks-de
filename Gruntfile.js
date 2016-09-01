module.exports = function(grunt) {

	'use strict';


	/**
	 * Time the tasks
	 */
	require('time-grunt')(grunt);


	/**
	 * Load all tasks
	 */
	require('load-grunt-tasks')(grunt);


	/**
	 * Setup app path
	 */
	var config = {
		root: '.',
		app: '.',
		dist: 'dist'
	};

	grunt.initConfig({


		/**
		 * Read package file for later reuse
		 */
		pkg: grunt.file.readJSON('package.json'),


		/**
		 * Copy params to local scope
		 */
		config: config,



		/**
		 * Clean dist
		 */
		clean: {
			dist: {
				files: [{
					dot: true,
					src: ['<%= config.dist %>/*', '.tmp/*']
				}]
			}
		},


		/**
		 * Copy files to dist
		 */
		copy: {
			dist: {
				files: [{
					expand: true,
					cwd: '<%= config.app %>',
					dest: '<%= config.dist %>',
					src: [
						'*.{ico,png.txt}',
						'{,*/}*.{php,html}'
					]
				}]
			}
		},


		/**
		 * Auto vendor-prefix CSS
		 */
		autoprefixer: {
			dist: {
				files: [{
					expand: true,
					cwd: '.tmp/concat/assets/css/',
					dest: '.tmp/concat/assets/css/',
					src: '{,*/}*.css'
				}]
			},
			options: {
				browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1'],
				map: {
					prev: '.tmp/concat/assets/css/'
				}
			}
		},


		/**
		 * Sass task
		 */
		sass: {
			dist: {
				files: {
					'<%= config.app %>/assets/css/style.css':'<%= config.app %>/assets/sass/style.scss',
					'<%= config.app %>/assets/css/dashboard.css':'<%= config.app %>/assets/sass/dashboard.scss'
				},
				options: {
					style: 'expanded'
				}
			}
		},

		useminPrepare: {
			options: {
				dest: '<%= config.dist %>'
			},
			html: ['<%= config.app %>/header.php', '<%= config.app %>/footer.php']
		},

		usemin: {
			options: {
				assetsDirs: [
					'<%= config.dist %>',
					'<%= config.dist %>/assets/img',
					'<%= config.dist %>/assets/css'
				]
			},
			html: ['<%= config.dist %>/{,*/}*.{php,html}'],
			css: ['<%= config.dist %>/assets/css/{,*/}*.{css}']
		},


		/**
		 * You don't need following tasks as usemin will take care
		 * of these tasks automatically.
		 */

		/**
		 * CSS minifying task
		 */
		// cssmin: {
		// 	dist: {
		// 		files: {
		// 			'<%= config.dist %>/assets/css/style.min.css':['<%= config.app %>/assets/css/{,*/}*.css']
		// 		},
		// 		options: {
		// 			banner: '/*! <%= pkg.name %> | v<%= pkg.version %> | <%= pkg.author %> | <%= pkg.homepage %> | <%= pkg.license %> */ \n'
		// 		}
		// 	}
		// },


		/**
		 * Concat JS vendors file
		 */
		// concat: {},


		/**
		 * JS minifying task
		 */
		// uglify: {
		// 	options: {
		// 		banner: '/*! <%= pkg.name %> | v<%= pkg.version %> | <%= pkg.author %> | <%= pkg.homepage %> | <%= pkg.license %> */ \n',
		// 		preserveComments: 'some'
		// 	},
		// 	dist: {
		// 		files: {
		// 			'<%= config.dist %>/assets/js/main.min.js':'<%= config.app %>/assets/js/main.js',
		// 			'<%= config.dist %>/assets/js/vendors.min.js':'<%= config.app %>/assets/js/vendors.js'
		// 		}
		// 	}
		// },


		/**
		 * Optimize images
		 */
		imagemin: {
			dist: {
				files: [{
					expand: true,
					cwd: '<%= config.app %>/assets/img',
					src: '{,*/}*.{jpg,gif,png,jpeg,ico,svg}',
					dest: '<%= config.dist %>/assets/img'
				}]
			}
		},


		/**
		 * PHP server task
		 */
		php: {
			options: {
				base: '<%= config.root %>',
				hostname: 'localhost',
				open: false
			},
			watch: {}
		},


		/**
		 * Watch for changes task
		 */
		watch: {
			sass: {
				files: ['<%= config.app %>/assets/sass/{,*/}*.scss'],
				tasks: ['sass:dist', 'autoprefixer:dist'],
				options: {
					spawn: false,
					livereload: true
				}
			},
			image: {
				files: ['<%= config.app %>/assets/img/{,*/}*.{jpg,gif,png,jpeg,ico,svg}'],
				options: {
					spawn: false,
					livereload: true
				}
			},
			script: {
				files: ['<%= config.app %>/assets/js/{,*/}*.js'],
				options: {
					spawn: false,
					livereload: true
				}
			},
			php: {
				files: ['<%= config.app %>/{,*/}*.{php,html}'],
				options: {
					livereload: 35729
				}
			}
		}
	});



	/**
	 * Register all tasks
	 */
	grunt.registerTask('default', [
		'php:watch',
		'watch'
	]);


	/**
	 * Production build task
	 */
	grunt.registerTask('build', [
		'clean',
		'copy',
		'sass',
		'useminPrepare',
		'autoprefixer',
		'concat',
		'uglify',
		'cssmin',
		'imagemin',
		'usemin'
	]);
};