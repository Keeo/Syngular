angular.module('People.controllers', [])
		.controller('PeopleCtrl', function($scope, people) {
			$scope.people = people.data.people;
		})

		.controller('PersonCtrl', function($scope, $routeParams, $location, PeopleService, person, allInjections, hisInjections) {

			$scope.allInjections = allInjections.data.injection;
			$scope.hisInjections = hisInjections.data.injections;
			$scope.injection = 0;
			$scope.person = person.data.people;

			$scope.deletePerson = function() {
				PeopleService.delete($routeParams.personId).success(function() {
					$location.path('/');
				});
			};
			
			$scope.assignInjection = function() {
				if(isNaN($scope.injection.id)) {
					alert('Vyber si');
					return;
				}
				
				PeopleService.link($scope.person.id, 'injection', 'injections', [$scope.injection.id]).success(function(){
					PeopleService.get($routeParams.personId, '/injections').success(function(data){
						$scope.hisInjections = data.injections;
					});
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
			$scope.person = person.data.people;
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