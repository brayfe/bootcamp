(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.utexasGeneralBehavior = {
  attach: function(context, settings) {

    $('iframe.media-youtube-player').wrap('<div class="flex-video"></div>');

  }
};

})(jQuery, Drupal, this, this.document);
