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
      '<%= path.dist %>/css/forty_acres_pages.css': '<%= path.src %>/scss/build/forty_acres_pages.scss',
      '<%= path.dist %>/css/forty_acres.css': '<%= path.src %>/scss/build/forty_acres.scss'
    }
  },
  dist: {
    files: {
      '<%= path.dist %>/css/base.css': '<%= path.src %>/scss/build/base.scss',
      '<%= path.dist %>/css/forty_acres_pages.css': '<%= path.src %>/scss/build/forty_acres_pages.scss',
      '<%= path.dist %>/css/forty_acres.css': '<%= path.src %>/scss/build/forty_acres.scss'
    }
  }
}
