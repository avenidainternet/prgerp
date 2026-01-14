    var app = angular.module('myApp', []);

    app.controller('infoPantalla', function($scope, $http, $interval) {
                       

        $scope.leerCotizacionesPAM = function(){
            $scope.tablaPAM = true;
            $scope.errors = "";
            $http.post("leerPAMs.php")  
            .then(function(response){  
                $scope.CotizacionesPAM = response.data.records;
                 $scope.tablaPAM = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.leerCotizacionesPAM();
        $interval(function(){
            $scope.leerCotizacionesPAM();
        }, 1000)

        $scope.verColorLineaPAM = function(Estado, RAM, Fan, nDias, dhf, dha, rCot){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(Estado == 'P' && nDias <= 1){
                if(nDias <= 0){
                    retorno = {'rojo-class': true};
                    mColor = 'Rojo';
                }else{
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }
            }else{
                if(Estado == 'P'){
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }
            if(dhf > 0){ 
                if(dhf == 2 || dhf == 1){ 
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }else{
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }
            if(dha > 0){ 
                retorno = {'rojo-class': true};
                mColor = 'Rojo';
            }
            if(Fan > 0){ 
                retorno = {'verdechillon-class': true};
                mColor = 'Clon';
            }
            
            return retorno;
        }


    });

