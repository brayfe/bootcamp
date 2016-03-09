/**
 * @file Plugin for inserting embed tags with qualtrics_filter.
 */
(function() {
  CKEDITOR.plugins.add('qualtrics_filter', {

    requires: [],

    init: function(editor) {
      // Add Button.
      editor.ui.addButton('qualtrics_filter', {
        label: 'Qualtrics filter',
        command: 'qualtrics_filter',
        icon: this.path + 'qualtrics_filter.png'
      });
      editor.addCommand('qualtrics_filter', new CKEDITOR.dialogCommand('qualtrics_filterDialog'));
    }
  });

  CKEDITOR.dialog.add('qualtrics_filterDialog', function(editor) {
    return {
      title: 'Add Qualtrics form',
      minWidth: 600,
      minHeight: 180,
      contents: [{
        id: 'general',
        label: 'Settings',
        elements: [
          {
            type: 'text',
            id: 'file_url',
            label: 'URL (ex. https://utexas.qualtrics.com/SE/?SID=SV_af1Gk9JWK2khAEJ)',
            validate: CKEDITOR.dialog.validate.regex( /^(.*)qualtrics.com(.*)$/i, 'Please enter a valid Qualtrics URL' ),
            required: true,
            commit: function(data) {
              data.file_url = this.getValue();
            }
          },
          {
            type: 'text',
            id: 'height',
            label: 'Height (leave blank for default width)',
            validate: CKEDITOR.dialog.validate.integer('Please enter a valid number for the height.'),
            commit: function(data) {
              data.height = this.getValue();
            }
          },
          {
            type: 'text',
            id: 'title',
            label: 'Title (optional, not displayed; used for HTML semantics.)',
            commit: function(data) {
              data.title = this.getValue();
            }
          },
        ]
      }],
      onOk: function() {
        var dialog = this,
          data = {},
          link = editor.document.createElement('p');
        this.commitContent(data);
        var str = '[embed]' + data.file_url;
        if (data.height) {
          str += ' | height:' + data.height;
        }
        if (data.title) {
          str += ' | title:' + data.title;
        }
        str += '[/embed]';
        link.setHtml(str);
        editor.insertElement(link);
      }
    };
  });
})();
