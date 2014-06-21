angular.module('People.controllers', [])
		.controller('PeopleCtrl', function($scope, PeopleService) {
			$scope.people = [];
			PeopleService.getPeople($scope);
		})
;