(function() {
  'use strict';

  angular
    .module('app.layout')
    .directive('htTopNav', htTopNav);

  /* @ngInject */
  function htTopNav() {
    var directive = {
      bindToController: true,
      controller: TopNavController,
      controllerAs: 'vm',
      restrict: 'EA',
      scope: {
        // 'navline': '='
      },
      templateUrl: 'app/layout/ht-top-nav.html'
    };

    TopNavController.$inject = ['$scope', '$state', 'AuthService'];

    /* @ngInject */
    function TopNavController($scope, $state, AuthService) {
      var vm = this;
      vm.logout = logout;
      $scope.isCollapsed = true;

      function logout() {
        AuthService.clearAuthenticationData();
        $state.go('default');
      }
    }

    return directive;
  }
})();
