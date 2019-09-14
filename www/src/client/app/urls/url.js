(function() {
  'use strict';

  angular.module('app.urls')
    .factory('Url', Url);

  Url.$inject = ['$resource', 'API_ENDPOINT'];

   /* @ngInject */
  function Url($resource, API_ENDPOINT) {
    return $resource(
      API_ENDPOINT + '/urls/:id',
      {id: '@pk'},
      {query: {isArray: false}}
    );
  }
})();
