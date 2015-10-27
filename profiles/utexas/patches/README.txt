Description of existing patch files for this distribution
*********************************************************

1. media_ckeditor_file_insert.patch
Slightly modifies how file metadata is inserted when using Media's WYSIWYG file
inserter so that it never uses the mediawrapper tag which is stripped out by
CKEditor. See https://www.drupal.org/files/issues/media-ckeditor-remove-mediawrapper-2177893-2.patch
and https://www.drupal.org/node/2542566#comment-10407747

2. media_ckeditor_multiple_insert.patch
Due to the unresolved problem reported here, https://www.drupal.org/node/2591069
which likely has to do with a greedy regex, we prevent the replacement of the
HTML with a placeholder tag. The downside is that the link to a file becomes
hardcoded into the HTML (legacy style), but all data displays correctly. Once
the issue is resolved, this patch can be undone.

2. node_clone_context.patch
Calls a function defined in utexas_admin to clone the context on a page-builder
enabled node.
