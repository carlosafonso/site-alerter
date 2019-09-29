(function() {
  'use strict';

  angular
    .module('app.urls')
    .run(appRun);

  appRun.$inject = ['routerHelper'];

  /* @ngInject */
  function appRun(routerHelper) {
    routerHelper.configureStates(getStates());
  }

  function getStates() {
    return [
      {
        state: 'default',
        config: {
          url: '/',
          redirectTo: 'urls'
        }
      },
      {
        state: 'urls',
        config: {
          url: '/urls',
          templateUrl: 'app/urls/urls.html',
          controller: 'UrlsController',
          controllerAs: 'vm',
          title: 'URLs',
          settings: {
            nav: 2,
            content: '<i class="fa fa-link"></i> URLs'
          },
          resolve: {
            urls: ['Url', function (Url) {
              return Url.query().$promise;
            }]
          },
          data: {
            requiresAuth: true
          }
        }
      },
      {
        state: 'urls.create',
        config: {
          url: '/create',
          templateUrl: 'app/urls/create-url.html',
          controller: 'CreateUrlController',
          controllerAs: 'vm',
          title: 'Create URL',
          settings: {
            nav: 3,
            content: '<i class="fa fa-link"></i> Create URL'
          }
        }
      }
    ];
  }
})();
