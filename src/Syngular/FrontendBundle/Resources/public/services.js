angular.module('People.services', [])
		.factory('AbstractCrudService', function($http) {
			var CrudService = function(url) {
				this.api_url = url;
			};

			CrudService.prototype.get = function(id, aqs) {
				return $http.get(this.api_url + '/' + id + aqs);
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

			CrudService.prototype.link = function(id, linkedEntity, rel, ids) {
				var linkedHeaderString = '';
				for (var i in ids) {
					i > 0 && (linkedHeaderString += ', ');
					linkedHeaderString += '"/' + linkedEntity + '/' + ids[i] + '"; rel="' + rel + '"';
				}

				return $http({
					method: 'LINK',
					url: this.api_url + '/' + id + '/' + linkedEntity,
					headers: {
						'Link': linkedHeaderString
					}
				});
			};

			return {
				getInstance: function(api_url) {
					return new CrudService(api_url);
				}
			};

		})

		.factory('PeopleService', function(AbstractCrudService) {
			var api_url = 'http://localhost/Syngular/web/app_dev.php/people';
			var service = AbstractCrudService.getInstance(api_url);
			return service;
		})

		.factory('InjectionService', function(AbstractCrudService) {
			var api_url = 'http://localhost/Syngular/web/app_dev.php/injection';
			var service = AbstractCrudService.getInstance(api_url);
			return service;
		});
