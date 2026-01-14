    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.HES = "on";
        $rootScope.tipoHes = [
            {
                codHes:"on",
                descripcion:"Requiere HES"
            },{
                codHes:"off",
                descripcion:"Sin HES"
            }
            ];

    });
    app.controller('CtrlClientes', function($scope, $http) {
        $scope.loadDataCliente = function(){
            $scope.rutRes = 'Rut '+$scope.RutCli;
            $http.post("leerDatoCliente.php",{RutCli:$scope.RutCli})
                .then(function(response){
                    $scope.HES = response.data.HES;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
    });
