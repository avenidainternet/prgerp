<table class="table table-dark table-hover" style="margin-top: 5px;" ng-show="tablaCAM">
		<thead>
			<tr>
				<th>RAM			    </th>
				<th>Fecha		    </th>
				<th width="20%">Cliente	        </th>
				<th>Días		    </th>
				<th width="25%">Observaciones	</th>
				<th>Acciones	    </th>
			</tr>
		</thead>
		<tbody>

			<tr ng-repeat="Ram in MuestrasRAM | filter: filtroClientes" 
				ng-class="verColorLinea(Ram.Estado, Ram.RAM, 0, Cam.nDias, 0, 0, 0, Ram.colorCam)">

				<td>
					<div ng-if="Ram.CAM > 0">
						C{{Ram.CAM}} 
					</div>
					R{{Ram.RAM}}<br>
					<div ng-if="Ram.Fan > 0">
						Clon {{Ram.Fan}} 
					</div>
				</td>
				<td>
					{{Ram.fechaRegistro | date:'dd/MM'}}<br>
				</td>
				<td>{{Ram.Cliente}}</td>
				<td>
				</td>
				<td>
                    {{Ram.Descripcion}}
				</td>
				<td>
				<!--
                    <a  type="button"
                        href=""
                        ng-click="filtrarMuestra(Ram.RutCli, Ram.RAM)">
                            <img src="../gastos/imagenes/data_filter_128.png" 	width="32"  title="Filtrar">		
                    </a>
				-->
                    <a  type="button"
                        href="registro?RAM={{Ram.RAM}}&Fan={{Ram.Fan}}&accion=Editar">
                        <img src="../gastos/imagenes/corel_draw_128.png" 	width="32"  title="Editar Muestra">		
                    </a>
                    <span ng-show="Ram.Fan == 0">
                    <a  type="button"
                        href="registro?RAM={{Ram.RAM}}&Fan={{Ram.Fan}}&accion=Borrar">
                        <img src="../gastos/imagenes/del_128.png"   			width="32"  title="Dar de Baja">		
                    </a>
                    </span>
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
