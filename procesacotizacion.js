    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.configuracionInicial = false; 
        $rootScope.Estado = "P";
        $rootScope.exentoIva = false;
        $rootScope.datCAM = true;
        $rootScope.btnMuestraDatosCAM = 'Ocultar';

        $rootScope.pasa = 0;
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
        $rootScope.OFE = "off";
        $rootScope.tipoOferta = [
            {
                codOferta:"on",
                descripcion:"Oferta Económica"
            },{
                codOferta:"off",
                descripcion:"Sin Oferta Económica"
            }
            ];
        $rootScope.Moneda = "U";
        $rootScope.tipoMoneda = [
            {
                codMoneda:"U",
                descripcion:"UF"
            },{
                codMoneda:"P",
                descripcion:"Pesos"
            },{
                codMoneda:"D",
                descripcion:"Dolar"
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
        $rootScope.btnCreaCot = false;
        $rootScope.errCreaCot = true;
        $rootScope.dataItems = [];

    });

    app.controller('CtrlCotizaciones', function($scope, $http) {
        
        $scope.activaDesactivaDatos = function() {
            //alert($scope.btnMuestraDatosCAM+' '+$scope.datCAM);
            if($scope.datCAM == true){
                $scope.btnMuestraDatosCAM = 'Muestra';
                $scope.datCAM = false;
            }else{
                $scope.btnMuestraDatosCAM = 'Oculta';
                $scope.datCAM = true;
            }
        }

        $scope.usrCotizador = '';
        $scope.limpiar = function(){
            $scope.Cliente = '';
            $scope.Contacto = '';
        }
        $scope.leerUsrCotizador = function() {
            $http.post("leerUsuarios.php")  
            .then(function(response){  
                $scope.data = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        };

        $scope.descargaCotizacion = function(){
            alert('CAM '+$scope.CAM);
        }


        $scope.accionBorrar = function(CAM){
            //alert('Borrar '+CAM);
            //$location.url("../procesosangular/plataformaCotizaciones.php");

        }

        $scope.calcularFechaEstimada = function(dHabiles, fechaAceptacion){
            $http.post("calcularFecha.php",{dHabiles:dHabiles, fechaAceptacion:fechaAceptacion})
            .then(function(response){
                $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
            }, function(error) {
                $scope.resFecha = error.message;
            });
        }
        $scope.cerrarConfiguracion = function(){
            $scope.configuracionInicial = false;
        }
        $scope.activaConfiguracionCotizacion = function(){
            $scope.configuracionInicial = true;
        }
        // Seguimiento
        $scope.loadCAM = function(CAM){
            //alert('Entra '+CAM);
            $scope.CAM = CAM;
            $scope.resCAM = CAM;
            $scope.pDescuento = 0;
            $scope.valorUF = 0;
            $scope.valorUS = 0;
            $scope.leerUsrCotizador();
            if(CAM == 0){
                $scope.configuracionInicial = true;
                $scope.Validez = 30;
                $scope.dHabiles = 30;
            }else{
                $http.post("leerSeguimientoCotizacion.php",{CAM:CAM})
                .then(function(response){

                    $scope.correoInicioPAM      = response.data.correoInicioPAM;
                    $scope.nOC                  = response.data.nOC;
                    $scope.RAM                  = response.data.RAM;
                    $scope.usrCotizador         = response.data.usrCotizador;
                    $scope.Moneda               = response.data.Moneda;
                    $scope.fechaUF              = response.data.fechaUF;
                    $scope.valorUF              = response.data.valorUF;
                    $scope.valorUS              = response.data.valorUS;
                    $scope.NetoUS               = response.data.NetoUS;
                    $scope.IvaUS                = response.data.IvaUS;
                    $scope.BrutoUS              = response.data.BrutoUS;
                    $scope.NetoUF               = response.data.NetoUF;
                    $scope.IvaUF                = response.data.IvaUF;
                    $scope.BrutoUF              = response.data.BrutoUF;
                    $scope.Neto                 = response.data.Neto;
                    $scope.Iva                  = response.data.Iva;
                    $scope.Bruto                = response.data.Bruto;
                    $scope.exentoIva            = false;
                    if(response.data.exentoIva == 1) {
                        $scope.exentoIva        = true;
                    }
                    //$scope.exentoIva            = response.data.exentoIva;
                    $scope.OFE                  = response.data.OFE;
                    $scope.dHabiles             = response.data.dHabiles;
                    $scope.Validez              = response.data.Validez;
                    $scope.pDescuento           = response.data.pDescuento;
                    $scope.usrResponzable       = response.data.usrResponzable;
                    $scope.tpEnsayo             = response.data.tpEnsayo;
                    $scope.contactoRecordatorio = response.data.contactoRecordatorio;
                    $scope.Observacion          = response.data.Observacion;
                    $scope.RutCli               = response.data.RutCli;
                    $scope.Cliente              = response.data.Cliente;
                    $scope.Contacto             = response.data.Contacto;
                    $scope.nContacto            = response.data.nContacto;
                    $scope.Descripcion          = response.data.Descripcion;
                    $scope.obsServicios          = response.data.obsServicios;
                    $scope.fechaUF              = new Date(response.data.fechaUF.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaCotizacion      = new Date(response.data.fechaCotizacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaAceptacion      = new Date(response.data.fechaAceptacion.replace(/-/g, '\/').replace(/T.+/, ''));
                    $scope.fechaEstimadaTermino = new Date(response.data.fechaEstimadaTermino.replace(/-/g, '\/').replace(/T.+/, ''));
                    if(response.data.fechaAceptacion == '0000-00-00'){
                        $scope.fechaAceptacion = new Date();
                    }

                    $scope.leerDetalleCotizacion(CAM);

                    $scope.leerContacto();
                });           

            }

        }

        //Guardar Seguimiento
        $scope.guardaCAM = function(CAM, RAM, RAMdis, usrCotizador, usrResponzable, fechaEstimadaTermino, fechaAceptacion, nOC, oCompra, oMail, oCtaCte, correoInicioPAM, tpEnsayo, contactoRecordatorio, Observacion){
            if(RAMdis == null)  { 
                RAMdis = 0;  
            }else{
                if(RAMdis > 0){ RAM = RAMdis; }
            }
            if(RAM == null)     { RAM = 0;      }
            if(contactoRecordatorio == null ){ contactoRecordatorio = ''; }
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
            $scope.resGuarda += ' Cont '+ contactoRecordatorio;
            $scope.resGuarda += ' Obs '+ Observacion;

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
                                                    contactoRecordatorio:contactoRecordatorio,
                                                    Observacion:Observacion
                        })
            .then(function (response) {
                $scope.resGuarda = 'OK';
                //$location.url("www.google.com/");
                $scope.leerCotizacionesCAM()
                $scope.leerCotizacionesPAM()
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
        // Fin Seguimiento

        // CREAR COTIZACIÓN
        $scope.leerClientes = function() {
            $scope.Cliente = "";
            $scope.Contacto = "";
            $http.post("leerClientes.php")  
            .then(function(response){  
                $scope.dataClientes = response.data.records;
                $scope.fechaCotizacion = new Date();
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
        $scope.buscaCliente = function() {

            $http.post("leerClientesNombres.php",{Cliente:$scope.Cliente})  
            .then(function(response){  
                $scope.RutCli  = response.data.RutCli;
                $scope.leerContacto();
            }, function(error) {
                $scope.errors = error.message;
            });
        };

        $scope.cargarContactos = function(){
            $scope.showContacto = false;
            $scope.btnCreaCot = false;
            $scope.Contacto = '';
            $scope.buscaCliente();
        }

        $scope.guardarConfiguracion = function(form){
            crearContacto = true;
            $scope.showCliente = false;
            //$scope.showContacto = false;

            //alert(angular.isDate($scope.fechaUF));
            //alert($scope.fechaUF);

            if($scope.Cliente == ''){
                crearContacto = false;
                $scope.showCliente = true;
            }
            if($scope.Contacto == ''){
                crearContacto = false;
                $scope.showContacto = true;
            }
            if($scope.dHabiles >= 0){
            }else{
               alert("DÍAS HABILES: Debe ser un dato numérico");
               $scope.dHabiles = 30; 
               crearContacto = false;
            }
            if($scope.Validez >= 0 && $scope.Validez <= 30){
            }else{
                alert("VALIDEZ: El maximo de días son 30");
                $scope.Validez = 30;
                crearContacto = false;
            }

            if(crearContacto){
                $scope.grabarCotizacion();
             }else{
                alert("Debe ingresar todos los datos...");
            }
        }
        $scope.buscanContacto = function(){
            $scope.nContacto = $scope.Contacto;

            $http.post("buscarnumContacto.php",{RutCli:$scope.RutCli, Contacto:$scope.Contacto})
            .then(function(response){
                $scope.nContacto    = response.data.nContacto;
                $scope.Email        = response.data.Email;
            }, function(error) {
                //$scope.nContacto = error.message;
                $scope.nContacto = 'Seleccionar un Contacto...';
                $scope.Email     = '';
            });
        }
        $scope.leerUltimaCAM = function(){
            CAM = 0;
            $http.get("buscarUltimaCAM.php")  
            .then(function(response){  
                $scope.CAM  = response.data.CAM;
            });
        }
        $scope.valPorcentaje = function(){ 
                $http.post("actualizaItems.php", {
                                                    CAM: $scope.CAM,
                                                    exentoIva: $scope.exentoIva,
                                                    Moneda: $scope.Moneda,
                                                    pDescuento: $scope.pDescuento,
                                                    accion: "ActualizaDescuento"
                                                })  
                .then(function(response){  
                    $scope.res = 'Datos Guardados correctamente...';
                    $scope.getTotalDetalle($scope.pDescuento);
                    //alert(res);
                }, function(error) {
                    $scope.errors = error.message;
                    alert($scope.errors);
                });
            if($scope.pDescuento > 100){
                alert('Debe ingresar un valor entre 0 y 100...');
                $scope.pDescuento = 0;
            }

        }
        $scope.grabarCotizacion = function(){
            //$scope.buscaCliente();
            //alert('CAM '+$scope.CAM);
            exentoIva = 'off';
            if($scope.exentoIva == true){
                exentoIva = 'on';
            }
            fechaUF = $scope.fechaUF;
            if($scope.fechaUF == 'Invalid Date'){
                fechaUF = '0000-00-00';
            }
            if($scope.fechaUF == null){
                fechaUF = '0000-00-00';
            }
            //alert('Graba '+$scope.pDescuento);

            $http.post("buscarUltimaCAM.php", { 
                                                RutCli:$scope.RutCli,
                                                CAM:$scope.CAM,
                                                nContacto:$scope.nContacto,
                                                fechaCotizacion:$scope.fechaCotizacion,
                                                usrCotizador:$scope.usrCotizador,
                                                Validez:$scope.Validez,
                                                dHabiles:$scope.dHabiles,
                                                exentoIva:exentoIva,
                                                tpEnsayo:$scope.tpEnsayo,
                                                OFE:$scope.OFE,
                                                Moneda:$scope.Moneda,
                                                fechaUF:fechaUF,
                                                valorUF:$scope.valorUF,
                                                valorUS:$scope.valorUS,
                                                pDescuento:$scope.pDescuento,
                                                Descripcion:$scope.Descripcion,
                                                obsServicios:$scope.obsServicios,
                                                Observacion:$scope.Observacion
                                                })  
            .then(function(response){  
                $scope.CAM  = response.data.CAM;
                //alert(response.data.CAM);
            });


        }

        $scope.leerDetalleCotizacion = function(CAM){

            $scope.resto = $scope.Moneda;
            $scope.dataItems = [];
            $http.post("leerTablaDetalleServicios.php", {CAM: CAM})  
            .then(function(response){  
                $scope.dataItems = response.data.records;
                $scope.getTotalDetalle($scope.pDescuento);
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.getTotalDetalle = function(pDes){
            var Neto = 0;
            var tNeto = 0;
            var tIva = 0;
            var totalPagar = 0

            var i = 0;
            //$scope.pasa = $scope.pDescuento;

            $scope.dataItems.forEach(x => {
                if($scope.Moneda == 'U'){
                    Neto += parseFloat(x.NetoUF);
                }
                if($scope.Moneda == 'P'){
                    Neto += parseFloat(x.Neto);
                }
                if($scope.Moneda == 'D'){
                    Neto += parseFloat(x.NetoUS);
                }
            });
            tNeto = Neto;
            if($scope.pDescuento > 0){
                tNeto = Neto - (Neto * ($scope.pDescuento / 100));
            }
            if($scope.exentoIva == false){
                $scope.sumaNetoTotal = tNeto;
                tIva = tNeto * 0.19;
                tIva = tIva.toFixed(2);
                totalPagar = parseFloat(tNeto) + parseFloat(tIva);
                $scope.sumaIvaTotal = tIva;
                //$scope.sumaBrutoTotal = tNeto * 1.19;
                $scope.sumaBrutoTotal = totalPagar;
            }else{
                $scope.sumaNetoTotal = tNeto;
                $scope.sumaIvaTotal = 0;
                $scope.sumaBrutoTotal = tNeto;
            }
            //i = $scope.pasa;
            //i++;
            //$scope.pasa = i;
            //alert($scope.CAM);
            $scope.totalNeto = Neto;
            return Neto;
        }
        $scope.calculaValorUFPesos = function(){
            return 28000;
        }
        $scope.NetoTotal = function(nt){
            var n = nt * 0.19;
            $scope.tIva = n;
            return n;
        }
        $scope.leerServicios = function(){
            $http.post("leerTablaServicios.php")  
            .then(function(response){  
                $scope.dataServicios = response.data.records;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        
        $scope.leerServicios();

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
        $scope.activarExentoIva = function(){
            
            //$scope.exentoIva = false; +++
            if($scope.Moneda == 'U' || $scope.Moneda == 'D') {
                //$scope.cambiarMoneda();
            }
            if($scope.Moneda == 'P') {
                $scope.recalcularUnitario($scope.valorUF);
            } 
            if($scope.Moneda == 'D') { 
                $scope.exentoIva = true; 
            }
            $scope.recalcularUnitario($scope.valorUF);

        }

        $scope.cambiarMoneda = function(m){
                    $http.post("actualizaMoneda.php", {
                                                            CAM: $scope.CAM,
                                                            Moneda: $scope.Moneda,
                                                            exentoIva: $scope.exentoIva,
                                                            pDescuento: $scope.pDescuento,
                                                            accion: "ActualizaMoneda"
                                                        })  
                    .then(function(response){  
                        $scope.res = 'Datos Guardados correctamente...';
                        alert(res);
                    }, function(error) {
                        $scope.errors = error.message;
                        alert($scope.errors);
                    });
        }

        $scope.actualizaCostoServicioUF = function(nSer){
            alert('Servicio '+nSer);
        }
        $scope.revisar = function(){
            alert('Entra...');
        }
        $scope.actualizaDatosItems = function(nLin, Cantidad, unitarioUF, unitarioP, unitarioUS, NetoUF, Neto, NetoUS){
            //alert('Entra '+$scope.pDescuento);
            $scope.pasa = $scope.pDescuento;
            NetoUF  = 0;
            IvaUF   = 0;
            TotalUF = 0;
            Neto    = 0;
            Iva     = 0;
            Bruto   = 0;
            NetoUS  = 0;
            IvaUS   = 0;
            TotalUS = 0;
            exentoIva = 'off';

            if($scope.exentoIva == true){
                exentoIva = 'on';
            }
            Guardardatos = false;
            if(Cantidad > 0){
                if($scope.Moneda == 'U'){
                    if(unitarioUF > 0){
                        NetoUF = Cantidad * unitarioUF;
                        if($scope.exentoIva == false){
                            IvaUF = NetoUF * 0.19;
                            TotalUF = NetoUF + IvaUF;
                        }else{
                            IvaUF = 0;
                            TotalUF = NetoUF;
                        }
                        Guardardatos = true;
                        //unitarioP = 0;
                        //unitarioUS = 0;
                    }
                }
                if($scope.Moneda == 'P'){
                    if(unitarioP > 0){
                        Neto = Cantidad * unitarioP;
                        if($scope.exentoIva == false){
                            Iva = Neto * 0.19;
                            Bruto = Neto + Iva;
                        }else{
                            Iva = 0;
                            Bruto = Neto;
                        }
                        Guardardatos = true;
                        //unitarioUF = 0;
                        //unitarioUS = 0;
                    }
                }
                if($scope.Moneda == 'D'){
                    if(unitarioUS > 0){
                        NetoUS = Cantidad * unitarioUS;
                        if($scope.exentoIva == false){
                            IvaUS = NetoUS * 0.19;
                            TotalUS = NetoUS + IvaUS;
                        }else{
                            IvaUS = 0;
                            TotalUS = NetoUS;
                        }

                        Guardardatos = true;
                        //unitarioP = 0;
                        //unitarioUF = 0;
                    }
                }
            }
            

            if(Guardardatos == true){
                
                $http.post("actualizaItems.php", {
                                                    CAM: $scope.CAM,
                                                    nLin: nLin,
                                                    exentoIva: $scope.exentoIva,
                                                    Cantidad: Cantidad,
                                                    unitarioUF: unitarioUF,
                                                    NetoUF: NetoUF,
                                                    IvaUF: IvaUF,
                                                    TotalUF: TotalUF,
                                                    unitarioUS: unitarioUS,
                                                    NetoUS: NetoUS,
                                                    IvaUS: IvaUS,
                                                    TotalUS: TotalUS,
                                                    unitarioP: unitarioP,
                                                    Neto: Neto,
                                                    Iva: Iva,
                                                    Bruto: Bruto,
                                                    Moneda: $scope.Moneda,
                                                    pDescuento: $scope.pDescuento,
                                                    accion: "ActualizaItems"
                                                })  
                .then(function(response){  
                    $scope.res = 'Datos Guardados correctamente...'+$scope.pDescuento;
                    $scope.getTotalDetalle($scope.pDescuento);
                    //alert(res);
                }, function(error) {
                    $scope.errors = error.message;
                    alert($scope.errors);
                });

                //$scope.dataItems = [];
                //$scope.actualizaLineaDetalle(nLin, Cantidad, unitarioUF, unitarioP, unitarioUS);
                //$scope.leerDetalleCotizacion($scope.CAM)
            }else{
                alert('Error de ingreso...');
            }
            
        }



        $scope.actualizaLineaDetalle = function(nLin, Cantidad, unitarioUF, unitarioP, unitarioUS){
            //alert('Items '+$scope.CAM+' '+nLin+' '+Cantidad+' '+unitarioUF+' '+unitarioUS+' '+unitarioP+' '+$scope.Moneda);
/*
            var nLin = 2;
            var dataItems = $scope.dataItems.find(function(obj){
                return obj.nLin == nLin;
            });

            $scope.dataItems.push({
                Servicio: 'Servicio'
            });
*/
            $http.post("actualizaItems.php", {
                                                CAM: $scope.CAM,
                                                nLin: nLin,
                                                Cantidad: Cantidad,
                                                unitarioUF: unitarioUF,
                                                unitarioUS: unitarioUS,
                                                unitarioP: unitarioP,
                                                Moneda: $scope.Moneda
                                            })  
            .then(function(response){  
                $scope.res = 'Datos Guardados correctamente...';
                alert(res);
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });


        }
        $scope.quitarServicio = function(nLin, index){
            //alert('Items '+$scope.CAM+' '+nLin);

            $scope.dataItems.splice(index, 1);
    
            $http.post("borrarItems.php", {
                                                CAM: $scope.CAM,
                                                nLin: nLin,
                                                pDescuento: $scope.pDescuento,
                                                Moneda: $scope.Moneda,
                                                exentoIva: $scope.exentoIva
                                            })  
            .then(function(response){  
                $scope.getTotalDetalle($scope.pDescuento);
                $scope.res = 'Datos Actualizado correctamente...';
            }, function(error) {
                $scope.errors = error.message;
                alert($scope.errors);
            });

        }
        $scope.agregarServicio = function(nServicio, Servicio, ValorUF, ValorUS){
            var uLin = 0;
            var unitarioP = ValorUF * $scope.valorUF;
            var unitarioUS = 0;
            var NetoUF = 0;
            var IvaUF = 0;
            TotalUF = 0;
            var Neto = 0;
            var Iva = 0;
            var Bruto = 0;
            var NetoUS = 0;
            var IvaUS = 0;
            var TotalUS = 0;
            //alert('CAM '+$scope.CAM+' Lin '+uLin);   

            //$scope.leerDetalleCotizacion($scope.CAM);

            $scope.dataItems.forEach(x => {
                uLin = parseInt(x.nLin);
            });
            
            uLin++;  
            if($scope.Moneda == 'U'){
                $scope.dataItems.push({
                                    nLin: uLin, 
                                    Cantidad: 1, 
                                    nServicio: nServicio, 
                                    Servicio: Servicio, 
                                    unitarioUF: ValorUF,
                                    NetoUF:  ValorUF
                                });
                //alert('Valores '+$scope.exentoIva);
                if($scope.exentoIva == false){
                    IvaUF = ValorUF * 0.19;
                    TotalUF = parseFloat(ValorUF) + parseFloat(IvaUF);
                }else{
                    TotalUF = ValorUF;
                }
            }
            if($scope.Moneda == 'P'){
                $scope.dataItems.push({
                                    nLin: uLin, 
                                    Cantidad: 1, 
                                    nServicio: nServicio, 
                                    Servicio: Servicio, 
                                    unitarioP: ValorUF * $scope.valorUF,
                                    NetoUF:  ValorUF
                                });
                if($scope.exentoIva == false){
                    Iva = (ValorUF * $scope.valorUF) * 0.19;
                    Bruto = parseInt(ValorUF * $scope.valorUF) + parseInt(Iva);
                }else{
                    Bruto = parseInt(ValorUF * $scope.valorUF);
                }
            }
            if($scope.Moneda == 'D'){
                $scope.dataItems.push({
                                    nLin: uLin, 
                                    Cantidad: 1, 
                                    nServicio: nServicio, 
                                    Servicio: Servicio, 
                                    unitarioUS: ValorUS,
                                    NetoUS:  ValorUS
                                }); 
                

                if($scope.exentoIva == false){
                    IvaUS = ValorUS * 0.19;
                    TotalUS = parseFloat(ValorUS) + parseFloat(IvaUS);
                }else{
                    TotalUS = ValorUS;
                }
            }
            $scope.res = $scope.CAM+' '+uLin+' '+Servicio+' '+ValorUF+' '+ValorUS+' '+$scope.Moneda;
            $http.post("agregarItems.php", {
                                                CAM: $scope.CAM,
                                                nLin: uLin,
                                                nServicio: nServicio,
                                                Cantidad: 1,
                                                unitarioUF: ValorUF,
                                                NetoUF: ValorUF,
                                                IvaUF: IvaUF,
                                                TotalUF: TotalUF,
                                                unitarioP: unitarioP,
                                                Neto:Neto,
                                                Iva:Iva,
                                                Bruto:Bruto,
                                                unitarioUS: ValorUS,
                                                NetoUS: ValorUS,
                                                IvaUS: IvaUS,
                                                TotalUS: TotalUS,
                                                Moneda: $scope.Moneda,
                                                pDescuento: $scope.pDescuento,
                                                exentoIva: $scope.exentoIva,
                                                accion: "ActualizaItems"
                                            })  
            .then(function(response){  
                $scope.getTotalDetalle($scope.pDescuento);
                $scope.res = 'Datos Guardados correctamente...'+$pDescuento;
            }, function(error) {
                $scope.res = error.message;
                $scope.res = 'Error Guardados correctamente...'+$error;
                //alert($scope.errors);
            });

            
        }

        $scope.actualizarLinea = function(t){
            i = 1;
            $scope.dataItems.forEach(x => {
                Lin = parseInt(x.nLin);
                $scope.dataItems.find(function(v) {
                  return v.nLin == Lin;
                }).nLin = i;
                i++;
            });
        } 
        $scope.cambioExenta = function(){
            //alert('Exenta '+$scope.exentoIva+' '+$scope.valorUF);
            exentoIva = 'off';
            if($scope.exentoIva == true){
                exentoIva = 'on';
            }
            $http.post("actualizaItems.php", {
                                                CAM: $scope.CAM,
                                                pDescuento: $scope.pDescuento,
                                                Moneda: $scope.Moneda,
                                                exentoIva: exentoIva,
                                                accion: "Exenta"
                                              })
            .then(function(response){  
                $scope.getTotalDetalle($scope.pDescuento);
                $scope.res = 'Datos Guardados correctamente...';
            }, function(error) {
               $scope.errors = error.message;
                alert($scope.errors);
            });



/*            
            if($scope.Moneda == 'P'){
                $scope.recalcularUnitario($scope.valorUF);
            }
            if($scope.Moneda == 'U'){
                $scope.recalcularUnitario($scope.valorUF);
            }
            if($scope.Moneda == 'D'){
                $scope.recalcularUnitario($scope.valorUS);
            }
*/            
        }
        $scope.recalcularUnitario = function(vuf){
            exentoIva = 'off';
            if($scope.Moneda == 'P'){
                $scope.dataItems.forEach(x => {
                    Lin = parseInt(x.nLin);
                    vu = parseFloat(x.unitarioUF) * parseFloat(vuf);
                    $scope.dataItems.find(function(v) {
                      return v.nLin == Lin;
                    }).unitarioP = vu;
                });
                $scope.dataItems.forEach(x => {
                    //$scope.resp = 'Entra '+x.unitarioP+' '+x.Neto+' '+x.nLin;
                    Cantidad = x.Cantidad;
                    unitarioP = x.unitarioP;
                    Neto = x.Cantidad * x.unitarioP;
                    if($scope.exentoIva == false){
                        Iva = parseInt(Neto) * 0.19;
                        Bruto = parseInt(Neto) + parseInt(Iva);
                    }else{
                        exentoIva = 'on';
                        Iva = 0;
                        Bruto = Neto;
                    }
                    Lin = x.nLin;
                    $http.post("actualizaItems.php", {
                                                        CAM: $scope.CAM,
                                                        nLin: Lin,
                                                        Cantidad: Cantidad,
                                                        unitarioP: unitarioP,
                                                        Neto: Neto,
                                                        Iva: Iva,
                                                        Bruto: Bruto,
                                                        Moneda: $scope.Moneda,
                                                        valorUS: $scope.valorUS,
                                                        valorUF: $scope.valorUF,
                                                        exentoIva: exentoIva,
                                                        Moneda: $scope.Moneda,
                                                        pDescuento: $scope.pDescuento,
                                                        accion: "ActualizaItems"
                                                    })
                    .then(function(response){  
                        $scope.getTotalDetalle($scope.pDescuento);
                        $scope.res = 'Datos Guardados correctamente...';
                    }, function(error) {
                        $scope.errors = error.message;
                        alert($scope.errors);
                    });
                });
            }
            if($scope.Moneda == 'U'){
                $scope.dataItems.forEach(x => {
                    Cantidad = x.Cantidad;
                    unitarioUF = x.unitarioUF;
                    Neto = x.Cantidad * x.unitarioUF;
                    if($scope.exentoIva == false){
                        Iva = parseFloat(Neto) * 0.19;
                        Bruto = parseFloat(Neto) + parseFloat(Iva);
                    }else{
                        exentoIva = 'on';
                        Iva = 0;
                        Bruto = Neto;
                    }
                    Lin = x.nLin;
                    $http.post("actualizaItems.php", {
                                                        CAM: $scope.CAM,
                                                        nLin: Lin,
                                                        Cantidad: Cantidad,
                                                        unitarioUF: unitarioUF,
                                                        NetoUF: Neto,
                                                        IvaUF: Iva,
                                                        TotalUF: Bruto,
                                                        Moneda: $scope.Moneda,
                                                        valorUS: $scope.valorUS,
                                                        valorUF: $scope.valorUF,
                                                        exentoIva: exentoIva,
                                                        Moneda: $scope.Moneda,
                                                        pDescuento: $scope.pDescuento,
                                                        accion: "ActualizaItems"
                                                    })
                    .then(function(response){ 
                        $scope.getTotalDetalle($scope.pDescuento); 
                        $scope.res = 'Datos Guardados correctamente...';
                    }, function(error) {
                        $scope.errors = error.message;
                        alert($scope.errors);
                    });
                });
            }
            if($scope.Moneda == 'D'){
                valorUS = vuf;
                $scope.dataItems.forEach(x => {
                    Cantidad = x.Cantidad;
                    unitarioUS = x.unitarioUS;
                    Neto = x.Cantidad * x.unitarioUS;
                    if($scope.exentoIva == false){
                        Iva = parseFloat(Neto) * 0.19;
                        Bruto = parseFloat(Neto) + parseFloat(Iva);
                    }else{
                        exentoIva = 'on';
                        Iva = 0;
                        Bruto = Neto;
                    }
                    Lin = x.nLin;
                    //alert('Tot.'+Cantidad+' '+unitarioUS+' '+Neto+' '+Iva+' '+Bruto)
                    $http.post("actualizaItems.php", {
                                                        CAM: $scope.CAM,
                                                        nLin: Lin,
                                                        Cantidad: Cantidad,
                                                        unitarioUS: unitarioUS,
                                                        NetoUS: Neto,
                                                        IvaUS: Iva,
                                                        TotalUS: Bruto,
                                                        Moneda: $scope.Moneda,
                                                        valorUS: $scope.valorUS,
                                                        valorUF: $scope.valorUF,
                                                        exentoIva: exentoIva,
                                                        Moneda: $scope.Moneda,
                                                        pDescuento: $scope.pDescuento,
                                                        accion: "ActualizaItems"
                                                    })
                    .then(function(response){  
                        $scope.getTotalDetalle($scope.pDescuento);
                        $scope.res = 'Datos Guardados correctamente...';
                    }, function(error) {
                        $scope.errors = error.message;
                        alert($scope.errors);
                    });
                });
            }


        } 
        // FIN CREAR COTIZACIÓN
    });

