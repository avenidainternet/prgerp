var app = angular.module('myApp', []);
app.controller('CtrlTaller', function($scope, $http) { 

$scope.leerSolicitudes = function(){
    $http.get("leerSolicitudes.php")  
    .then(function(response){  
        $scope.trabajoTaller = response.data.records;  
    })
}

$scope.leerSolicitudes();

});
