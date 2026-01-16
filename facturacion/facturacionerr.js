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

        $scope.editarSeguimientoOld = function(nSol){
            $scope.Fotocopia        = false;
            $scope.Factura          = false;
            $scope.pagoFactura      = false;
            $scope.Transferencia    = false;
            $http.post("leerSeguimientoSolicitud.php",{nSolicitud:nSol})
            .then(function(response){  
                $scope.nSolicitud = nSol;
                //$scope.nSolicitud = response.data.nSolicitud;
                $scope.Cliente          = response.data.Cliente;

                if(response.data.Fotocopia == 'on'){
                    $scope.Fotocopia    = true;
                }
                $scope.fechaFotocopia   = new Date(response.data.fechaFotocopia.replace(/-/g, '\/').replace(/T.+/, ''));
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
                $scope.Saldo            = response.data.Saldo;
            });
        }

        $scope.actSeguimiento = function(){
            if($scope.Fotocopia == true){
               $scope.fechaFotocopia = new Date();
            }else{
               $scope.fechaFotocopia = "";
            }
            if($scope.Factura == true){
                $scope.fechaFactura = new Date();
            }else{
                $scope.fechaFactura = "";
            }
            if($scope.pagoFactura == true){
                $scope.fechaPago = new Date();
            }else{
                $scope.fechaPago = "";
            }
        }

        $scope.modiTotales = function(vUF){
            $scope.Neto = (vUF * $scope.netoUF);
            $scope.Iva = ($scope.Neto * 0.19);
            $scope.Bruto = ($scope.Neto + $scope.Iva);
        }
        $scope.modiTotalesUS = function(vUS){
            $scope.Neto = (vUS * $scope.NetoUS);
            $scope.Iva = ($scope.Neto * 0.19);
            $scope.Bruto = ($scope.Neto + $scope.Iva);
        }

    });

