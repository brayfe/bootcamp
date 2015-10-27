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
      			'<%= path.src %>/bower_components/jquery/dist/jquery.js',
            '<%= path.src %>/bower_components/tablesaw/dist/tablesaw.js'
      		],
      		dest: '<%= path.dist %>/js'
      	}]
      },
      forty_acres: {
        files: [
          // Fonts
          {
            expand: true,
            cwd: '<%= path.dist %>/fonts/',
            src: ['**'],
            dest: 'fonts'
          },
          /* Stylesheets -- this section commented out because css is being copied by cmq command
          {
            expand: true,
            cwd: '<%= path.dist %>/css/',
            src: ['base.css', 'forty_acres_pages.css', 'forty_acres.css'],
            dest: 'css'
          }, */
          // Scripts
          {
            expand: true,
            cwd: '<%= path.dist %>/js/',
            src: ['application.min.js', 'foundation.min.js', 'jquery.min.js', 'jquery.plugins.min.js', 'modernizr.min.js', 'polyfill.min.js','tablesaw.js'],
            dest: 'js'
          }
        ]
      },
    }
