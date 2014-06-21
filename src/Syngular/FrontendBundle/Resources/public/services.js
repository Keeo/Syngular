angular.module('People.services', [])
		.factory('PeopleService', function($http) {

			return {
				getPeople: function($scope) {
					$http.get('http://localhost/Syngular/web/app_dev.php/people/').then(function(response) {
						$scope.people = response.data;
					});
				},
				getPerson: function(userId) {

				}
			};
		});
