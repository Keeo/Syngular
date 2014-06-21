<!doctype html>
<html>
	<head>
		<meta charset="utf-8">

		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/lib/angular/angular.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/lib/angular-route/angular-route.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/app.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/controllers.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/services.js') ?>"></script>
		
		<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/syngular/lib/bootstrap/dist/css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/syngular/lib/bootstrap/dist/css/bootstrap-theme.min.css') ?>">

		<title>People</title>
	</head>
	<body ng-app="People">
		<div class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<a class="navbar-brand" href="#">Super hustá aplikace lidi</a>
			</div>
		</div>
		<div id="main" class="container theme-showcase">
			<div ng-view></div>
		</div>
	</body>
</html>
