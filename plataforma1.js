    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado = "P";
        $rootScope.enProceso = false;
        $rootScope.tablasAM = false;
    });

    app.controller('personCtrl', function($scope, $http) {

        $scope.leerCotizacionesEnAM = function(){
            $scope.enProceso = true;
            $http.get("leerCotizacionesAM.php")  
            .then(function(response){  
                $scope.cotizacionesAM = response.data.records;
                $scope.enProceso = false;
                $scope.tablasAM = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.leerCotizacionesEnAM();

        $scope.comparadorBlanco = function(item){
            if(item.infoSubidos == 0 || item.infoSubidos < item.infoNumero){
            //if(item.RAM == 13325){
                return true;
            }
        }
        $scope.comparadorAmarillo = function(item){
            if(item.informeUP == 'on' && item.nSolicitud == 0 && item.nFactura == 0 && item.nSolicitud == 0){
                if(item.HES == 'on' && item.HEScot == ''){
                    return false; 
                }else{
                    return true;
                }
            }
        }
        $scope.comparadorRosado = function(item){
            if(item.informeUP == 'on' && item.nSolicitud == 0 && item.nFactura == 0 && item.HES == 'on' && item.HEScot == ''){
               return true; 
            }
        }
        $scope.comparadorVerde = function(item){
            if(item.nSolicitud > 0 && item.nFactura == 0){
               return true; 
            }
        }
        $scope.comparadorAzul = function(item){
            if(item.nSolicitud > 0 && item.nFactura > 0){
               return true; 
            }
        }

        $scope.getTotalBlancas = function(){
            var totalBlancas = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'blanca'){
                    totalBlancas += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalBlancas;
        }
        $scope.getTotalRosados = function(){
            var totalRosados = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'rosado'){
                    totalRosados += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalRosados;
        }
        $scope.getTotalAmarillos = function(){
            var totalAmarillos = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'amarillo'){
                    totalAmarillos += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalAmarillos;
        }
        $scope.getTotalVerdes = function(){
            var totalVerdes = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'verde'){
                    totalVerdes += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalVerdes;
        }
        $scope.getTotalAzules = function(){
            var totalAzules = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                if(x.color == 'azul'){
                    totalAzules += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalAzules;
        }

        $scope.getTotal = function(){
            var total = 0;
            for(var i = 0; i < $scope.cotizacionesAM.length; i++){
                var x = $scope.cotizacionesAM[i];
                total += parseInt(x.BrutoUF);
            }
            $scope.tResultados = total;
            return total;
        }


    });

