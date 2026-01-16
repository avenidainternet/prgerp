var app = angular.module('myApp', []);
app.run(function($rootScope){
    $rootScope.CodInforme           = 'AM';
    $rootScope.enProceso            = false;
    $rootScope.tablaFacturas        = false;
    $rootScope.usrResponzable       = '';
    $rootScope.prgActividad         = new Date();
    $rootScope.fechaProxAct         = new Date();
    $rootScope.RutCli               = "";
    $rootScope.Contacto             = "";


    $rootScope.Agnos = [ 
        {
            codAgno:2013,
            descripcion:"2013"
        },{
            codAgno:2014,
            descripcion:"2014"
        },{
            codAgno:2015,
            descripcion:"2015"
        },{
            codAgno:2016,
            descripcion:"2016"
        },{
            codAgno:2017,
            descripcion:"2017"
        },{
            codAgno:2018,
            descripcion:"2018"
        },{
            codAgno:2019,
            descripcion:"2019"
        },{
            codAgno:2020,
            descripcion:"2020"
        },{
            codAgno:2021,
            descripcion:"2021"
        },{
            codAgno:2022,
            descripcion:"2022"
        },{
            codAgno:2023,
            descripcion:"2023"
        },{
            codAgno:2024,
            descripcion:"2024"
        },{
            codAgno:2025,
            descripcion:"2025"
        },{
            codAgno:2026, 
            descripcion:"2026"
        }
     ];

    $rootScope.Meses = [
        {
            codMes:1,
            descripcion:"Enero"
        },{
            codMes:2,
            descripcion:"Febrero"
        },{
            codMes:3,
            descripcion:"Marzo"
        },{
            codMes:4,
            descripcion:"Abril"
        },{
            codMes:5,
            descripcion:"Mayo"
        },{
            codMes:6,
            descripcion:"Junio"
        },{
            codMes:7,
            descripcion:"Julio"
        },{
            codMes:8,
            descripcion:"Agosto"
        },{
            codMes:9,
            descripcion:"Septiembre"
        },{
            codMes:10,
            descripcion:"Octubre"
        },{
            codMes:11,
            descripcion:"Noviembre"
        },{
            codMes:12,
            descripcion:"Diciembre"
        }
        ];

});

app.controller('CtrlFinanzas', function($scope, $http) {
        const fecha = new Date();
        const mesActual = fecha.getMonth() + 1; 
        $scope.MesFiltro = mesActual;
        $scope.AgnosFiltro = fecha.getFullYear();

        $scope.leerClientes = function() {
            $scope.Cliente = "";
            $scope.Contacto = "";
            $http.post("leerClientes.php")  
            .then(function(response){  
                $scope.dataClientes     = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerClientes();
        $scope.leerContacto = function() {
            $scope.errors = '';
            $scope.dataContactos = {};
            $http.post("leerContactos.php", {RutCli:$scope.RutCli})  
            .then(function(response){  
                $scope.dataContactos = response.data.records;
                $scope.showContactoError = false;
                $scope.showContacto = true;
                $scope.btnCreaCot = true;
                $scope.errCreaCot = false;
            }, function(error) {
               //$scope.errors = error.message;
                $scope.errors = 'Cliente Sin Contacto...';
                $scope.showContactoError = true;
                $scope.btnCreaCot = false;
                $scope.errCreaCot = true;
            });
        };
        $scope.cargarContactos = function(){
            $scope.enProceso = true;
            $scope.Contacto = '';
            $scope.buscaCliente();
            $scope.leerDatosFacturas($scope.Cliente,$scope.Contacto);
        }
        $scope.buscaCliente = function() {
            $http.post("leerClientesNombres.php",{Cliente:$scope.Cliente})  
            .then(function(response){  
                $scope.RutCli  = response.data.RutCli;
                $scope.leerContacto();
                $scope.tablaFacturas = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        };

        $scope.iniciaVariables = function( Otam ){
            $scope.Otam = Otam;
            //$scope.leerCharpy();
            //$scope.regDataImpactos();
        }
        $scope.guardarRegAnc = function(Ancho, i){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                nImpacto:i,
                Ancho:Ancho,
                accion:"guardarAncho"
            })
            .then(function (response) {
                $scope.mostrarValImpacto = false;
                $scope.botonActualiza = true;
                console.log('OK Ancho');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarRegAlt = function(Alto, i){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                nImpacto:i,
                Alto:Alto,
                accion:"guardarAlto"
            })
            .then(function (response) {
                $scope.mostrarValImpacto = false;
                $scope.botonActualiza = true;
                console.log('OK Alto');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg4Ra = function(CosProbMen4Ra, i){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                nImpacto:i,
                CosProbMen4Ra:CosProbMen4Ra,
                accion:"guardarCosProbMen4Ra"
            })
            .then(function (response) {
                console.log('OK CosProbMen4Ra');
            }, function(error) {
                alert(error.message);
            });
        }
        $scope.guardarReg2Ra = function(CarEntMen2Ra, i){
            $http.post('dataCharpy.php',{
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
                Otam        :$scope.Otam,
                Estado      :'R',
                accion      :"cambiarEstado"
            })
            .then(function (response) {
                alert('Se actualizo correctamente ensayo ...'+$scope.Otam);
                console.log('OK Estado');
            }, function(error) {
                alert(error.message);
            });
            

            $scope.regDataImpactos();

            /*
            */
            $scope.botonActualiza = false;
            $scope.mostrarValImpacto = true;
        }
        $scope.guardarRegEqui = function(resEquipo, i){
            $http.post('dataCharpy.php',{
                idItem:$scope.Otam,
                nImpacto:i,
                resEquipo:resEquipo,
                accion:"guardarresEquipo"
            })
            .then(function (response) {
                console.log('OK resEquipo');
                $scope.mostrarValImpacto = false;
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
                idItem:$scope.Otam,
                accion:"LecturaRegImpactos"
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
        $scope.leerDatosFacturas = function(Cliente, Contacto){
            console.log(Cliente+' '+Contacto);
            $scope.Contacto = Contacto;
            $http.post('dataFinanciero.php',{
                Cliente:Cliente,
                Contacto:Contacto,
                accion:"rescataFacturas"
            })
            .then(function (response) {
                $scope.dataFacturas     = response.data.records;
                $scope.enProceso = false;
            }, function(error) {
                alert(error.message);
                $scope.enProceso = false;
            });
        }



});

