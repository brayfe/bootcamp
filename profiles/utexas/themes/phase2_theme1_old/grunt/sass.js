module.exports = {
  options: {
    includePaths: ['<%= path.src %>/bower_components/foundation/scss']
  },
  dev: {
    options: {
      outputStyle: 'nested'
    },
    files: {
      '<%= path.dist %>/css/base.css': '<%= path.src %>/scss/build/base.scss',
      '<%= path.dist %>/css/phase2_pages.css': '<%= path.src %>/scss/build/phase2_pages.scss',
      '<%= path.dist %>/css/phase2_theme1.css': '<%= path.src %>/scss/build/phase2_theme1.scss',
    }
  },
  dist: {
    files: {
      '<%= path.dist %>/css/base.css': '<%= path.src %>/scss/build/base.scss',
      '<%= path.dist %>/css/phase2_pages.css': '<%= path.src %>/scss/build/phase2_pages.scss',
      '<%= path.dist %>/css/phase2_theme1.css': '<%= path.src %>/scss/build/phase2_theme1.scss',
    }
  }
}
