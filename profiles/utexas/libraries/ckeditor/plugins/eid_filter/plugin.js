/**
 * @file Plugin for inserting a name from an EID
 */
(function() {
  CKEDITOR.plugins.add('eid_filter', {

    requires: [],

    init: function(editor) {
      // Add Button.
      editor.ui.addButton('eid_filter', {
        label: 'EID filter',
        command: 'eid_filter',
        icon: this.path + 'eid_filter.jpeg'
      });
      editor.addCommand('eid_filter', new CKEDITOR.dialogCommand('eid_filterDialog'));
    }
  });

  CKEDITOR.dialog.add('eid_filterDialog', function(editor) {
    return {
      title: 'Insert EID',
      minWidth: 600,
      minHeight: 180,
      contents: [{
        id: 'general',
        label: 'Settings',
        elements: [
          {
            type: 'text',
            id: 'eid',
            label: 'EID (ex. "twf369")',
            validate: CKEDITOR.dialog.validate.regex( /^[a-z0-9][a-z0-9._-]{1,7}$/, 'Please enter a valid EID' ),
            required: true,
            commit: function(data) {
              data.eid = this.getValue();
            }
          },
        ]
      }],
      onOk: function() {
        var dialog = this,
          data = {},
          link = editor.document.createElement('span');
        this.commitContent(data);
        var str = '[@' + data.eid + ']';
        link.setHtml(str);
        editor.insertElement(link);
      }
    };
  });
})();
