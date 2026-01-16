var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.newServicio  = false;
    $rootScope.tecRes       = 'DBD';
    $rootScope.btn          = false; 

    $rootScope.tec = [
        {
            codTecnico:"DBD",
            descripcion:"DBD"
        },{
            codTecnico:"DHU",
            descripcion:"DHU"
        },{
            codTecnico:"RCG",
            descripcion:"RCG"
        },{
            codTecnico:"ARR",
            descripcion:"ARR"
        }
        ];
});

app.controller('controlTaller', function($scope, $http) {
    

    $scope.loadTaller = function(RAM){
        // alert($scope.tecRes);
        $scope.RAM = RAM;
        $http.post("dataTaller.php", {
            RAM         : RAM, 
            tecRes      : $scope.tecRes, 
            accion      : "loadTaller"
        })  
        .then(function(response){  
            $scope.idItem           = response.data.idItem;
            $scope.idMuestra        = response.data.idMuestra;
            $scope.Objetivo         = response.data.Objetivo;
            $scope.nSolTaller       = response.data.nSolTaller;
            $scope.tecRes           = response.data.tecRes;
            $scope.nMuestras        = response.data.nMuestras;
            if($scope.tecRes != ''){
                $scope.btn = true;
            }else{
                $scope.btn = false;
            }
        }, function(error) {
            $scope.errors = error.message;
        });
    }

    $scope.regTecRes = function(){
        $scope.btn = false;
        if($scope.tecRes != ''){
            $scope.btn = true;
        }
        
        $http.post("dataTaller.php", {
            RAM         : $scope.RAM, 
            tecRes      : $scope.tecRes, 
            accion      : "regTecRes"
        })  
        .then(function(response){  
            $scope.loadTaller($scope.RAM);
        }, function(error) {
            $scope.errors = error.message;
        });
        
    }

    $scope.leerServicios = function(){
        $http.post("leerTablaServicios.php")  
        .then(function(response){  
            $scope.dataServicios = response.data.records;
            document.getElementById("filtroServicios").focus();
            //$scope.filtroServicios.focus();
        }, function(error) {
            $scope.errors = error.message;
        });

    }
    $scope.verColorLineaServicios = function(tpServicio, Estado){
        retorno = {'verde-class': true};
        if(tpServicio == 'E'){
            retorno = {'amarillo-class': true};
            mColor = 'Verde';
        }
        if(Estado == 'off'){
            retorno = {'rojo-class': true};
            mColor = 'Verde';
        }
        
        return retorno;
    }


    $scope.actualizaCostoServicio = function(nServicio, Moneda, Valor){
            $http.post("actualizaServicio.php", {
                                                nServicio: nServicio, 
                                                Moneda: Moneda,
                                                Valor: Valor,
                                                accion: "actServicio"
                                            })  
            .then(function(response){  
                $scope.res = 'Datos Guardados correctamente...';
                //alert(res);
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });
    }
    $scope.borrarServicio = function(){
        let respuesta = '';
        respuesta = confirm('Seguro de Borrar servicio: '+$scope.Servicio);
        if(respuesta == true){
            $http.post("actualizaServicio.php", {
                nServicio:   $scope.nServicio, 
                accion: "deleteServicio"
            })  
            .then(function(response){  
                alert('Servicio '+$scope.Servicio+' ha sido eliminado...');
                $scope.newServicio = false;
                $scope.filtroServicios = '';
                $scope.leerServicios();
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });
        }else{
            alert('Servicio '+$scope.Servicio+' NO ha sido eliminado...');
            $scope.newServicio = false;
            $scope.filtroServicios = '';
            $scope.leerServicios();
        }

    }
    $scope.editarServicio = function(nServicio){ 
        $http.post("actualizaServicio.php", {
            nServicio:   nServicio, 
            accion: "editServicio"
        })  
        .then(function(response){  
            $scope.mServicios = false;
            $scope.newServicio = true;
            $scope.nServicio        = response.data.nServicio;
            $scope.Servicio         = response.data.Servicio;
            $scope.ValorUF          = response.data.ValorUF;
            $scope.ValorPesos       = response.data.ValorPesos;
            $scope.ValorUS          = response.data.ValorUS;
            $scope.tpServicio       = response.data.tpServicio;
            $scope.Estado           = response.data.Estado;
        }, function(error) {
            $scope.errors = error.message;
            alert($scope.errors);
        });
    }
    $scope.agregarServicio = function(){
        console.log($scope.nServicio+'<br>');
        console.log($scope.Servicio+'<br>');
        console.log('UF '+$scope.ValorUF+'<br>');
        console.log('$ '+$scope.ValorPesos+'<br>');
        console.log('US '+$scope.ValorUS+'<br>');
        console.log($scope.tpServicio+'<br>');
        console.log($scope.Estado+'<br>');
        if($scope.nServicio > 0){
            $http.post("actualizaServicio.php", {
                nServicio:  $scope.nServicio, 
                Servicio:   $scope.Servicio, 
                ValorUF:    $scope.ValorUF, 
                ValorPesos: $scope.ValorPesos, 
                ValorUS:    $scope.ValorUS, 
                tpServicio: $scope.tpServicio, 
                Estado:     $scope.Estado, 
                accion: "actServicio"
            })  
            .then(function(response){  
                $scope.res = 'Datos Guardados correctamente...';
                $scope.newServicio = false;
                $scope.mServicios = true;
                $scope.filtroServicios = '';
                $scope.leerServicios();
                //alert(res);
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });
        }else{
            $http.post("actualizaServicio.php", {
                Servicio:   $scope.Servicio, 
                ValorUF:    $scope.ValorUF, 
                ValorPesos: $scope.ValorPesos, 
                ValorUS:    $scope.ValorUS, 
                tpServicio: $scope.tpServicio, 
                Estado:     $scope.Estado, 
                accion: "agregaServicio"
            })  
            .then(function(response){  
                $scope.res = 'Datos Guardados correctamente...';
                $scope.newServicio = false;
                $scope.leerServicios();
                //alert(res);
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });
        }
        

    }
});

