module.exports = {
  options: {
    includePaths: ['<%= path.src %>/bower_components/foundation/scss']
  },
  dist: {
    files: {
      '<%= path.dist %>/css/overrides.css': '<%= path.src %>/scss/build/overrides.scss',
      '<%= path.dist %>/css/foundation.accordion.css': '<%= path.src %>/scss/build/accordion.scss',
      '<%= path.dist %>/css/foundation.alert.css': '<%= path.src %>/scss/build/alert.scss',
      '<%= path.dist %>/css/foundation.clearing.css': '<%= path.src %>/scss/build/clearing.scss',
      '<%= path.dist %>/css/foundation.dropdown.css': '<%= path.src %>/scss/build/dropdown.scss',
      '<%= path.dist %>/css/foundation.joyride.css': '<%= path.src %>/scss/build/joyride.scss',
      '<%= path.dist %>/css/foundation.offcanvas.css': '<%= path.src %>/scss/build/offcanvas.scss',
      '<%= path.dist %>/css/foundation.orbit.css': '<%= path.src %>/scss/build/orbit.scss',
      '<%= path.dist %>/css/foundation.reveal.css': '<%= path.src %>/scss/build/reveal.scss',
      '<%= path.dist %>/css/foundation.tooltip.css': '<%= path.src %>/scss/build/tooltip.scss',
      '<%= path.dist %>/css/foundation.topbar.css': '<%= path.src %>/scss/build/topbar.scss'
    }
  }
}
