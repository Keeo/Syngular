angular.module('People.services', [])
		.factory('AbstractCrudService', function($http) {
			var CrudService = function(url) {
				this.api_url = url;
			};

			CrudService.prototype.get = function(id) {
				return $http.get(this.api_url + '/' + id);
			};

			CrudService.prototype.getAll = function() {
				return $http.get(this.api_url);
			};

			CrudService.prototype.create = function(entity) {
				return $http.post(this.api_url, entity);
			};

			CrudService.prototype.update = function(id, entity) {
				return $http.put(this.api_url + '/' + id, entity);
			};
			
			CrudService.prototype.delete = function(id) {
				return $http.delete(this.api_url + '/' + id);
			};
			
			return {
				getInstance: function(api_url) {
					return new CrudService(api_url);
				}
			};

		})

		.factory('PeopleService', function($http, AbstractCrudService) {

			var api_url = 'http://localhost/Syngular/web/app_dev.php/people';
			
			var service = AbstractCrudService.getInstance(api_url);
			
			return service;
		});
