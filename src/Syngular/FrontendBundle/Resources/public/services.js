angular.module('People.services', [])
		.factory('PeopleService', function($http) {

			var api_url = 'http://localhost/Syngular/web/app_dev.php/people';

			return {
				getPeople: function() {
					return $http.get(api_url);
				},
				getPerson: function(personId) {
					return $http.get(api_url + '/' + personId);
				},
				savePerson: function(person) {
					return $http.post(api_url, person);
				},
				deletePerson: function(personId) {
					return $http.delete(api_url + '/' + personId);
				}
			};
		});
