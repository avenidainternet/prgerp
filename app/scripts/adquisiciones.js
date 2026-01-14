    var app = angular.module('myApp', []); 
    app.run(function($rootScope){
        $rootScope.fechaRegistro        = new Date();
        $rootScope.tablaDependencias    = true;
        $rootScope.tTablaDetalle        = true;
        $rootScope.regDependencia       = false;
        $rootScope.regProveedor         = false;
        $rootScope.regUnidadMedida      = false;
        $rootScope.registroDatos        = false;
        $rootScope.antiguoProveedor     = true;
        $rootScope.nuevoProveedor       = false;
        $rootScope.nItem                = '';
        $rootScope.Item                = '';

    });
    
    app.controller('CtrlAdquisiciones', function($scope, $http) {

        $scope.tCertificados = true;

        $http.get("leerTablaCertificados.php")  
        .then(function(response){  
            $scope.Certificados = response.data.records; 
        })

        $scope.editarInventario = function(nArticulo){
            $scope.tTablaDetalle        = false;
            $scope.registroDatos        = true;
            $scope.proceso              = "Mantención";
            
            $http.post('../../app/controladores/dataControl.php',{
                nArticulo   : nArticulo,
                accion      : "editarInventario"
            })
            .then(function (response) {
                $scope.nArticulo        = response.data.nArticulo;
                $scope.nItem            = response.data.nItem;
                $scope.idDependencia    = response.data.idDependencia;
                $scope.Articulo         = response.data.Articulo;
                $scope.Serial           = response.data.Serial;
                $scope.idUnidad         = response.data.idUnidad;
                $scope.cantidadXUnidad  = response.data.cantidadXUnidad;
                $scope.nUnidades        = response.data.nUnidades;
                $scope.Stock            = response.data.Stock;
                $scope.Salida           = response.data.Salida;
                $scope.stockActual      = response.data.stockActual;
                $scope.stockCritico     = response.data.stockCritico;   
        
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
            
        }

        $scope.editarProveedor = function(RutProv){
            $scope.tTablaDetalle        = false;
            $scope.registroDatos        = true;
            $scope.proceso              = "Mantención";
            
            $http.post('../../app/controladores/dataControl.php',{
                RutProv     : RutProv,
                accion      : "editarProveedor"
            })
            .then(function (response) {
                $scope.RutProv          = response.data.RutProv;
                $scope.Proveedor        = response.data.Proveedor;
                $scope.productoServicio = response.data.productoServicio;
                $scope.Direccion        = response.data.Direccion;
                $scope.Contacto         = response.data.Contacto;
                $scope.Telefono         = response.data.Telefono;
                $scope.Celular          = response.data.Celular;
                $scope.Email            = response.data.Email;
                $scope.TpCta            = response.data.TpCta;
                $scope.NumCta           = response.data.NumCta;
                $scope.Banco            = response.data.Banco;
                $scope.tpDocumentoEmite = response.data.tpDocumentoEmite;
        
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
            
        }

        $scope.editarDependencia = function(nDependencia){
            $scope.tablaDependencias    = false;
            $scope.regDependencia       = true;
            $http.post('../../app/controladores/dataControl.php',{
                nDependencia    : nDependencia,
                accion  :  "editarDependencia"
            })
            .then(function (response) {
                $scope.nDependencia     = response.data.nDependencia;
                $scope.Dependencia      = response.data.Dependencia;
                $scope.usrResponsable   = response.data.usrResponsable;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.editarUnidadMedida = function(nUnidad){
            $scope.tTablaDetalle        = false;
            $scope.registroDatos        = true;
            $http.post('../../app/controladores/dataControl.php',{
                nUnidad    : nUnidad,
                accion  :  "editarUnidadMedida"
            })
            .then(function (response) {
                $scope.nUnidad      = response.data.nUnidad;
                $scope.idUnidad     = response.data.idUnidad;
                $scope.Unidad       = response.data.Unidad;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.editarClasificacion = function(nItem){
            $scope.tTablaDetalle        = false;
            $scope.registroDatos        = true;
            $http.post('../../app/controladores/dataControl.php',{
                nItem    : nItem,
                accion  :  "editarClasificacion"
            })
            .then(function (response) {
                $scope.nItem        = response.data.nItem;
                $scope.Items        = response.data.Items;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.grabarProveedor = function(){
            $http.post('../../app/controladores/dataControl.php',{
                RutProv         : $scope.RutProv,
                Proveedor       : $scope.Proveedor,
                Direccion       : $scope.Direccion,
                Contacto        : $scope.Contacto,
                Telefono        : $scope.Telefono,
                Celular         : $scope.Celular,
                Email           : $scope.Email,
                TpCta           : $scope.TpCta,
                NumCta          : $scope.NumCta,
                Banco           : $scope.Banco,
                productoServicio: $scope.productoServicio,
                tpDocumentoEmite: $scope.tpDocumentoEmite,
                accion          : "grabarProveedor"
            })

            .then(function (response) {
                $scope.tTablaDetalle        = true;
                $scope.registroDatos        = false;
    
                $scope.loadProveedores(); 
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.grabarArticulo = function(){
            $http.post('../../app/controladores/dataControl.php',{
                nArticulo       : $scope.nArticulo,
                Articulo        : $scope.Articulo,
                Serial          : $scope.Serial,
                nItem           : $scope.nItem,
                idDependencia   : $scope.idDependencia,
                idUnidad        : $scope.idUnidad,
                cantidadXUnidad : $scope.cantidadXUnidad,
                nUnidades       : $scope.nUnidades,
                stockCritico    : $scope.stockCritico,
                accion          :  "grabarArticulo"
            })

            .then(function (response) {
                $scope.tTablaDetalle    = true;
                $scope.registroDatos    = false;
                $scope.loadUnidadMedida();
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.grabarUnidadMedida = function(){
            $http.post('../../app/controladores/dataControl.php',{
                nUnidad         : $scope.nUnidad,
                idUnidad        : $scope.idUnidad,
                Unidad          : $scope.Unidad,
                accion          :  "grabarUnidadMedida"
            })

            .then(function (response) {
                $scope.tTablaDetalle    = true;
                $scope.registroDatos    = false;
                $scope.loadUnidadMedida();
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.grabarDependencia = function(){
            $http.post('../../app/controladores/dataControl.php',{
                nDependencia    : $scope.nDependencia,
                Dependencia     : $scope.Dependencia,
                usrResponsable  : $scope.usrResponsable,
                accion          :  "grabarDependencia"
            })

            .then(function (response) {
                alert('Se grabo correctamente...');
                $scope.tablaDependencias    = true;
                $scope.regDependencia       = false;
                $scope.cargarDependencias();
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.grabarClasificacion = function(){
            $http.post('../../app/controladores/dataControl.php',{
                nItem           : $scope.nItem,
                Items           : $scope.Items,
                accion          : "grabarClasificacion"
            })

            .then(function (response) {
                $scope.tablaDependencias    = true;
                $scope.tTablaDetalle        = true;
                $scope.registroDatos       = false;
                $scope.loadClasificacion();
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });

        }

        $scope.agregarArticulo = function(){
            $scope.tablaDependencias    = false;
            $scope.tTablaDetalle        = false;
            $scope.regDependencia       = true;
            $scope.registroDatos        = true;
            $scope.nUnidad              = '';
            $scope.idUnidad             = '';
            $scope.Unidad               = '';

            //$scope.loadClasificacion();

            $http.post('../../app/controladores/dataControl.php',{
                accion  :  "agregarArticulo"
            })
            .then(function (response) {
                $scope.nArticulo   = response.data.nArticulo;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
    

        }

        $scope.agregarUnidadMedida = function(){
            $scope.tablaDependencias    = false;
            $scope.tTablaDetalle        = false;
            $scope.regDependencia       = true;
            $scope.registroDatos        = true;
            $scope.nUnidad              = '';
            $scope.idUnidad             = '';
            $scope.Unidad               = '';
            $http.post('../../app/controladores/dataControl.php',{
                accion  :  "agregarUnidadMedida"
            })
            .then(function (response) {
                $scope.nUnidad   = response.data.nUnidad;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
    

        }

        $scope.agregarClasificacion = function(){
            $scope.tablaDependencias    = false;
            $scope.tTablaDetalle        = false;
            $scope.regDependencia       = true;
            $scope.registroDatos        = true;

            $scope.nItem                = '';
            $scope.Items                = '';

            $http.post('../../app/controladores/dataControl.php',{
                accion  :  "agregarClasificacion"
            })
            .then(function (response) {
                $scope.nItem   = response.data.nItem;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
    

        }

        $scope.agregarProveedor = function(){
            $scope.proceso              = 'Agregar';

            $scope.RutProv              = '';
            $scope.Direccion            = '';
            $scope.Proveedor            = '';
            $scope.productoServicio     = '';
            $scope.tpDocumentoEmite     = '';
            $scope.Telefono             = '';
            $scope.Celular              = '';
            $scope.Contacto             = '';
            $scope.Email                = '';
            $scope.Banco                = '';
            $scope.TpCta                = '';
            $scope.NumCta               = '';

            $scope.tTablaDetalle        = false;
            $scope.registroDatos        = true;
            $scope.antiguoProveedor     = false;
            $scope.nuevoProveedor       = true;




        }

        $scope.agregarDependencia = function(){
            $scope.tablaDependencias    = false;
            $scope.regDependencia       = true;
            $scope.nDependencia         = '';
            $scope.Dependencia          = '';
            $scope.usrResponsable       = '';

            $http.post('../../app/controladores/dataControl.php',{
                accion  :  "agregarDependencia"
            })
            .then(function (response) {
                $scope.nDependencia   = response.data.nDependencia;
            }, function(error) {
                $scope.errors = error.message;
                alert('Error...'+$scope.errors);
            });
    

        }

        $scope.loadUnidadMedida = function(){
            
            $scope.cargandoTabla = "Cargando Unidaded de Medida...";
            $http.post("../../app/controladores/dataControl.php",{
                accion  : 'loadUnidadMedida'
            })  
            .then(function(response){  
                $scope.dataUnidadMedida = response.data.records;
                $scope.loading = false;
            });

        }

        $scope.loadInventario = function(){
            //alert('Cargar Inventario...');
            //$scope.loadClasificacion();
            $scope.cargandoTabla = "Cargando Inventario...";
            $http.post("../../app/controladores/dataControl.php",{
                accion  : 'loadInventario'
            })  
            .then(function(response){  
                $scope.dataInventario = response.data.records;
                //alert($scope.dataInventario.length);
                if($scope.dataInventario.length == 0){
                    //$scope.agregarArticulo();
                }
                $scope.loading = false;
            });

        }



        $scope.loadClasificacion = function(){
            //alert('Cargar Clasificacion...');
            
            $scope.cargandoTabla = "Cargando Clasificaciones...";
            $http.post("../../app/controladores/dataControl.php",{
                accion  : 'loadClasificacion'
            })  
            .then(function(response){  
                $scope.dataItemsInventario = response.data.records;
                //alert($scope.dataItemsInventario.length);
                if($scope.dataItemsInventario.length == 0){
                    $scope.agregarClasificacion();
                }

                $scope.loading = false;
            });

        }


        $scope.loadProveedores = function(){
            //alert('Cargar Provv...');
            
            $scope.cargandoTabla = "Cargando Proveedores...";
            $http.post("../../app/controladores/dataControl.php",{
                accion  : 'loadProveedores'
            })  
            .then(function(response){  
                $scope.dataProveedores = response.data.records;
                $scope.loading = false;
            });

        }

        $scope.cargarDependencias = function(){
            $scope.cargandoTabla = "Cargando Dependencias...";
            $http.post("../../app/controladores/dataControl.php",{
                accion  : 'cargarDependencias'
            })  
            .then(function(response){  
                $scope.dataDependencias = response.data.records;
                $scope.loading = false;
            });
        }
        
        $scope.loadContactos = function(){
            $scope.bCliente = '';
            if($scope.bContactos != ''){
                $scope.tClientes = false;
                $scope.tContactos = true;
            }else{
                $scope.tClientes = true;
                $scope.tContactos = false;
            }
        }

        $scope.verContactos = function(){
            $scope.bCliente     = '';
            $scope.bContactos   = '';
            $scope.tClientes = false;
            $scope.tContactos = true;
        }

        $scope.verClientes = function(){
            $scope.bCliente     = '';
            $scope.bContactos   = '';
            $scope.tClientes = true;
            $scope.tContactos = false;
        }

        $scope.borrarContacto = function(rCli, nCon){
            alert("Eliminar"+rCli+' '+nCon);
            $http.post('eliminarContacto.php',{
                                            RutCli:rCli, 
                                            nContacto:nCon 
                                        })
            .then(function (res) {
                alert("Ok");
            });
            $scope.bContactos = "";
            $http.get("leerTablaContactos.php")  
            .then(function(response){  
                $scope.Contactos = response.data;
            })
        }

        $scope.verColorLineaServicios = function(stockCritico, stockActual){
            //alert('Entra '+stockCritico);
            retorno = {'default-color': true};
            if(stockCritico < stockActual){
                retorno = {'default-color': true};
            }
            if(stockCritico >= stockActual){
                retorno = {'rojo-class': true};
            }
            return retorno;
        }


    });
