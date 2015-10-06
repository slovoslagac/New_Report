<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	</head>
<?php
//Include data from JSON data files
$path = join(DIRECTORY_SEPARATOR, array('..','query', 'LeagueforKs.php'));
include $path;
$leaguesel=$selectleague;


//print_r($leaguesel);
?>
	<body>
		<div class="dropdown-container" ng-class="{ show: listVisible }">
			<div class="dropdown-display" ng-click="show();" ng-class="{ clicked: listVisible }">
				<span ng-if="!isPlaceholder">{{display}}</span>
				<span class="placeholder" ng-if="isPlaceholder">{{placeholder}}lt;/span>
				<i class="fa fa-angle-down"></i>
			</div>
			<div class="dropdown-list">
				<div>
					<div ng-repeat="item in list" ng-click="select(item)" ng-class="{ selected: isSelected(item) }">
						<span>{{property !== undefined ? item[property] : item}}</span>
						<i class="fa fa-check"></i>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>