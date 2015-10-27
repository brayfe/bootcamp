module.exports = {
      STARTERKIT: {
        files: [
          // Stylesheets
          {
            expand: true,
            cwd: '<%= path.dist %>/css/',
            src: ['overrides.css'],
            dest: 'css'
          }
        ]
      },
    }