<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Backend Liceo Tecnógico Enrique Kirberg</title>

    <script type="text/javascript" src="../angular/angular.js"></script>
    
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body ng-app="myApp" ng-controller="TodoCtrl">
 <div>
  <h2>Calculate</h2>

  <div>
    <form>
        <li>Number 1: <input type="text" ng-model="one">  
        <li>Number 2: <input type="text" ng-model="two">
        <li>Number 2: <input type="text" ng-model="vt" ng-init="vt='{{total}}'">
        <li>Total <input type="hidden" value="{{total()}}">       
        {{total()}}
    </form>
  </div>
</div>  


    <script>
    var app = angular.module('myApp', []);
    app.controller('TodoCtrl', function($scope, $http) {
    $scope.total = function(){
        if($scope.one > 0 && $scope.two > 0){
            $scope.vt = $scope.one * $scope.two;
            return $scope.vt;
        }
    };
    });
    </script>
</body>
</html>

