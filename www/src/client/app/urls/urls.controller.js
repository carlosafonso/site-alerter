(function() {
  'use strict';

  angular
    .module('app.urls')
    .controller('UrlsController', UrlsController);

  UrlsController.$inject = ['API_ENDPOINT', 'logger', 'Url', 'urls'];

  /* @ngInject */
  function UrlsController(API_ENDPOINT, logger, Url, urls) {
    var vm = this;
    vm.title = 'URLs';
    vm.urls = urls.items;
    vm.deleteUrl = deleteUrl;

    activate();

    function activate() {
      logger.info('Activated URLs View');
    }

    function getUrls() {
      Url.query().$promise.then((data) => {
        vm.urls = data.items;
      });
    }

    function deleteUrl(url) {
      Url.delete({id: url.pk}).$promise.then(getUrls);
    }
  }
})();
