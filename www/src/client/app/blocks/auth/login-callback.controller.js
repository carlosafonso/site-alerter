(function() {
  'use strict';

  angular
    .module('app.urls')
    .controller('LoginCallbackController', LoginCallbackController);

  LoginCallbackController.$inject = ['$location', '$state', 'AuthService'];

  /* @ngInject */
  function LoginCallbackController($location, $state, AuthService) {
    var vm = this;
    vm.success = null;

    activate();

    function activate() {
      processCallback();
    }

    function processCallback() {
      if (AuthService.extractAndSaveFromHashString($location.hash())) {
        vm.success = true;
        $state.go('urls');
      } else {
        vm.success = false;
      }
    }
  }
})();
