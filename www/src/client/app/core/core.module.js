(function() {
  'use strict';

  angular
    .module('app.core', [
      'ngAnimate', 'ngSanitize', 'ngResource', 'ngMessages',
      'blocks.exception', 'blocks.logger', 'blocks.router', 'blocks.auth',
      'ui.router', 'ui.router.state.events'
    ]);
})();
