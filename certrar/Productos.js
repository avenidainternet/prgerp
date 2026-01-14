    var app = angular.module('myApp', []);
    app.controller('CtrlClientes', function($scope, $http) {

        $scope.tCertificados = true;

        $http.get("leerTablaCertificados.php")   
        .then(function(response){  
            $scope.Certificados = response.data.records;
        })
        //$location.url("www.google.cl/");        


        $scope.loading = true; 
        $scope.cargandoTabla = "Cargando Contacto...";
        $http.get("leerTablaContactos.php")  
        .then(function(response){  
            $scope.Contactos = response.data.records;
            $scope.loading = false;
        });


        $scope.loadClientes = function(){
            $scope.datCli = $scope.bCliente;
            $scope.bContactos = '';
        }
        $scope.loadContactos = function(){
            $scope.bCliente = '';
            if($scope.bContactos != ''){
                $scope.tClientes = false;
                $scope.tContactos = true;
            }else{
                $scope.tClientes = true;
                $scope.tContactos = false;
            }
        }
        $scope.verContactos = function(){
            $scope.bCliente     = '';
            $scope.bContactos   = '';
            $scope.tClientes = false;
            $scope.tContactos = true;
        }
        $scope.verClientes = function(){
            $scope.bCliente     = '';
            $scope.bContactos   = '';
            $scope.tClientes = true;
            $scope.tContactos = false;
        }
        $scope.borrarContacto = function(rCli, nCon){
            alert("Eliminar"+rCli+' '+nCon);
            $http.post('eliminarContacto.php',{
                                            RutCli:rCli, 
                                            nContacto:nCon 
                                        })
            .then(function (res) {
                alert("Ok");
            });
            $scope.bContactos = "";
            $http.get("leerTablaContactos.php")  
            .then(function(response){  
                $scope.Contactos = response.data;
            })
        }

    });
