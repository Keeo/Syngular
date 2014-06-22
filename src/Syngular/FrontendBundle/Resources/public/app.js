var templates_path = '/Syngular/web/bundles/syngular/';

angular.module('People', ['ngRoute', 'People.controllers', 'People.services'])
		.config(function($routeProvider) {
			$routeProvider

					.when('/', {
						templateUrl: templates_path + 'templates/people.html',
						controller: 'PeopleCtrl',
						resolve: {
							people: function(PeopleService) {
								return PeopleService.getAll();
							}
						}
					})

					.when('/person/:personId', {
						templateUrl: templates_path + 'templates/person.html',
						controller: 'PersonCtrl',
						resolve: {
							person: function($route, PeopleService) {
								return PeopleService.get($route.current.params.personId)
							}
						}
					})

					.when('/add', {
						templateUrl: templates_path + 'templates/add.html',
						controller: 'AddCtrl'
					})

					.when('/edit/:personId', {
						templateUrl: templates_path + 'templates/edit.html',
						controller: 'EditCtrl',
						resolve: {
							person: function($route, PeopleService) {
								return PeopleService.get($route.current.params.personId)
							}
						}
					});
		})

		.run(function($rootScope) {
			$rootScope.$on('$routeChangeStart', function(e, curr, prev) {
				if (curr.$$route && curr.$$route.resolve) {
					// Show a loading message until promises are not resolved
					$rootScope.loadingView = true;
				}
			});
			$rootScope.$on('$routeChangeSuccess', function(e, curr, prev) {
				// Hide loading message
				$rootScope.loadingView = false;
			});
		});