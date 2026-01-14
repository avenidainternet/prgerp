    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.RAM                  = '';
        $rootScope.usr                  = '';
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

    app.controller('CtrlPegasUsr', function($scope, $http, $interval) {

/*
            $interval(function () {
                var d = new Date();
                var t = d.toLocaleTimeString();
                document.getElementById("hora").innerHTML = t;
            }, 1000);
*/
            $scope.Exito = false;
    
            $scope.ConsultaUsuarios = function(){
                $http.post('dataPegas.php',{
                    accion:"Usuarios"
                })
                .then(function (response) {
                    $scope.regUsuarios  = response.data.records;
                    console.log($scope.regUsuarios);
                }, function(error) {
                    console.log(error.message);
                });
            }
            $scope.ConsultaUsuarios();

            $scope.ConsultaPegas = function(){
                $http.post('dataPegas.php',{
                    accion:"Pegas"
                })
                .then(function (response) {
                    $scope.regPegas  = response.data.records;
                    console.log($scope.regUsuarios);
                }, function(error) {
                    console.log(error.message);
                });
            }
            $scope.ConsultaPegas();


    });

