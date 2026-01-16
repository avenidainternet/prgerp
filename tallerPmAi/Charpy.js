var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.CodInforme           = 'AM';
    $rootScope.Otam                 = '';
    $rootScope.usrResponzable       = '';
    $rootScope.tpoProx              = 0;
    $rootScope.tpoAvisoAct          = 0;
    $rootScope.Actividad            = '';
    $rootScope.actRepetitiva        = true;
    $rootScope.respaldoEnsayo       = false;
    $rootScope.Acreditado           = false;  
    $rootScope.msg                  = false;
    $rootScope.requeridaActividad   = true;
    $rootScope.prgActividad         = new Date();
    $rootScope.fechaProxAct         = new Date();
    $rootScope.mostrarValImpacto    = true;
    $rootScope.Equipo               = 'Imp-01';
    $rootScope.equipos = [
        {codigo: 'Imp-01', nombre: 'Impacto 01'},
        {codigo: 'Imp-02', nombre: 'Impacto 02'}
    ];


    $rootScope.dataMilimetros           = [
        {
            dataMm          :   10,
            descripcion     :   10
        },{
            dataMm          :   7.5,
            descripcion     :   7.5
        },{
            dataMm          :   6.7,
            descripcion     :   6.7
        },{
            dataMm          :   5,
            descripcion     :   5
        },{
            dataMm          :   3.3,
            descripcion     :   3.3
        },{
            dataMm          :   2.5,
            descripcion     :   2.5
        }
    ];

});

