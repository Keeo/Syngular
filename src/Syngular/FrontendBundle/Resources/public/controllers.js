angular.module('People.controllers', [])
		.controller('PeopleCtrl', function($scope, people) {
			$scope.people = people.data;
		})

		.controller('PersonCtrl', function($scope, $routeParams, $location, PeopleService, person) {

			$scope.person = person.data;

			$scope.deletePerson = function() {
				PeopleService.delete($routeParams.personId).success(function() {
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

				PeopleService.create($scope.person).success(function() {
					$location.path('/');
				});
			};
		})

		.controller('EditCtrl', function($scope, $routeParams, $location, PeopleService, person) {
			$scope.person = person.data;
			$scope.send = false;

			$scope.updatePerson = function() {
				if ($scope.person.name.length === 0 || $scope.person.address.length === 0) {
					alert('Takhle by to nešlo, koukej to opravit!');
					return;
				}

				$scope.send = true;
				PeopleService.update($routeParams.personId, $scope.person).success(function() {
					$location.path('/person/' + $routeParams.personId);
				});
			};

		});