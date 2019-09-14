(function() {
  'use strict';

  angular
    .module('app.urls')
    .controller('CreateUrlController', CreateUrlController);

  CreateUrlController.$inject = ['API_ENDPOINT', '$state', 'logger', 'Url'];

  /* @ngInject */
  function CreateUrlController(API_ENDPOINT, $state, logger, Url) {
    var vm = this;
    vm.title = 'Create URL';
    vm.newUrl = {url: null};
    vm.createUrl = createUrl;

    activate();

    function activate() {
      logger.info('Activated URLs View');
    }

    function createUrl() {
      Url.save({url: vm.newUrl.url}).$promise.then(() => $state.go('urls'));
    }
  }
})();
