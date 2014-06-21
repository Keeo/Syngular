<!doctype html>
<html>
	<head>
		<meta charset="utf-8">

		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/lib/angular/angular.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/lib/angular-route/angular-route.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/app.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/controllers.js') ?>"></script>
		<script src="<?php echo $view['assets']->getUrl('bundles/syngular/services.js') ?>"></script>

		<title>People</title>
	</head>
	<body ng-app="People">
		<header>
			Super hustá aplikace lidi
		</header>
		<div id="main">
			<div ng-view></div>
		</div>
	</body>
</html>
