var templates_path = '/Syngular/web/bundles/syngular/';

angular.module('People', ['ngRoute', 'People.controllers', 'People.services'])
		.config(function($routeProvider) {
			$routeProvider

					.when('/', {
						templateUrl: templates_path + 'templates/people.html',
						controller: 'PeopleCtrl'
					})

					.when('/person/:personId', {
						templateUrl: templates_path + 'templates/person.html',
						controller: 'PersonCtrl'
					})
					
					.when('/add', {
						templateUrl: templates_path + 'templates/add.html',
						controller: 'AddCtrl'
					});
		});