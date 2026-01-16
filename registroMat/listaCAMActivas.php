<table class="table table-dark table-hover" style="margin-top: 5px;" ng-show="tablaCAM">
		<thead>
			<tr>
				<th>&nbsp; 		</th>
				<th>CAM			</th>
				<th>Fecha		</th>
				<th>Clientes	</th>
				<th>Total		</th>
				<th>Validez		</th>
				<th>Est. 		</th>
				<th>Acciones	</th>
			</tr>
		</thead>
		<tbody>

			<tr ng-repeat="Cam in CotizacionesCAM | filter: filtroClientes" 
				ng-class="verColorLinea(Cam.Estado, Cam.RAM, Cam.BrutoUF, Cam.nDias, Cam.rCot, Cam.fechaAceptacion, Cam.proxRecordatorio, Cam.colorCam)">

				<td>
					<div ng-if="Cam.correoAutomatico == 'on'">
						<img style="padding:5px;" src="../imagenes/siEnviado.png" align="left" width="40" title="Cotización enviado en correo automatico">
					</div>
					<div ng-if="Cam.nFactPend > 0"> 
						<br>
						<img src="../imagenes/gener_32.png" title="Precaución Cliente con {{Cam.nFactPend}} Facturas Pendientes" align="left" width="32"> 
						<span class="badge badge-danger" title="Cliente con {{Cam.nFactPend}} Facturas Pendientes">{{Cam.nFactPend}}</span>
					</div>
					<div ng-if="Cam.tpEnsayo == 2">
						<h5 title="Análisis de Falla"><span class="badge badge-secondary">AF</span></h5>
					</div>
					<div ng-if="Cam.OFE == 'on'">
						<a class="btn btn-warning" role="button" href="ofe/index.php?OFE={{Cam.CAM}}&accion=OFE" title="Editar Oferta Econóica">OFE</a>
					</div>
					<div ng-if="Cam.Clasificacion > 0">
						<br>
						<div ng-if="Cam.Clasificacion == 1">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Cam.Clasificacion == 2">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
						<div ng-if="Cam.Clasificacion == 3">
							<img src="../imagenes/Estrella_Azul.png" align="left" width="20">
						</div>
					</div>
				</td>
				<td>
					C{{Cam.CAM}}<br>
					<div ng-if="Cam.RAM > 0">
						R{{Cam.RAM}} 
					</div>
					<div ng-if="Cam.Rev > 0">
						Rev. 0{{Cam.Rev}} 
					</div>
					<div ng-if="Cam.fechaAceptacion != '0000-00-00'">
						<span class="badge badge-warning">Aceptada</span> 
					</div>
					<div ng-if="Cam.sDeuda > 0">
						<img class="p-2" src="../imagenes/bola_amarilla.png">
						<h5><span class="badge badge-warning" title="Moroso">{{Cam.sDeuda | currency:"$ ":0}}</span></h5>
					</div>

				</td>
				<td>
					{{Cam.fechaCotizacion | date:'dd/MM'}}<br>
					{{Cam.usrCotizador}}
				</td>
				<td>{{Cam.Cliente}}</td>
				<td>
					<div ng-if="Cam.Bruto > 0">
						{{Cam.Bruto | currency:"$ ":0}}
					</div>
					<div ng-if="Cam.BrutoUF > 0">
						{{Cam.BrutoUF | currency:"UF "}}
					</div>

				</td>
				<td>
					<!-- {{Cam.fechaEstimadaTermino | date:'dd/MM'}} -->
					{{Cam.fechaxVencer | date:'dd/MM'}}<br>
					{{Cam.fechaTermino | date:'dd/MM'}}<br>
					<span class="badge badge-pill badge-danger" ng-if="Cam.nDias < 0">
						<h6>{{Cam.nDias}}</h6>
					</span>
					<span class="badge badge-pill badge-primary" ng-if="Cam.nDias > 0">
						<h6>{{Cam.nDias}}</h6>
					</span>
					<br>
				</td>
				<td>
					<div ng-if="Cam.enviadoCorreo == ''">
						<img style="padding:5px;" src="../imagenes/noEnviado.png" align="left" width="40" title="Cotización NO Enviada">
						{{Cam.fechaEnvio | date:'dd/MM/yy'}}
					</div>
					<div ng-if="Cam.enviadoCorreo == 'on' && Cam.Contactar == 'No'">
						<img style="padding:5px;" src="../imagenes/enviarConsulta.png" align="left" width="40" title="Cotización enviado en correo automatico">
						{{Cam.fechaEnvio | date:'dd/MM/yy'}}
					</div>
					<div ng-if="Cam.proxRecordatorio != '0000-00-00'">
						<img style="padding:5px;" src="../imagenes/alerta.gif" align="left" width="50" title="Contactar con Cliente">
						Contactar {{Cam.proxRecordatorio | date:'dd/MM/yy'}}
					</div>
				</td>
				<td>
				<!--
					<a  type="button"
                        href="recepcionMuestras.php?RAM={{ramAsociar}}"
						class="btn btn-warning">
                        <i class="fas fa-bezier-curve"></i>
                    </a>
				-->
                <!--
					<button type="button" 
		        				class="btn btn-light"
		        				data-toggle="modal" 
		        				data-target="#modal_seguimiento" 
		        				title="Seguimiento"
		        				ng-click="editarSeguimiento(Cam.CAM)"> 
		        		<i class="fas fa-project-diagram"></i> 
		        	</button>				
					<a 	style="margin-top: 5px;"
								type="button"
								href="modCotizacion.php?CAM={{Cam.CAM}}&Rev={{Cam.Rev}}&Cta=0&accion=Actualizar"
		        				class="btn btn-warning"
		        				title="Editar"> 
		        		<i class="fas fa-edit"></i> 
		        	</a>
					<button type="button" 
		        				class="btn btn-danger"
		        				data-toggle="modal" 
		        				data-target="#modal_borrar" 
		        				title="Borrar"
		        				ng-click="editarBorrar(Cam.CAM)" 
		        				style="margin-top: 5px;">
		        		<i class="fas fa-trash-alt"></i> 
		        	</button>	
					<a 	style="margin-top: 5px;"
								type="button"
								href="mDocumentos.php?CAM={{Cam.CAM}}&Rev={{Cam.Rev}}&Cta=0&accion=Up"
		        				class="btn btn-secondary"
		        				title="Up Documentos"> 
		        		<i class="far fa-file-pdf"></i> 
		        	</a>
                    -->
		        </td>
			</tr>
		</tbody>
        <!--
		<tfoot>
			<tr>
				<td colspan="5">
					<h5>
					Total :
					{{ getTotalCAMs() | currency : "UF " : 2 }} UF Ref.	{{ultUF = <?php echo $ultUF; ?>}}
 					{{ultUF * getTotalCAMs() | currency : " $ " : 0}}
 					</h5>
				</td>
			</tr>
		</tfoot>
        -->
	</table>
