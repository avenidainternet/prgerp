    var app = angular.module('myApp', []);
    app.controller('CtrlClientes', function($scope, $http) {
        $scope.tClientes = true;
        $http.post("obtenerValRef.php")  
        .then(function(res){  
            $scope.valorUFRef = res.data.valorUFRef; 
            $scope.valorUSRef = res.data.valorUSRef;
            //console.log(res); 
        }, function(res){
            $scope.datCli = 'Error';
        });

        $http.get("leerTablaClientes.php")  
        .then(function(response){  
            $scope.Clientes = response.data;
            document.getElementById("bCliente").focus();

            //$scope.loading = false;
        })

        $scope.loading = true;
        $scope.cargandoTabla = "Cargando Contacto...";
        $http.get("leerTablaContactos.php")  
        .then(function(response){  
            $scope.Contactos = response.data.records;
            $scope.loading = false;
            //document.getElementById("bCliente").focus();
            //document.getElementById("bContactos").focus();
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
		$scope.actualizaValoresReferencias = function(){
               //$scope.refDat=$scope.valorUSRef;
            $http.post('guardarValRef.php',{
                                            valorUFRef:$scope.valorUFRef, 
                                            valorUSRef:$scope.valorUSRef 
                                        })
            .then(function (res) {
                console.log(res);
            });
		}

    });
