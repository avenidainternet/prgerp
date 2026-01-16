    var app = angular.module('myApp', []);
    app.controller('CtrlFacturas', function($scope, $http) {
        $scope.detalleSolicitudes = {};
        $scope.loading = true;
        $scope.bGuardaRef = "Actualizar";
        $scope.bRefClase = "btn btn-success"; 
        $http.post('cargarValReferencias.php')
        .then(function (response) {
            $scope.valorUFRef   = response.data.valorUFRef;
            $scope.tFacturadas  = response.data.tFacturadas;
            $scope.tSinFacturar = response.data.tSinFacturar;
            $scope.facturasSP   = response.data.facturasSP;
            $scope.tgFacturadas = response.data.tgFacturadas;
            $scope.valorUSRef   = response.data.valorUSRef;
            //$scope.loading = false;
        });
        $scope.lecturaDatos = function(){
            $scope.errors = "";
            $scope.loading = true;
            $http.get("leerSolicitudes.php") 
            .then(function(response){  
                $scope.Solicitudes = response.data.records;
                $scope.tSolicitudes = true;
                $scope.loading = false;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.lecturaDatos();

        $scope.lecturaDatosTransferencias = function(){
            $scope.errors = "";
            $scope.loading = true;
            $http.get("leerSolicitudesTransferencias.php")  
            .then(function(response){  
                $scope.Solicitudes = response.data.records;
                $scope.tSolicitudes = true;
                $scope.loading = false;
            }, function(error) {
                $scope.errors = error.message;
            });
        }
        $scope.lecturaDatosPagadas = function(){
            $scope.errors = "";
            $scope.loading = true;
            $scope.tSolicitudes = false;
            $http.get("leerSolicitudesPagadas.php")  
            .then(function(response){  
                $scope.Solicitudes = response.data.records;
                $scope.tSolicitudes = true;
                $scope.loading = false;
            }, function(error) {
                $scope.errors = error.message;
            });
            $scope.tSolicitudes = true;
        }



        $scope.guardarReferencias = function(){
            $http.post('guardarValRef.php', {valorUFRef:$scope.valorUFRef, valorUSRef:$scope.valorUSRef})
            .then(function (response) {
                $scope.bRefClase    = "btn btn-warning";
                $scope.bGuardaRef   = "Actualizado";
            });
        }
        $scope.editarSeguimiento = function(index){
            $scope.respuesta = index;
            $scope.detalleSolicitudes = $scope.Solicitudes[index];
            var modal_element = angular.element('#modal_seguimiento');
            modal_element.modal('show');
        }
        $scope.actSeguimiento = function(){
            if($scope.Fotocopia == true){
               $scope.fechaFotocopia = new Date();
            }else{
               $scope.fechaFotocopia = "";
            }
        }
        $scope.actSeguimientoFactura = function(){
            //alert($scope.Factura);
            if($scope.Factura == true){
                $scope.fechaFactura = new Date();
            }else{
                $scope.Factura = false;
                $scope.nFactura = 0;
                $scope.fechaFactura = "";
            }
        }
        $scope.actSeguimientoPago = function(){
            
            if($scope.pagoFactura == true){
                $scope.fechaPago = new Date();
                $scope.montoAbonar = $scope.Saldo;
            }else{
                $scope.pagoFactura = false;
                $scope.fechaPago = "";
            }
        }
        $scope.actSeguimientoTransferencia = function(){
            //alert($scope.Factura);
            if($scope.Transferencia == true){
                $scope.fechaTransferencia = new Date();
            }else{
                $scope.Transferencia = false;
                $scope.fechaTransferencia = "";
            }
        }
        $scope.modiTotales = function(vUF){
            $scope.vUF = vUF;
            $scope.Neto = (vUF * $scope.netoUF);
            if($scope.Exenta == 'on'){
                $scope.Iva = 0;
                $scope.Bruto = $scope.Neto;
            }else{
                $scope.Iva = ($scope.Neto * 0.19);
                $scope.Bruto = ($scope.Neto + $scope.Iva);
            }
            $scope.Saldo = $scope.Bruto;
        }
        $scope.modiTotalesUS = function(vUS){
            $scope.Neto = (vUS * $scope.NetoUS);
            if($scope.Exenta == 'on'){
                $scope.Iva = 0;
                $scope.Bruto = $scope.Neto;
            }else{
                $scope.Iva = ($scope.Neto * 0.19);
                $scope.Bruto = ($scope.Neto + $scope.Iva);
            }
            $scope.Saldo = $scope.Bruto;
        }

        $scope.editarSeguimientoOld = function(nSol){ 
            $scope.Fotocopia        = false;
            $scope.Factura          = false;
            $scope.pagoFactura      = false;
            $scope.Transferencia    = false;
            $scope.fechaTransaccion = new Date();
            $scope.abonoSaldo       = 0;
            $scope.nFactura         = 0;
            $scope.valorUF          = 0;
            $scope.valorUS          = 0;
            $scope.NetoUS           = 0;
            $scope.netoUF           = 0;
            $scope.montoAbonar      = 0;

            $http.post("leerSeguimientoSolicitud.php",{nSolicitud:nSol})
            .then(function(response){  
                $scope.nSolicitud = nSol;
                //$scope.nSolicitud = response.data.nSolicitud;
                $scope.Cliente          = response.data.Cliente;

                if(response.data.Fotocopia == 'on'){
                    $scope.Fotocopia    = true;
                }
                $scope.fechaSolicitud   = response.data.fechaSolicitud;
                $scope.fechaFotocopia   = new Date(response.data.fechaFotocopia.replace(/-/g, '\/').replace(/T.+/, ''));
                //$scope.fechaFotocopia   = response.data.fechaFotocopia;
                if(response.data.Factura == 'on'){
                    $scope.Factura    = true;
                }
                $scope.nFactura         = response.data.nFactura;
                $scope.fechaFactura     = new Date(response.data.fechaFactura.replace(/-/g, '\/').replace(/T.+/, ''));
                if(response.data.pagoFactura == 'on'){
                    $scope.pagoFactura    = true;
                }
                if(response.data.Transferencia == 'on'){
                    $scope.Transferencia    = true;
                }
                $scope.fechaPago        = new Date(response.data.fechaPago.replace(/-/g, '\/').replace(/T.+/, ''));
                $scope.Exenta           = response.data.Exenta;
                $scope.valorUF          = response.data.valorUF;
                $scope.netoUF           = response.data.netoUF;
                $scope.ivaUF            = response.data.ivaUF;
                $scope.brutoUF          = response.data.brutoUF;
                $scope.valorUS          = response.data.valorUS;
                $scope.NetoUS           = response.data.NetoUS;
                $scope.IvaUS            = response.data.IvaUS;
                $scope.BrutoUS          = response.data.BrutoUS;
                $scope.Neto             = response.data.Neto;
                $scope.Iva              = response.data.Iva;
                $scope.Bruto            = response.data.Bruto;
                $scope.Abono            = response.data.Abono;
                //$scope.Saldo            = response.data.Saldo;
                $scope.Saldo            = response.data.Bruto -  response.data.Abono;
            });
        }

        $scope.cambiodeDatos = function(){
           alert($scope.datos) ; 
        }

        $scope.verColorLinea = function(Estado, Factura, pagoFactura, Transferencia, moroso90Dias){
            retorno = {'verde-class': true};
            
            if(Estado == 'I'){ 
                retorno = {'custom-class': true};
            }
            if(Factura == 'on'){ // Precaucion
                retorno = {'amarillo-class': true};
            }
            if(Estado == 'Atrazado'){ // Malo
                retorno = {'rojo-class': true};
            }
            if(Estado == 'ND'){ // Malo
                retorno = {'rojo-class': true};
            }
            if(moroso90Dias == 1){ // Morosos
                retorno = {'moroso-color': true};
            }
            
            return retorno;
        }


        $scope.guardarSeguimiento = function(){
            Fotocopia = '';
            if($scope.Fotocopia == true){ Fotocopia = 'on'; }
            Factura = '';
            if($scope.Factura == true){ Factura = 'on'; }
            Transferencia = '';
            if($scope.Transferencia == true){ Transferencia = 'on'; }
            pagoFactura = '';
            if($scope.pagoFactura == true){ pagoFactura = 'on'; }
            $scope.res = Fotocopia;
            Saldo = $scope.Saldo;
            if($scope.Saldo > 0){
                Saldo = $scope.Saldo - $scope.montoAbonar;
            }
            $scope.res = 'Error';
            $http.post('grabarSeguimiento.php', {
                                                    nSolicitud:$scope.nSolicitud, 
                                                    Fotocopia:Fotocopia,
                                                    fechaFotocopia:new Date($scope.fechaFotocopia),
                                                    Factura:Factura,
                                                    fechaFactura:new Date($scope.fechaFactura),
                                                    nFactura:$scope.nFactura,
                                                    Neto:$scope.Neto,
                                                    Iva:$scope.Iva,
                                                    Bruto:$scope.Bruto,
                                                    valorUF:$scope.valorUF,
                                                    valorUS:$scope.valorUS,
                                                    fechaTransaccion:new Date($scope.fechaTransaccion),
                                                    montoAbonar:$scope.montoAbonar,
                                                    pagoFactura:pagoFactura,
                                                    fechaPago:new Date($scope.fechaPago),
                                                    Transferencia:Transferencia, 
                                                    fechaTransferencia:new Date($scope.fechaTransferencia),
                                                    formaPago:$scope.formaPago,
                                                    Saldo:Saldo
                        })
            .then(function (response) {
                $scope.res = 'OK';
                $scope.bRefClase    = "btn btn-warning";
                $scope.bGuardaRef   = "Actualizado";
                $scope.montoAbonar  = 0;
                $scope.lecturaDatos();
                $scope.editarSeguimientoOld($scope.nSolicitud);
            });

/*
                                                    pagoFactura:$scope.pagoFactura,
                                                    fechaPago:$scope.fechaPago,
                                                    Transferencia:$scope.Transferencia,
*/

        }

        $scope.abonoSaldo = function(){ 
            $scope.Saldo = $scope.Saldo - $scope.montoAbonar;
        }
        $scope.pagaTodo = function(){
            $scope.montoAbonar = $scope.Saldo;
        }
    });

