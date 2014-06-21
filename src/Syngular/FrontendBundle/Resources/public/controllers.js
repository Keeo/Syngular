angular.module('People.controllers', [])
		.controller('PeopleCtrl', function($scope, PeopleService) {
			PeopleService.getPeople().success(function(response) {
				$scope.people = response;
			});

		})

		.controller('PersonCtrl', function($scope, $routeParams, PeopleService) {
			PeopleService.getPerson($routeParams.personId).success(function(response) {
				$scope.person = response;
			});
		});