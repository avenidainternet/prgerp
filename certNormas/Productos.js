    var app = angular.module('myApp', []);
    app.controller('CtrlClientes', function($scope, $http) {

        $scope.tCertificados = true;

        $scope.cargarTablaProductos = function(){
            $http.post("leerTablaProductos.php",{
                accion      :   "productosSeleccionados"
            })   
            .then(function(response){  
                $scope.Productos = response.data.records;
                $scope.loading = false;
                if($scope.Norma == ''){
                    alert('Sin Normas ');
                }
            }, function(error) {
                alert(error);
            });
        }

        $scope.cargarTablaProductos();

        $scope.loading = true; 


    });
