    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado = "P";
    });

    app.controller('CtrlCotizaciones', function($scope, $http) {
                       
        $scope.imprimeRamsDia = function(pd, ud){
            //alert('Imprime RAMs '+pd+' hasta '+ud);
            $http.post("imprimeRams.php",{fechaDesde:pd, fechaHasta:ud})  
            .then(function(response){  
                alert(response.data.RAM);
            }, function(error) {
                $scope.errors = error.message;
            });
        }

    });

