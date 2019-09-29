(function() {
  'use strict';

  angular
    .module('blocks.auth')
    .run(appRun);

  appRun.$inject = ['routerHelper'];

  /* @ngInject */
  function appRun(routerHelper) {
    routerHelper.configureStates(getStates());
  }

  function getStates() {
    return [
      {
        state: 'loginCallback',
        config: {
          url: '/login_callback',
          templateUrl: 'app/blocks/auth/login-callback.html',
          controller: 'LoginCallbackController',
          controllerAs: 'vm'
        }
      }
    ];
  }
})();
