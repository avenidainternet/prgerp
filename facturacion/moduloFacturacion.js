    var app = angular.module('myApp', []);
    app.run(function($rootScope){
        $rootScope.Estado = "P";
        $rootScope.enProceso = false;
        $rootScope.tablasAM = false;
        $rootScope.swCotizaciones = true;
        $rootScope.btnMuestraCAM = false;
        $rootScope.btnOcultaCAM = true;
        $rootScope.progreso = 0;
        $rootScope.usr = '';

        $rootScope.fechaSolicitud        = ''; 
        $rootScope.Atencion              = ''; 
        $rootScope.correosFactura        = ''; 
        $rootScope.Observa               = ''; 
        $rootScope.RutCli                = ''; 
        $rootScope.nOrden                = ''; 
        $rootScope.nSolicitud            = 0; 
        $rootScope.CAM                   = 0; 

        $rootScope.IdProyecto            = ''; 
        $rootScope.vencimientoSolicitud  = ''; 
        $rootScope.Exenta                = ''; 
        $rootScope.Redondear             = ''; 
        $rootScope.tipoValor             = ''; 
        $rootScope.valorUF               = ''; 
        $rootScope.fechaUF               = ''; 
        $rootScope.enviarFactura         = ''; 
        $rootScope.Cliente               = ''; 
        $rootScope.Giro                  = ''; 
        $rootScope.Departamento          = ''; 
        $rootScope.Direccion             = '';
        $rootScope.Telefono              = '';
        $rootScope.Email                 = '';
        $rootScope.cotizacionesCAM       = '';
        $rootScope.informesAM            = '';



    });

    app.controller('TodoCtrl', function($scope, $http) {
	    $scope.Solicitud = $scope.nSolicitud;
        $scope.RutCli    = $scope.RutCli;
        $scope.nOC       = $scope.nOC;



        $scope.verDetalle= false;

        $scope.moneda = 'P';
        $scope.monedas= [
            {
                codMoneda:"P",
                descripcion:"Peso" 
            },{
                codMoneda:"U",
                descripcion:"UF"
            },{
                codMoneda:"D",
                descripcion:"Dolar"
            }
            ];

        $scope.enviarFactura = 1;
        $scope.Exenta = false;
        $scope.Redondear = false;
        $scope.tituloExenta = 'No Exenta'; 
        $scope.estadoExenta = function(){
            if($scope.Exenta == true){
                $scope.tituloExenta = 'Factura Exenta';
            }
            if($scope.Exenta == false){
                $scope.tituloExenta = 'No Exenta';
            }
        }

        $scope.loadDatos = function(CAM, nSolicitud, nOrden){
            if(nSolicitud == 0){
                if(nOrden != ''){
                    $http.post('rescataSolicitud.php',{
                        nOrden  : nOrden,
                        CAM     : CAM,
                        accion  : "New"
                    })
                    .then(function (response) {
                        $scope.nSolicitud   = response.data.nSolicitud;
                        $scope.RutCli       = response.data.RutCli;
                        //alert('Nueva Solicitud...'+CAM+' '+$scope.nSolicitud+' '+nOrden+' '+$scope.RutCli);
                        detalleFacturacion($scope.RutCli, $scope.nSolicitud);
                        window.location.href = 'formSolicitaFactura.php?nSolicitud='+$scope.nSolicitud+'&RutCli='+$scope.RutCli;

                    }, function(error) {
                        alert(error.message);
                    });
                }else{
                    $http.post('asignarFormularioSol.php',{nSolicitud:$scope.nSolicitud})
                    .then(function (response) {
                        $scope.nSolicitud = response.data.nSolicitud
                        alert(response.data.nSolicitud)
                        $scope.verDetalle= true;
                        $scope.Fono = $scope.Telefono;
                        $http.post('guardardatosfactura.php',{
                                                        nSolicitud:             $scope.nSolicitud, 
                                                        RutCli:                 $scope.RutCli,
                                                        fechaSolicitud:         $scope.fechaSolicitud,
                                                        nOrden:                 $scope.nOrden, 
                                                        CAM:                    CAM, 
                                                        accion:                 "SolNew"
                                                    })
                        
                        .then(function (res) {
                            detalleFacturacion($scope.RutCli, $scope.nSolicitud);
                            window.location.href = 'formSolicitaFactura.php?nSolicitud='+$scope.nSolicitud+'&RutCli='+$scope.RutCli;
    
                        }, function(error) {
                            alert(error.message);
                        });
                        
                    });

                }
                
    
            }


        }

        $scope.copiaCAM = function(){
            // alert($scope.nSolicitud);
            $http.post('rescataSolicitud.php',{ 
                nSolicitud  : $scope.nSolicitud,
                accion      : "copiaCAM"
            })
            .then(function (response) {
                $scope.CAM           = response.data.CAM;
                $scope.RAM           = response.data.RAM;
                // alert($scope.CAM);
                window.location.href = "../procesosangular/formularios/iCAMArchivaFacturacion.php?CAM="+$scope.CAM+"&Rev=0&Cta=0&accion=Reimprime";
            }, function(error) {
                $scope.resGuarda = 'No';
                $scope.errors = error.message;
                alert('Error... '+error.message);
            });
            
        }
        $scope.activadesactivaValor = function(){
            //$scope.AM = $scope.tipoValor;
            if($scope.tipoValor == 'P'){
                $scope.valUF = false;
            }
            if($scope.tipoValor == 'U'){
                $scope.valUF = true;
            }
            if($scope.tipoValor == 'D'){
                $scope.valUF = false;
            }
        }

        $scope.buscarCliente = function(r){ 
            $http.post('buscaCliente.php',{RutCli:$scope.RutCli})
            .then(function (response) {
                $scope.RutCli           = response.data.RutCli;
                $scope.Cliente          = response.data.Cliente;
                $scope.Giro             = response.data.Giro;
                $scope.Direccion        = response.data.Direccion;
                $scope.Telefono         = response.data.Telefono;
                $scope.correosFactura   = response.data.correosFactura;
                pegasenAM($scope.RutCli, $scope.nSolicitud);
               
            });
        }
        $scope.loadClientes = function(){
            $http.get("leerTablaClientes.php")  
            .then(function(response){  
                $scope.tabClientes = response.data;
            })
        }  
        $scope.cargarCliente = function(){
            $scope.RutCli = $scope.tabCliente;
            $http.post('buscaCliente.php',{RutCli:$scope.tabCliente})
            .then(function (response) {
                $scope.RutCli           = response.data.RutCli;
                $scope.Cliente          = response.data.Cliente;
                $scope.Giro             = response.data.Giro;
                $scope.Direccion        = response.data.Direccion;
                $scope.correosFactura   = response.data.correosFactura;
                $scope.Telefono         = response.data.Telefono;
                llenarTablaContactos($scope.RutCli);
            });
        }

       function llenarTablaContactos(r){
            $scope.resCon = $scope.nSolicitud;
            $http.post("leerPosiblesContactos.php",{RutCli:r, nSolicitud:$scope.nSolicitud})  
            .then(function(response){  
                $scope.tabContactos = response.data; 
            })  
       }

       $scope.loadContactos = function(){ 
            $scope.resCon = $scope.nSolicitud;
            $http.post("leerPosiblesContactos.php",{RutCli:$scope.RutCli, nSolicitud:$scope.nSolicitud})  
            .then(function(response){  
                $scope.tabContactos = response.data; 
            })  
        }  
       $scope.loadContactosInc = function(){ 
            $http.post("leerTablaContactosInc.php",{RutCli:$scope.RutCli, nSolicitud:$scope.nSolicitud})  
            .then(function(response){  
                $scope.tabContactosInc = response.data; 
            })  
        }  
        $scope.loadSolicitud = function(){ 
            $scope.nSolicitud = $scope.nSol;
            //alert($scope.nOrden);
            $http.post('buscaSolicitud.php',{nSolicitud:$scope.nSolicitud, $RutCli:$scope.RutCli})
            .then(function (response) {
                $scope.IdProyecto           = response.data.IdProyecto;
                $scope.Proyecto             = response.data.IdProyecto;
                if(response.data.nOrden.length > 0){
                    $scope.nOrden               = response.data.nOrden;
                }
                $scope.tipoValor            = response.data.tipoValor;
                $scope.valorUF              = response.data.valorUF;
                $scope.fechaUF              = new Date(response.data.fechaUF.replace(/-/g, '\/').replace(/T.+/, ''));
                $scope.netoUF               = response.data.netoUF;
                $scope.ivaUF                = response.data.ivaUF;
                $scope.brutoUF              = response.data.brutoUF;
                $scope.Neto                 = response.data.Neto;
                $scope.Iva                  = response.data.Iva;
                $scope.Bruto                = response.data.Bruto;
                $scope.fechaSolicitud       = new Date(response.data.fechaSolicitud.replace(/-/g, '\/').replace(/T.+/, ''));
                $scope.enviarFactura        = response.data.enviarFactura;
                $scope.vencimientoSolicitud = response.data.vencimientoSolicitud;
                $scope.Atencion             = response.data.Atencion;
                $scope.correosFactura       = response.data.correosFactura;

                $scope.informesAM           = response.data.informesAM;
                $scope.cotizacionesCAM      = response.data.cotizacionesCAM;
                $scope.Observa              = response.data.Observa;

                //$scope.Exenta                 = response.data.Exenta;
                if(response.data.Exenta == 'on'){
                    $scope.Exenta = true;
                    $scope.tituloExenta = 'Factura Exenta';
                 }else{
                    $scope.Exenta = false
                    $scope.tituloExenta = 'No Exenta';
                 }
                 if(response.data.tipoValor == 'U'){
                    $scope.valUF = true;
                 }
                 if(response.data.tipoValor == 'P'){
                    $scope.valUF = false;
                 }
                 $scope.verDetalle= true;
                if(response.data.Redondear == 'on'){
                    $scope.Redondear = true;
                 }else{
                    $scope.Redondear = false
                 }
            });

        }
       $scope.loadProyectos = function(){  
            $http.get("leerTablaProyectos.php")   
            .then(function(response){  
                $scope.tabProyectos = response.data; 
            })  
        }  

        $scope.borrarDoc = function(d, nSol){
            $http.post("borrarDocumento.php",{
                documento: d,
                nSolicitud: nSol
            })
            .then(function(response){  
                alert('Borrado el Documento...'+d); 
            })  

            window.location.href = 'mDocumentos.php?nSolicitud='+$scope.nSolicitud+'&RutCli='+$scope.RutCli;
        }

        $scope.cargarDatos = function(){
            alert($scope.nSolicitud);
        }

        $scope.grabarSolicitudNew = function(sol){
            alert('Entra...'+$sol);
        }
        
        function grabarSolicitud(sol){
            //$scope.res = $scope.tipoValor;

            // alert($scope.RutCli);            
            $scope.verDetalle= true;
            $scope.Fono = $scope.Telefono;
            $http.post('guardardatosfactura.php',{
                                            nSolicitud:             sol, 
                                            RutCli:                 $scope.RutCli,
                                            fechaSolicitud:         $scope.fechaSolicitud,
                                            Atencion:               $scope.Atencion, 
                                            correosFactura:         $scope.correosFactura, 
                                            Observa:                $scope.Observa, 
                                            nOrden:                 $scope.nOrden, 
                                            IdProyecto:             $scope.IdProyecto, 
                                            vencimientoSolicitud:   $scope.vencimientoSolicitud, 
                                            Exenta:                 $Exenta, 
                                            Redondear:              $Redondear, 
                                            tipoValor:              $scope.tipoValor, 
                                            valorUF:                $scope.valorUF, 
                                            fechaUF:                $scope.fechaUF, 
                                            enviarFactura:          $scope.enviarFactura, 
                                            Cliente:                $scope.Cliente, 
                                            Giro:                   $scope.Giro, 
                                            Departamento:           $scope.Departamento, 
                                            Direccion:              $scope.Direccion,
                                            Telefono:               $scope.Telefono,
                                            Email:                  $scope.Email,
                                            cotizacionesCAM:        $scope.cotizacionesCAM,
                                            informesAM:             $scope.informesAM,
                                            accion:                 "SolOld"
                                        })
            .then(function (res) {
                alert("Registro grabado exitosamente...");
            }, function(error) {
                alert(error.message);
            });
            //$scope.AM = $scope.nSolicitud;
        }
        function asignarSolicitud(){
            $scope.nSolicitud = 0;
            $http.post('asignarFormularioSol.php',{nSolicitud:$scope.nSolicitud})
            .then(function (response) {
                $scope.nSolicitud = response.data.nSolicitud;
                grabarSolicitud($scope.nSolicitud);
            });
        }

        $scope.guardardatos = function(){
            $scope.msgGraba = true;
            $Exenta = 'off';
            if($scope.Exenta == true){
                $Exenta = 'on';
            }
            $Redondear = 'off';
            if($scope.Redondear == true){
                $Redondear = 'on';
            }
            if($scope.nSolicitud == ''){
                asignarSolicitud();
                nSol = $scope.nSolicitud;
                //$scope.ns = $scope.nSolicitud;
                //grabarSolicitud($scope.nSolicitud);
            }else{
                grabarSolicitud($scope.nSolicitud);
            }
            $scope.AM = 'Guardado...'+$scope.tipoValor;
            detalleFacturacion($scope.RutCli, $scope.nSolicitud)

        }


        // Muestra AM Disponibles
        function pegasenAM(rut, sol){
            //$scope.AM = 'AM '+sol+' '+rut;
            $http.post('mAMsDisponibles.php',{RutCli:rut, nSolicitud:sol  }) 
            .then(function(response){  
                $scope.informes = response.data; 
            }) 
            pegasFacturadasAM(rut, sol)
            detalleFacturacion(rut, sol)
        }
        // Muestra AM a Facturar
        function pegasFacturadasAM(rut, sol){
            //$scope.AM = 'AM '+sol+' '+rut;
            $http.post('mAMsFacturadas.php',{RutCli:rut, nSolicitud:sol  })
            .then(function(response){  
                $scope.informesAfacturar = response.data; 
            }) 
        }
        function detalleFacturacion(rut, sol){
            //$scope.AM = 'AM '+sol+' '+rut;
            $http.post('detFacturacion.php',{RutCli:rut, nSolicitud:sol  })
            .then(function(response){  
                $scope.dFacturacion = response.data; 
            }) 
        }

        $scope.quitarContacto = function(){
            //$scope.resCon = 'Agregando a '+ $scope.tabContactosFac;
            $http.post('quitarOldContactooo.php',{
                                            nSolicitud:$scope.nSolicitud, 
                                            RutCli:$scope.RutCli, 
                                            nContacto:$scope.tabContactosFac
                                        })
            .then(function (res) {
                leerDatosSolicitud();
            });
        }
        $scope.agregarContacto = function(){
            //$scope.resCon = 'Agregando a '+ $scope.tabContactosCli;
            $http.post('agregarNewContacto.php',{
                                            nSolicitud:$scope.nSolicitud, 
                                            RutCli:$scope.RutCli, 
                                            nContacto:$scope.tabContactosCli
                                        })
            .then(function (res) {
                leerDatosSolicitud();
            });
        }

        $scope.agregaPega = function(cam, nSol, Rut){
            //$scope.AM = cam+' '+nSol+' '+Rut;
            //alert(cam);
            $http.post('agregarPega.php',{
                                            nSolicitud:nSol, 
                                            RutCli:Rut, 
                                            CAM:cam
                                        })
            .then(function (res) {
                pegasenAM(Rut, nSol);
                leerDatosSolicitud();
            });
        }
        $scope.quitarPega = function(cam, nSol, Rut){
            //$scope.AM = cam+' '+nSol+' '+Rut;
            $http.post('quitaPega.php',{
                                            nSolicitud:nSol, 
                                            RutCli:Rut, 
                                            CAM:cam
                                        })
            .then(function (res) {
                pegasenAM(Rut, nSol);
                leerDatosSolicitud();
            });
        }

        $scope.agregaLinea = function(){
            $scope.Li = $scope.Cantidad+' '+$scope.Unitario+' '+$scope.Especificacion;
            $http.post('agregaDetFacturacion.php',{
                                            nSolicitud:$scope.nSolicitud, 
                                            Cantidad:$scope.Cantidad,
                                            Especificacion:$scope.Especificacion,
                                            valorUnitario:$scope.Unitario,
                                            tipoValor:$scope.tipoValor
                                        })
            .then(function (res) {
                leerDatosSolicitud();
                detalleFacturacion($scope.RutCli, $scope.nSolicitud);
                $scope.Unitario = '';
                $scope.Cantidad = '';
                $scope.Especificacion = '';
            });
        }
        $scope.recalcular = function(nSol, Rut, nIt, nCan, eEsp, vUni, vUniUF, vUniUS){
            $scope.re = nSol;
            $http.post('actDetFacturacion.php',{
                                            nSolicitud:nSol, 
                                            nItems:nIt, 
                                            Cantidad:nCan,
                                            Especificacion:eEsp,
                                            valorUnitario:vUni,
                                            valorUnitarioUF:vUniUF,
                                            valorUnitarioUS:vUniUS
                                        })
            .then(function (res) {
                leerDatosSolicitud();
                detalleFacturacion(Rut, nSol);
            });
        }
        $scope.quitarItems = function(nSol, Rut, nIt, nCan, eEsp, vUni, vUniUF){
            $scope.re = nSol;
            $http.post('quitaDetFacturacion.php',{
                                            nSolicitud:nSol, 
                                            nItems:nIt, 
                                            Cantidad:nCan,
                                            Especificacion:eEsp,
                                            valorUnitario:vUni,
                                            valorUnitarioUF:vUniUF
                                        })
            .then(function (res) {
                leerDatosSolicitud();
                detalleFacturacion(Rut, nSol);
            });
        }
        function leerDatosSolicitud (){
            $http.post('buscaSolicitud.php',{nSolicitud:$scope.nSolicitud})
            .then(function (response) {
                $scope.Atencion             = response.data.Atencion;
                $scope.correosFactura       = response.data.correosFactura;
                $scope.informesAM           = response.data.informesAM;
                $scope.cotizacionesCAM      = response.data.cotizacionesCAM;
                $scope.netoUF               = response.data.netoUF;
                $scope.ivaUF                = response.data.ivaUF;
                $scope.brutoUF              = response.data.brutoUF;
                $scope.NetoUS               = response.data.NetoUS;
                $scope.IvaUS                = response.data.IvaUS;
                $scope.BrutoUS              = response.data.BrutoUS;
                $scope.Neto                 = response.data.Neto;
                $scope.Iva                  = response.data.Iva;
                $scope.Bruto                = response.data.Bruto;
            });

        }

        $scope.loadRegistro = function(nSolicitud){
            $scope.nSolicitud = nSolicitud;
            $http.post("controlRegistros.php", {nSolicitud:nSolicitud})  
            .then(function(response){  
                $scope.Cliente          = response.data.Cliente;
                $scope.HES              = response.data.HES;
                $scope.informesAM       = response.data.informesAM;
                $scope.cotizacionesCAM  = response.data.cotizacionesCAM;
                if($scope.HES != '') {
                    $scope.muestraHES = true;
                }
            }, function(error) {
                $scope.errors = error.message;
            });

        }
    });

