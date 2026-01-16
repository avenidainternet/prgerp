var mDatos = angular.module('myApp', []);
mDatos.controller('custCtr', function($scope, $http){
    //$scope.ram = "1045";
    $scope.res="Bienvenido aquí se mostrara el resultado de sus Acciones";  

    $scope.inicializar = function(OCP){
        $scope.OCP = OCP;
    }

    $scope.modi = function(){
        $scope.res = $scope.ram+' '+$scope.Obs+' '+$scope.Taller+' '+$scope.nMuestras;
        if($scope.ram){ 
            $http.post('mMuestras.php',{accion:2, RAM:$scope.ram, Obs:$scope.Obs, nMuestras:$scope.nMuestras})
            .success(function (response) { 
                $scope.res = response.msg;	                      
            });
        }else{
            alert("Debe Introducir Usuario y Contraseña");
            $scope.res="Para realizar la Busqueda debe introducir Usuario y Contraseña";
        }
    };


    $scope.busc = function(){
          if($scope.ram){
            $scope.res = $scope.ram;
              /*
              $http.post('modelo.php',{accion:1, ram:$scope.ram})
              .success(function (response) {
                    $scope.res = response.msg;
                    if(!response.msg2){
                          $scope.ram="";
                          $scope.obs="";
                          $scope.taller = "";
                          $scope.nmuestras="";
                    }
                    angular.forEach(response.msg2, function(value, key){
                          $scope.ram=value.ram;
                          $scope.obs=value.obs;
                          $scope.taller=value.taller;
                          $scope.nmuestras = value.nmuestras;
                          
                    });
                });
               */
           }
    }



});
