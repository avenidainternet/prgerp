    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.HES = "on";
        $rootScope.Situacion = 0;
        $rootScope.RutCli = '';
        $rootScope.Cliente = '';
        $rootScope.Direccion = '';
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

        $scope.loadDataCliente = function(r){
            $scope.RutCli = r;
            $scope.rutRes = "";
            $scope.Situacion = $scope.RutCli.length;
            if($scope.RutCli.length >= 10){
                $http.post("leerDatoCliente.php",{RutCli:r, accion:'L'})
                    .then(function(response){
                        $scope.Cliente      = response.data.Cliente;
                        $scope.Direccion    = response.data.Direccion;
                        $scope.Contacto     = response.data.Contacto;
                        $scope.Telefono     = response.data.Telefono;
                        $scope.Celular      = response.data.Celular;
                        $scope.Email        = response.data.Email;
                        $scope.Sitio        = response.data.Sitio;
                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
            }
        }
        $scope.guardarDatos = function(){
            //alert($scope.RutCli);
            Grabar = true;
            //alert($scope.Cliente);
            if($scope.RutCli == ''){ 
                alert('Ingrese Rut del Cliente...');
                Grabar = false; 
            }
            if($scope.Cliente == ''){ 
                alert('Ingrese Nombre del Cliente...');
                Grabar = false; 
            }
            if(Grabar == false){
                //alert('Ingrese todos los datos obligatorios...');
            }
            if(Grabar == true){
                $http.post("leerDatoCliente.php",{
                                                    RutCli:$scope.RutCli, 
                                                    Cliente:$scope.Cliente, 
                                                    Direccion:$scope.Direccion, 
                                                    Contacto:$scope.Contacto, 
                                                    Telefono:$scope.Telefono, 
                                                    Celular:$scope.Celular, 
                                                    Email:$scope.Email, 
                                                    Sitio:$scope.Sitio, 
                                                    accion:'G'
                                                })
                    .then(function(response){
                        $scope.rutRes = 'Grabado el registro...';
                }, function(error) {
                    $scope.errors = error.message;
                    $scope.rutRes = error;
                });
            }
        }
        $scope.desabilitarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCliente.php",{
                                                RutCli:$scope.RutCli, 
                                                accion:'D'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Deshabilitado el registro...';
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }
        $scope.eliminarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCliente.php",{
                                                RutCli:$scope.RutCli, 
                                                accion:'E'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Eliminado el registro...';
                    location.href="clientes.php";
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }
        $scope.habilitarDatos = function(){
            //alert($scope.RutCli);
            $http.post("leerDatoCliente.php",{
                                                RutCli:$scope.RutCli, 
                                                accion:'H'
                                            })
                .then(function(response){
                    $scope.rutRes = 'Habilitado...';
            }, function(error) {
                $scope.errors = error.message;
                $scope.rutRes = error;
            });
        }
    });
