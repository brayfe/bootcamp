module.exports = {
      js: {
        files: [{
          expand: true,
          flatten: true,
          src: [],
          dest: '<%= path.dist %>/js'
        }]
      },
      STARTERKIT: {
        files: [
          // Stylesheets
          {
            expand: true,
            cwd: '<%= path.dist %>/css/',
            src: ['overrides.css', 'foundation.accordion.css', 'foundation.alert.css', 'foundation.clearing.css',
            'foundation.dropdown.css', 'foundation.interchange.css', 'foundation.joyride.css', 'foundation.offcanvas.css',
            'foundation.orbit.css', 'foundation.reveal.css', 'foundation.slider.css', 'foundation.tooltip.css',
            'foundation.topbar.css'],
            dest: 'css'
          },
          // Scripts
          {
            expand: true,
            cwd: '<%= path.dist %>/js/',
            src: ['foundation.accordion.js', 'foundation.alert.js', 'foundation.clearing.js',
            'foundation.dropdown.js', 'foundation.abide.js', 'foundation.interchange.js',
            'foundation.joyride.js', 'foundation.offcanvas.js', 'foundation.orbit.js',
            'foundation.reveal.js', 'foundation.slider.js', 'foundation.tooltip.js',
            'foundation.topbar.js'],
            dest: 'js'
          }
        ]
      },
    }
