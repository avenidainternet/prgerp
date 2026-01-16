    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        
        //$rootScope.accion           = "New";
        //$rootScope.RAM              = "New";
        $rootScope.funcionalidad    = "Registro";
        $rootScope.tablaCAM         = false;
        $rootScope.botonBaja        = false;
        $rootScope.fechaRegistro    = new Date(); 
        

        $rootScope.filtrado = false;
        $rootScope.ramAsociar = '';
        $rootScope.upOC   = true;
        $rootScope.tipoEstado = [
            {
                codEstado:"P",
                descripcion:"En Proceso"
            },{
                codEstado:"T",
                descripcion:"Terminar Proceso"
            },{
                codEstado:"E",
                descripcion:"Volver a CAM"
            },{
                codEstado:"N",
                descripcion:"Anular Proceso"
            }
            ];
        $rootScope.tpEnsayo = "1";
        $rootScope.tipoEnsayo = [
            {
                codEnsayo:"1",
                descripcion:"Informe de Caracterización"
            },{
                codEnsayo:"2",
                descripcion:"Análisis de Falla"
            },{
                codEnsayo:"3",
                descripcion:"Certificado de Ensayos"
            }
            ,{
                codEnsayo:"4",
                descripcion:"Informe de Resultados"
            }
            ];
        $rootScope.correoInicioPAM  = "off";
        $rootScope.envios = [
            {
                codEnvio:"on",
                descripcionEnvio:"Si" 
            },{
                codEnvio:"off",
                descripcionEnvio:"No"
            }
            ];
        $rootScope.RAM              = '';
        $rootScope.usrCotizador     = '';
        $rootScope.usrResponzable   = '';
        $rootScope.oCompra          = false;
        $rootScope.oMail            = false;
        $rootScope.oCtaCte          = false; 
        $rootScope.nOC              = '';

    });

    app.controller('CtrlRAM', function($scope, $http) {
        
        $scope.iniciaVariables = function(a, r, f){
            if(a == 'Agrega'){ $scope.funcionalidad = 'Registrar Muestra'; }
            if(a == 'Editar'){ $scope.funcionalidad = 'Edición de Muestra'; }
            if(a == 'Borrar'){ $scope.funcionalidad = 'Eliminación de Muestra'; }
            $scope.accion = a;
            $scope.RAM = r;
            $scope.Fan = f;
            $scope.buscarMuestra();
            if($scope.accion == 'Borrar'){
                $scope.botonGuardar     = false;
                $scope.botonAct         = false;
                $scope.botonBaja        = true;
            }
            if($scope.accion == 'Editar'){
                $scope.botonGuardar     = true;
                $scope.botonAct         = false;
                $scope.botonBaja        = false;
            }
            if($scope.accion == 'Agrega'){
                $scope.botonGuardar     = false;
                $scope.botonAct         = true;
                $scope.botonBaja        = false;
            }
        }
        $scope.buscarMuestra = function(){
            $http.post("Tablas.php",{
                                        RAM     :$scope.RAM,
                                        Fan     :$scope.Fan,
                                        accion  : 'L'
            })  
            .then(function(response){  
                
                $scope.fechaRegistro    = new Date(response.data.fechaRegistro.replace(/-/g, '\/').replace(/T.+/, ''));
                $scope.usrRecepcion     = response.data.usrRecepcion; 
                $scope.usr              = response.data.usrRecepcion; 
                $scope.CAM              = response.data.CAM; 
                $scope.Copias           = response.data.Copias; 
                $scope.RutCli           = response.data.RutCli; 
                $scope.Cliente          = response.data.Cliente; 
                $scope.nContacto        = response.data.nContacto; 
                $scope.Descripcion      = response.data.Descripcion; 
                $scope.tablaCAM         = true;
                $scope.filtroClientes = $scope.RutCli;
                $scope.leerCotizacionesCAM();

            }, function(error) {
                $scope.errors = error.message;
                alert('Entra'+error);
            });

        }
        $scope.bajaRAM = function(){
            //alert($scope.RAM+' '+$scope.CAM+' '+$scope.Fan);
            
            $http.post("Tablas.php",{
                RAM     :$scope.RAM,
                Fan     :$scope.Fan,
                CAM     :$scope.CAM,
                accion  : 'DarDeBajaRAM'
            })  
            .then(function(response){
                alert('RAM Dado de Baja...');
                window.location.href = 'http://servidordata/erperp/registroMat/';
            }, function(error) {
                $scope.errors = error.message;
                alert('Entra'+error);
            });
            
        }
        $scope.agregarRAM = function(){
            $scope.tablaCAM         = true;
            CAM = 0;
            Fan = 0;
            Validado = 'NO';
            if($scope.CAM > 0){
                CAM = $scope.CAM;
            }
            if($scope.Fan > 0){
                Fan = $scope.Fan;
            }
            if($scope.Descripcion != ''){
                Validado == 'SI';
            }
            if(Validado == 'NO'){
                $http.post('Tablas.php', {
                                                    CAM             :CAM, 
                                                    RAM             :$scope.RAM,
                                                    Fan             :Fan,
                                                    Copias          :$scope.Copias,
                                                    fechaRegistro   :$scope.fechaRegistro,
                                                    RutCli          :$scope.RutCli,
                                                    Descripcion     :$scope.Descripcion,
                                                    accion          :'AM'
                })
                .then(function (response) {
                    $scope.RAM              = response.data.RAM; 
                    $scope.filtroClientes   = $scope.RutCli;
                    $scope.accion           = 'Editar';
                    $scope.botonGuardar     = true;
                    $scope.botonAct         = false;
                    $scope.botonBaja        = false;
                    $scope.buscarMuestra()
                }, function(error) {
                    alert(error);
                });
            }else{
                alert('Debe ingresar todos los datos...');
            }
        }
        $scope.desasociarMuestra = function(RAM, CAM, Fan){
            $http.post('Tablas.php', {
                                                    CAM             :CAM, 
                                                    RAM             :$scope.RAM,
                                                    Fan             :$scope.Fan,
                                                    accion          :'DCR'
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                alert('Desasociado correctamente...');
                $scope.buscarMuestra()
            }, function(error) {
                alert(error);
            });

        }

        $scope.asociarMuestra = function(RAM, CAM, Fan){
            $http.post('Tablas.php', {
                                                    CAM             :CAM, 
                                                    RAM             :$scope.RAM,
                                                    Fan             :$scope.Fan,
                                                    accion          :'ACR'
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                alert('Asociado correctamente...');
                $scope.buscarMuestra()
            }, function(error) {
                alert(error);
            });

        }
        $scope.guardarRAM = function(){
            CAM = 0;
            Fan = 0;
            $validado = 'NO';
            if($scope.CAM > 0){
                CAM = $scope.CAM;
            }
            if($scope.Fan > 0){
                Fan = $scope.Fan;
            }
            if($scope.usr != ''){
                $validado = 'SI';
            }
            alert('Creando CLONES...');
            if($validado == 'SI'){
                $http.post('Tablas.php', {
                                                    CAM             :CAM, 
                                                    RAM             :$scope.RAM,
                                                    Fan             :Fan,
                                                    Copias          :$scope.Copias,
                                                    fechaRegistro   :$scope.fechaRegistro,
                                                    RutCli          :$scope.RutCli,
                                                    Descripcion     :$scope.Descripcion,
                                                    accion          :'G'
                        })
                .then(function (response) {
                    $scope.resGuarda = 'OK';
                    $scope.buscarMuestra()
                }, function(error) {
                    alert(error);
                });
            }else{
                alert('Ingrese todos los datos...');
            }
        }

        $scope.leerClientes = function() {
            $scope.Cliente = "";
            $scope.Contacto = "";
            $http.post("Tablas.php",{accion: 'LCli'})  
            .then(function(response){  
                $scope.dataClientes = response.data.records;
                $scope.leerContacto();
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerClientes();
        $scope.leerContacto = function() {
            $http.post("Tablas.php",{RutCli:$scope.RutCli, accion:'LCon'})  
            .then(function(response){  
                $scope.dataContactos = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.lecturaUsuarios = function(){
            $http.post("Tablas.php",{accion:'LUsr'})  
            .then(function(response){  
                $scope.dataUsuarios = response.data.records; 
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.lecturaUsuarios();

        $scope.leerCotizacionesCAM = function(){
            $scope.errors = "";
            $http.post("leerCAMs.php",{RutCli:$scope.RutCli})   
            .then(function(response){  
                $scope.CotizacionesCAM = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.getTotalCAMs = function(){
            var totalCAM = 0;
            for(var i = 0; i < $scope.CotizacionesCAM.length; i++){
                var x = $scope.CotizacionesCAM[i];
                //if(x.Moneda == 'U' && x.Estado == 'E'){
                if(x.Moneda == 'U'){
                    totalCAM += parseFloat(x.BrutoUF);
                }
            }
            //$scope.tResultados = total;
            return totalCAM;
        }

        $scope.leerMuestrasRAM = function(){

            $scope.cargaDatos = true;
            $scope.errors = "";
            $http.post("leerRAMs.php")   
            .then(function(response){  
                $scope.MuestrasRAM = response.data.records;
                $scope.cargaDatos = false;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        $scope.leerMuestrasRAM();

        $scope.filtrarMuestra = function(RutCli, RAM){
            $scope.filtrado = true;
            $scope.ramAsociar = RAM;
        }

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
        $scope.getTotalPAMs = function(){
            var totalPAM = 0;
            for(var i = 0; i < $scope.CotizacionesPAM.length; i++){
                var x = $scope.CotizacionesPAM[i];
                    totalPAM += parseFloat(x.NetoUF);
            }
            //$scope.tResultados = total;
            return totalPAM;
        }


        $scope.muestraTodos = function(usr){
            $scope.leerCotizacionesPAM();
        }
        $scope.calcularFechaEstimada = function(dHabiles, fechaAceptacion){
            $http.post("calcularFecha.php",{dHabiles:dHabiles, fechaAceptacion:fechaAceptacion})
            .then(function(response){
                $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
            }, function(error) {
                $scope.resFecha = error.message;
            });
        }
        $scope.calcularFechaEstimadaPAM = function(dHabiles, fechaInicio){
            //alert('Entra');
            $http.post("calcularFechaPAM.php",{dHabiles:dHabiles, fechaInicio:fechaInicio})
            .then(function(response){
                $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
            }, function(error) {
                $scope.resFecha = error.message;
            });
        }
        $scope.calcularDiasHabilesPAM = function(fechaEstimadaTermino, fechaInicio){
            $http.post("calculardHabilesPAM.php",{fechaEstimadaTermino:fechaEstimadaTermino, fechaInicio:fechaInicio})
            .then(function(response){
                //alert('Entra '+fechaEstimadaTermino+' '+fechaInicio);
                $scope.dHabiles = response.data.dHabiles;
            }, function(error) {
                $scope.resFecha = error.message;
                alert($scope.resFecha);
            });
        }

        $scope.filtroUsr = function(usr){
            $scope.filtroClientes = '';
            //$scope.filtroClientes = usr;
            $scope.tablaPAM = false;
            $scope.cargaDatos = true;

            $scope.errors = "";
            $http.post("leerCAMs.php", {usrCotizador:usr})  
            .then(function(response){  
                $scope.CotizacionesCAM = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
            if(usr == 'Baja'){
                $scope.tablaPAM = false
            }
            $scope.errors = "";
            $http.post("leerPAMs.php", {usrCotizador:usr})  
            .then(function(response){  
                $scope.CotizacionesPAM = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
            $scope.cargaDatos = false;
            if(usr != 'Baja'){
                $scope.tablaPAM = true
            }
        }

        $scope.leerCotizacionesPAM();

        $scope.quitarFiltro = function(){
            $scope.filtroClientes = '';
            $scope.filtrado = false;
            $scope.ramAsociar = '';
        }

        $scope.verColorLinea = function(Estado, RAM, BrutoUF, nDias, rCot, fechaAceptacion, proxRecordatorio, colorCam){
            mColor = 'Blanco';
            retorno = {'default-color': true};
            if(Estado == 'E'){
                if(nDias <= 3){
                    retorno = {'rojo-class': true};
                    mColor = 'Rojo';
                }else{
                    retorno = {'amarillo-class': true};
                    mColor = 'Amarillo';
                }
            }
            if(RAM > 0){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }
           
            if(mColor == 'Rojo'){
                if(BrutoUF <= rCot){
                    retorno = {'verde-class': true};
                    mColor = 'Verde';
                }
            }
            if(Estado == 'C'){
                retorno = {'azul-class': true};
                mColor = 'Azul';
            }

            if(proxRecordatorio == '0000-00-00'){
                retorno = {'verde-class': true};
                mColor = 'Verde';
            }


            if(Estado != 'E'){
                retorno = {'default-color': true};
                mColor = 'Blanco';
            }
            if(colorCam == 'Blanco'){ retorno = {'default-color': true}; }
            if(colorCam == 'Rojo'){ retorno = {'rojo-class': true}; }
            if(colorCam == 'Amarilla'){ retorno = {'amarillo-class': true}; }
            if(colorCam == 'Verde'){ retorno = {'verde-class': true}; }
            return retorno;
        }
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


        // Seguimiento PAM
        $scope.seguimientoPAM = function(CAM, RAM){
            $scope.CAM = CAM;
            $scope.RAM = RAM;
            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){

                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.usrCotizador         = response.data.usrCotizador;
                    $scope.usrResponzable       = response.data.usrResponzable;
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.Estado               = response.data.Estado;
                    $scope.usrPega              = response.data.usrPega;
                    $scope.Descripcion          = response.data.Descripcion;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.fechaInicio          = new Date(response.data.fechaInicio.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaTermino         = new Date(response.data.fechaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaPega            = new Date(response.data.fechaPega.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaTermino == '0000-00-00'){
                        $scope.fechaTermino = new Date();
                    }
                    $scope.leerUsrResponsable();
                    $scope.leerUsrPega();
                });           

        }
        $scope.volverCAM = function(CAM){
            $http.post('volverCAM.php', {
                                                    CAM:CAM
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
        }
        
        $scope.actCopias = function(){
            $scope.Clones = $scope.Copias;
        }

        //Guardar Seguimiento
        $scope.separarRAM = function(CAM, RAM){
            $http.post('separaRAM.php', {
                                                    CAM:CAM, 
                                                    RAM:RAM
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
        }
        $scope.guardaPAM = function(CAM, RAM, fechaEstimadaTermino, nOC, Estado, dHabiles, usrResponzable, tpEnsayo, fechaPega, usrPega, Descripcion){
            if(RAM == null)     { RAM = 0;      }
            if(Descripcion == null)     { Descripcion = '';      }
            //alert('Entra '+Estado);
            $scope.resGuardaPAM = 'CAM '+CAM;
            $scope.resGuardaPAM += ' Desc '+Descripcion;
/*            
            $scope.resGuardaPAM += ' RAM '+RAM;
            $scope.resGuardaPAM += ' Est '+Estado;
            $scope.resGuardaPAM += ' Ter '+fechaTermino;
            $scope.resGuardaPAM += ' Hab '+dHabiles;
            $scope.resGuardaPAM += ' nOC '+nOC;
            $scope.resGuardaPAM += ' Res '+usrResponzable; 
            $scope.resGuardaPAM += ' TP '+tpEnsayo;
            $scope.resGuardaPAM += ' usr '+usrPega;
*/
            //alert(' Res '+usrResponzable);

            $http.post('grabarSeguimientoPAM.php', {
                                                    CAM:CAM, 
                                                    RAM:RAM,
                                                    fechaEstimadaTermino:fechaEstimadaTermino,
                                                    nOC:nOC,
                                                    Estado:Estado,
                                                    dHabiles:dHabiles,
                                                    usrResponzable:usrResponzable,
                                                    tpEnsayo:tpEnsayo,
                                                    fechaPega:fechaPega,
                                                    usrPega:usrPega,
                                                    Descripcion:Descripcion
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesPAM()
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });


            $nOC                = '';
            $dHabiles           = 0;
            $tpEnsayo           = '';
            $usrPega            = '';
            $Descripcion        = '';

        }      


        // Fin Seguimiento PAM

        // Seguimiento
        $scope.editarSeguimiento = function(CAM){
            $scope.CAM = CAM;

            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){
                    //alert('Entra');
                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.Estado               = response.data.Estado;
                    $scope.usrCotizador         = response.data.usrCotizador;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.usrResponzable       = response.data.usrResponzable;
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.contactoRecordatorio = response.data.contactoRecordatorio;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaAceptacion == '0000-00-00'){
                        $scope.fechaAceptacion = new Date();
                    }

                    $scope.oCompra      = false;
                    if(response.data.oCompra == 'on'){
                        $scope.oCompra      = true;
                    }
                    $scope.oMail        = false;
                    if(response.data.oMail == 'on'){
                        $scope.oMail      = true;
                    }
                    $scope.oCtaCte      = false;
                    if(response.data.oCtaCte == 'on'){
                        $scope.oCtaCte      = true;
                    }
                    $scope.RAMasignada = false;
                    if(response.data.RAM> 0){
                        $scope.RAMasignada = true;
                    }
                    $scope.leerUsrCotizador();
                    $scope.leerUsrResponsable();
                    $scope.loadRamsDisponibles(response.data.RutCli);
                    $scope.leerSeguimientoCAM(CAM);
                    //$scope.apply();
                    //$scope.oCompra      = true;
                    //salert('Entra '+$scope.oCompra);
                }, function(error) {
                    $scope.errors = error.message;
                    alert('Error '+$scope.errors);
                });           
        }

        $scope.leerSeguimientoCAM = function(CAM){
            $http.post("leerSeguimientoCAMs.php", {CAM:CAM})  
            .then(function(response){  
                $scope.seguimientoCAM = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });

        }


        // Borrar
        $scope.editarBorrar = function(CAM){
            $scope.CAM = CAM;
            $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){

                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.usrCotizador         = response.data.usrCotizador;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.usrResponzable       = response.data.usrResponzable;
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.contactoRecordatorio = response.data.contactoRecordatorio;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaAceptacion == '0000-00-00'){
                        $scope.fechaAceptacion = new Date();
                    }

                    $scope.oCompra      = false;
                    if(response.data.oCompra == 'on'){
                        $scope.oCompra      = true;
                    }
                    $scope.oMail        = false;
                    if(response.data.oMail == 'on'){
                        $scope.oMail      = true;
                    }
                    $scope.oCtaCte      = false;
                    if(response.data.oCtaCte == 'on'){
                        $scope.oCtaCte      = true;
                    }
                    $scope.RAMasignada = false;
                    if(response.data.RAM> 0){
                        $scope.RAMasignada = true;
                    }
                    $scope.leerUsrCotizador();
                    $scope.leerUsrResponsable();
                    $scope.loadRamsDisponibles(response.data.RutCli);
                    //$scope.apply();
                    //$scope.oCompra      = true;
                    //salert('Entra '+$scope.oCompra);
                });           
        }

        $scope.cerrarCAM = function(CAM){
            //alert(CAM);
            $http.post("cerrarCAM.php",{CAM:CAM})
            .then(function(response){  
                $scope.leerCotizacionesPAM()
                //alert('Cerrada');
            }, function(error) {
                $scope.errors = error.message;
            });

        }

        $scope.leerUsrCotizador = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.data = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerUsrResponsable = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.dataResponsable = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.leerUsrPega = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.dataPega = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };
        $scope.loadRamsDisponibles = function(rut){
            $scope.res = rut;
            $scope.RAMdisponibles = false;
            $http.post("leerRegistroMateriales.php",{RutCli:rut})  
            .then(function(response){  
                $scope.RAMs = response.data.records;
                $scope.RAMdisponibles = true;
            }, function(error) {
                $scope.errors = error.message;
            });
        }

        //Guardar Seguimiento
        $scope.guardaCAM = function(CAM, RAM, RAMdis, usrCotizador, usrResponzable, fechaEstimadaTermino, fechaAceptacion, nOC, oCompra, oMail, oCtaCte, correoInicioPAM, tpEnsayo, NewcontactoRecordatorio, Observacion, Estado, dHabiles){
            if(RAMdis == null)  { 
                RAMdis = 0;  
            }else{
                if(RAMdis > 0){ RAM = RAMdis; }
            }
            if(RAM == null)     { RAM = 0;      }
            if(NewcontactoRecordatorio == null ){ NewcontactoRecordatorio = ''; }
            if(Observacion == null ){ Observacion = ''; }

            $scope.resGuarda = 'CAM '+CAM;
            $scope.resGuarda += ' RAM '+RAM;
            $scope.resGuarda += ' RAMd '+RAMdis;
            //$scope.resGuarda += ' Cot '+usrCotizador;
            //$scope.resGuarda += ' Res '+usrResponzable;
            //$scope.resGuarda += ' Est '+fechaEstimadaTermino;
            //$scope.resGuarda += ' Ace '+fechaAceptacion;
            //$scope.resGuarda += ' nOC '+nOC;
            //$scope.resGuarda += ' OC '+oCompra;
            //$scope.resGuarda += ' OMail '+oMail;
            //$scope.resGuarda += ' oCta '+oCtaCte;
            $scope.resGuarda += ' Ini '+correoInicioPAM;
            $scope.resGuarda += ' Ens '+tpEnsayo;
            $scope.resGuarda += ' Cont '+ NewcontactoRecordatorio;
            $scope.resGuarda += ' Obs '+ Observacion;

            //alert($scope.resGuarda);


            $http.post('grabarSeguimientoCAM.php', {
                                                    CAM:$scope.CAM, 
                                                    RAM:RAM,
                                                    usrCotizador:usrCotizador,
                                                    usrResponzable:usrResponzable,
                                                    fechaEstimadaTermino:fechaEstimadaTermino,
                                                    correoInicioPAM:correoInicioPAM,
                                                    fechaAceptacion:fechaAceptacion,
                                                    nOC:nOC,
                                                    oCompra:oCompra,
                                                    oMail:oMail,
                                                    oCtaCte:oCtaCte,
                                                    tpEnsayo:tpEnsayo,
                                                    NewcontactoRecordatorio:NewcontactoRecordatorio,
                                                    Observacion:Observacion,
                                                    Estado:Estado,
                                                    dHabiles:dHabiles
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                $scope.leerCotizacionesPAM()
                if(correoInicioPAM == 'on'){
                    $scope.enviarCorreo(CAM, RAM);
                }
                //$location.url("www.google.com/");
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
            });
            
            $scope.oCompra  = false;
            $scope.oMail    = false;
            $scope.oCtaCte  = false;
            $contactoRecordatorio = '';
            $Observacion = '';

        }    

        $scope.enviarCorreo = function(CAM, RAM){
            $http.post('enviarCorreoEstadoServicio.php', {
                                                    CAM:$scope.CAM, 
                                                    RAM:RAM
                        })
            .then(function (response) {
                alert('Correo Enviado...');
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });

        }

        $scope.cambiaCotizador = function(){
            $scope.usrCotiza = $scope.usrCotizador;
        }
        // Fin Seguimiento

        // CREAR COTIZACIÓN

        $scope.cargarContactos = function(){
            //alert('Cliente '+$scope.Cliente);
        }



        $scope.loadRegistro = function(CAM){
            $scope.CAM = CAM;
            $http.post("controlRegistros.php", {CAM:CAM})  
            .then(function(response){  
                $scope.Cliente  = response.data.Cliente;
                $scope.HES      = response.data.HES;
                $scope.RAM      = response.data.RAM;
                if($scope.RAM > 0) {
                    $scope.muestraRAM = true;
                }
            }, function(error) {
                $scope.errors = error.message;
            });

        }
        // FIN CREAR COTIZACIÓN
    });

