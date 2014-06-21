angular.module('People.services', [])
		.factory('PeopleService', function($http) {

			var api_url = 'http://localhost/Syngular/web/app_dev.php/people';

			return {
				getPeople: function() {
					return $http.get(api_url);
				},
				getPerson: function(userId) {
					return $http.get(api_url + '/' + userId);
				}
			};
		});
