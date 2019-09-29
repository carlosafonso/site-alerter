(function() {
  'use strict';

  angular
    .module('blocks.auth')
    .factory('AuthService', AuthService);

  AuthService.$inject = ['$location', '$window', '$log'];

  /* @ngInject */
  function AuthService($location, $window, $log) {
    const LOCALSTORAGE_KEY = 'sitealerter:auth:id_token';

    var service = {
      isAuthenticated: isAuthenticated,
      extractAndSaveFromHashString: extractAndSaveFromHashString,
      clearAuthenticationData: clearAuthenticationData
    };

    return service;

    /////////////////////

    function isAuthenticated() {
      let token = $window.localStorage.getItem(LOCALSTORAGE_KEY);
      return token !== null;
    }

    function extractAndSaveFromHashString(hashString) {
      let vals = hashString.split('&')
        .map((val) => val.split('='))
        .reduce((prev, curr) => {
          prev[curr[0]] = curr[1];
          return prev;
        }, {});

      if (vals.hasOwnProperty('id_token')) {
        $log.info(`ID token: ${vals.id_token}`);
        $window.localStorage.setItem(LOCALSTORAGE_KEY, vals.id_token);
        return vals.id_token;
      } else {
        $log.error('No OAuth ID token found in hash.');
        return null;
      }
    }

    function clearAuthenticationData() {
      $window.localStorage.removeItem(LOCALSTORAGE_KEY);
    }
  }
} ());
