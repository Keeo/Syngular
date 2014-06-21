angular.module('People.controllers', [])
		.controller('PeopleCtrl', function($scope, PeopleService) {
			PeopleService.getPeople().success(function(response) {
				$scope.people = response;
			});

		})

		.controller('PersonCtrl', function($scope, $routeParams, $location, PeopleService) {
			PeopleService.getPerson($routeParams.personId).success(function(response) {
				$scope.person = response;
			});

			$scope.deletePerson = function() {
				PeopleService.deletePerson($routeParams.personId).success(function() {
					$location.path('/');
				});
			};
		})

		.controller('AddCtrl', function($scope, $location, PeopleService) {
			$scope.person = {
				name: '',
				address: ''
			};

			$scope.send = false;

			$scope.addPerson = function() {
				if ($scope.person.name.length === 0 || $scope.person.address.length === 0) {
					alert('Vyplň to pořádně hajzle');
					return;
				}

				$scope.send = true;

				PeopleService.savePerson($scope.person).success(function() {
					$location.path('/');
				});
			};
		})

		.controller('EditCtrl', function($scope, $routeParams, $location, PeopleService) {
			$scope.send = true;

			PeopleService.getPerson($routeParams.personId).success(function(response) {
				$scope.person = response;
				$scope.send = false;
			});

			$scope.updatePerson = function() {
				if ($scope.person.name.length === 0 || $scope.person.address.length === 0) {
					alert('Takhle by to nešlo, koukej to opravit!');
					return;
				}

				$scope.send = true;

				PeopleService.updatePerson($routeParams.personId, $scope.person).success(function() {
					$location.path('#/person/' + $routeParams.personId);
				});
			};

		});