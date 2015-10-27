module.exports = {
      fonts: {
        files: [{
          expand: true,
          cwd: '<%= path.src %>/fonts/',
          src: ['**'],
          dest: '<%= path.dist %>/fonts'
        }]
      },
      js: {
      	files: [{
      		expand: true,
      		flatten: true,
      		src: [
      			'<%= path.src %>/bower_components/modernizr/modernizr.js',
      			'<%= path.src %>/bower_components/jquery/dist/jquery.js'
      		],
      		dest: '<%= path.dist %>/js' 
      	}]
      },
      phase2_theme1: {
        files: [
          // Fonts
          {
            expand: true,
            cwd: '<%= path.dist %>/fonts/',
            src: ['**'],
            dest: 'fonts'
          },
          // Stylesheets
          {
            expand: true,
            cwd: '<%= path.dist %>/css/',
            src: ['base.css', 'phase2_pages.css', 'phase2_theme1.css'],
            dest: 'css'
          },
          // Scripts
          {
            expand: true,
            cwd: '<%= path.dist %>/js/',
            src: ['application.min.js', 'foundation.min.js', 'jquery.min.js', 'jquery.plugins.min.js', 'modernizr.min.js', 'polyfill.min.js'],
            dest: 'js'
          }
        ]
      },
    }