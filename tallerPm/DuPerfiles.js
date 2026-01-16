    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.CodInforme           = 'AM';
        $rootScope.Otam                 = '';
        $rootScope.usrResponzable       = '';
        $rootScope.tpoProx              = 0;
        $rootScope.tpoAvisoAct          = 0;
        $rootScope.Actividad            = '';
        $rootScope.actRepetitiva        = true;
        $rootScope.Acreditado           = false; 
        $rootScope.msg                  = false;
        $rootScope.requeridaActividad   = true;
        $rootScope.prgActividad         = new Date();
        $rootScope.fechaProxAct         = new Date();

    });

    app.controller('CtrlDuPerfiles', function($scope, $http) {

            $scope.Exito = false;
            $scope.iniciaVariables = function( Otam ){
                $scope.Otam = Otam;
                $scope.leerDureza();
                $scope.regDurezasPerf();
            }
            $scope.guardarRegDis = function(Distancia, i){
                $http.post('dataDurezas.php',{
                    idItem:$scope.Otam,
                    nIndenta:i,
                    Distancia:Distancia,
                    accion:"guardarDistancia"
                })
                .then(function (response) {
                    console.log('OK Distancia');
                }, function(error) {
                    alert(error.message);
                });
            }
            $scope.guardarRegDur = function(Dureza, i){
                $http.post('dataDurezas.php',{
                    idItem:$scope.Otam,
                    nIndenta:i,
                    Dureza:Dureza,
                    accion:"guardarDureza"
                })
                .then(function (response) {
                    console.log('OK Distancia');
                }, function(error) {
                    alert(error.message);
                });
            }
            $scope.regDurezasPerf = function(){
                $http.post('dataDurezas.php',{
                    idItem:$scope.Otam,
                    accion:"LecturaRegDurezasPerfiles"
                })
                .then(function(response){  
                    $scope.regDurezasPerf = response.data.records;

                }, function(error) {
                    $scope.errors = error.message;
                    console.log('Entra'+$scope.errors);

                });
            }
            $scope.leerDureza = function(){
                $http.post('dataDurezas.php',{
                    idItem:$scope.Otam,
                    accion:"LecturaDurezasPerfiles"
                })
                .then(function (response) {
                    $scope.CodInforme       = response.data.CodInforme;
                    $scope.tpMuestra        = response.data.tpMuestra;
                    $scope.nIndenta         = response.data.nIndenta;
                    $scope.Distancia        = response.data.Distancia;
                    $scope.Dureza           = response.data.Dureza;
                    $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));
                }, function(error) {
                    alert(error.message);
                });
            }



    });