app.controller('CtrlImpactos', function($scope, $http) {

        $scope.Exito = false;
        $scope.Equipo = 'Imp-01';
        $scope.iniciaVariables = function( Otam ){
            // alert('Entra '+Otam);
            $scope.Otam = Otam;
            $scope.leerCharpy();
            $scope.regDataImpactos();
        }

        $scope.guardarRegEquipo = function(Equipo){
            // alert(Equipo+' '+$scope.Otam);
            $http.post('dataCharpy.php',{
                idItem: $scope.Otam,
                Equipo: Equipo,
                accion: "guardarEquipo"
            })
            .then(function (response) {
                console.log('OK Equipo');
                $scope.mostrarValImpacto = true;
                $scope.botonActualiza = true;
            }, function(error) {
                alert(error.message);
            });
        };


        $scope.guardarRegAnc = function(Ancho, i){
            // alert(Ancho);
            $http.post('dataCharpy.php',{
                Equipo      : $scope.Equipo,
                idItem      : $scope.Otam,
                nImpacto    : i,
                Ancho       : Ancho,
                accion      : "guardarAncho"
            })
            .then(function (response) {
                $scope.mostrarValImpacto = true;
                $scope.botonActualiza = true;
                console.log('OK Ancho');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarRegAlt = function(Alto, i){
            // alert($scope.Equipo);
            $http.post('dataCharpy.php',{
                Equipo      : $scope.Equipo,
                idItem      : $scope.Otam,
                nImpacto    : i,
                Alto        : Alto,
                accion      : "guardarAlto"
            })
            .then(function (response) {
                $scope.mostrarValImpacto = true;
                $scope.botonActualiza = true;
                console.log('OK Alto');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg4Ra = function(CosProbMen4Ra, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem          : $scope.Otam,
                nImpacto        : i,
                CosProbMen4Ra   : CosProbMen4Ra,
                accion          : "guardarCosProbMen4Ra"
            })
            .then(function (response) {
                console.log('OK CosProbMen4Ra');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg2Ra = function(CarEntMen2Ra, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem:$scope.Otam,
                nImpacto:i,
                CarEntMen2Ra:CarEntMen2Ra,
                accion:"guardarCarEntMen2Ra"
            })
            .then(function (response) {
                console.log('OK CarEntMen2Ra');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg55 = function(Prob55, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem:$scope.Otam,
                nImpacto:i,
                Prob55:Prob55,
                accion:"guardarProb55"
            })
            .then(function (response) {
                console.log('OK Prob55');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg27 = function(CentEnt27, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem:$scope.Otam,
                nImpacto:i,
                CentEnt27:CentEnt27,
                accion:"guardarCentEnt27"
            })
            .then(function (response) {
                console.log('OK CentEnt27');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg45 = function(AngEnt45, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem:$scope.Otam,
                nImpacto:i,
                AngEnt45:AngEnt45,
                accion:"guardarAngEnt45"
            })
            .then(function (response) {
                console.log('OK AngEnt45');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg2mm = function(ProfEnt2mm, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem:$scope.Otam,
                nImpacto:i,
                ProfEnt2mm:ProfEnt2mm,
                accion:"guardarProfEnt2mm"
            })
            .then(function (response) {
                console.log('OK ProfEnt2mm');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg025 = function(RadCorv025, i){
            $http.post('dataCharpy.php',{
                Equipo          : $scope.Equipo,
                idItem:$scope.Otam,
                nImpacto:i,
                RadCorv025:RadCorv025,
                accion:"guardarRadCorv025"
            })
            .then(function (response) {
                console.log('OK RadCorv025');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.activarDesactivar = function(i){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                nImpacto:i,
                accion:"actDes"
            })
            .then(function (response) {
                $scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.cerrarEnsayoIngeniero = function(){
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                accion:"cerrarEnsayoCh"
            })
            .then(function (response) {
                alert('Cerrado el Ensayo...');
                //window.location.href = 'http://servidorerp/erp/generarinformes2/edicionInformes.php?accion=Editar&CodInforme=AM-';
                console.log('OK RadCorv025');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.cerrarEnsayo = function(){
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                accion:"cerrarEnsayoCh"
            })
            .then(function (response) {
                alert('Cerrado el Ensayo...');
                window.location.href = 'http://servidorerp/erp/tallerPM/pTallerPM.php';
                console.log('OK RadCorv025');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.Actualizando = function(){
            arrOtam = $scope.Otam.split('-'); 
            RAM = arrOtam[0];
            
            
            $http.post('dataCharpy.php',{ 
                Otam        : $scope.Otam,
                Estado      : 'R',
                accion      : "cambiarEstado"
            })
            .then(function (response) {
                alert('Se actualizo correctamente ensayo ...'+$scope.Otam);
                window.location.href = 'iCharpy.php?Otam='+$scope.Otam; // 'plataformaErp.php?CAM='+$scope.CAM;

                console.log('OK Estado');
            }, function(error) {
                alert(error.message);
            });
            
            // Actualizado 12/09/2024
            // $scope.regDataImpactos();

            /*
            */
            $scope.botonActualiza = false;
            $scope.mostrarValImpacto = true;
        }
        $scope.guardarRegEqui = function(resEquipo, i){
            // alert($scope.Equipo);
            $http.post('dataCharpy.php',{
                Equipo      : $scope.Equipo,
                idItem      : $scope.Otam,
                nImpacto    : i,
                resEquipo   : resEquipo,
                accion      : "guardarresEquipo"
            })
            .then(function (response) {
                console.log('OK resEquipo');
                $scope.mostrarValImpacto = true;
                $scope.botonActualiza = true;
                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.cambiaFecha = function(){            
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                fechaRegistro:$scope.fechaRegistro,
                accion:"guardarfechaRegistroEnsayo"
            })
            .then(function (response) {
                console.log('OK fechaRegistro');
                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });            
        }
        $scope.cambiaTemAmb = function(){  
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                TemAmb:$scope.TemAmb,
                accion:"cambiaTemAmbiente"
            })
            .then(function (response) {
                console.log('OK TemperaturaAmbiente');
                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });            
        }
        $scope.cambiaTecRes = function(){
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                tecRes:$scope.tecRes,
                accion:"cambiatecnico"
            })
            .then(function (response) {
                console.log('OK ObsOtam');
                $scope.regDataImpactos();

                //$scope.regDataImpactos(); 
            }, function(error) {
                alert(error.message);
            });                     
        }
        $scope.cambiaObs = function(){
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                ObsOtam:$scope.ObsOtam,
                accion:"cambiaObsOtam"
            })
            .then(function (response) {
                console.log('OK ObsOtam');
                $scope.regDataImpactos();

                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });                     
        }
        $scope.cambiaEntalle = function(){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                Entalle:$scope.Entalle,
                accion:"cambiaEntalle"
            })
            .then(function (response) {
                console.log('OK Entalle');
                $scope.regDataImpactos();

                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });            
        }
        $scope.cambiaMm = function(){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                mm:$scope.mm,
                accion:"cambiaMilimetros"
            })
            .then(function (response) {
                console.log('OK Milimetros');
                $scope.regDataImpactos();

                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });            
        }

        $scope.cambiaTem = function(){  
          
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                Tem:$scope.Tem,
                accion:"cambiaTemEnsayo"
            })
            .then(function (response) {
                console.log('OK TemperaturaEnsayo');
                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });            
        }
        $scope.cambiaHum = function(){  
          
            $http.post('dataCharpy.php',{
                Otam:$scope.Otam,
                Hum:$scope.Hum,
                accion:"cambiaHumEnsayo"
            })
            .then(function (response) {
                console.log('OK TemperaturaEnsayo');
                //$scope.regDataImpactos();
            }, function(error) {
                alert(error.message);
            });            
        }
        $scope.getMedia = function(){
            var media = 0;
            var sImpactos = 0;
            let ti = 0;
            for(var i = 0; i < $scope.dataImpactos.length; i++){
                var x = $scope.dataImpactos[i];
                ti++;
                sImpactos += parseFloat(x.vImpacto);
                media = parseFloat(sImpactos) / parseInt(i);
            }
            return sImpactos / ti;
        }
        $scope.regDataImpactos = function(){
            $http.post('dataCharpy.php',{
                idItem  : $scope.Otam,
                accion  : "LecturaRegImpactos"
            })
            .then(function(response){  
                $scope.dataImpactos = response.data.records;

            }, function(error) {
                $scope.errors = error.message;
                console.log('Entra'+$scope.errors);

            });
        }
        $scope.mostrarMsgRespaldo = function(c){
            alert('Ensayo '+c+' respaldado correctamente...');
            $scope.respaldoEnsayo = true;
            //window.location.href = 'http://servidorerp/erp/generarinformes2/edicionInformes.php?accion=Editar&CodInforme='+c;

        }
        $scope.leerCharpy = function(){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                accion:"LecturaImpactos"
            })
            .then(function (response) {
                $scope.CodInforme       = response.data.CodInforme;
                $scope.tpMuestra        = response.data.tpMuestra;
                $scope.actCheck         = response.data.actCheck;
                $scope.Hum              = response.data.Hum;
                $scope.Tem              = response.data.Tem;
                $scope.TemAmb           = response.data.TemAmb;
                $scope.ObsOtam          = response.data.ObsOtam;
                $scope.tecRes           = response.data.tecRes;
                // $scope.Ancho            = response.data.Ancho;
                // $scope.Alto             = response.data.Alto;
                // $scope.resEquipo        = response.data.resEquipo;
                $scope.nImpacto         = response.data.nImpacto;
                $scope.mm               = response.data.mm;
                $scope.Entalle          = response.data.Entalle;
                $scope.Equipo           = response.data.Equipo;
                $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));
            }, function(error) {
                alert(error.message);
            });
        }



});

