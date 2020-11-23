<div class="page-header" style="background-color:#EFF3F8; margin:0">
    <h1><i class="menu-icon"><img src="imagenes/grupo_user.png" style="border:0;" height="25" width="25"></i>
        <span id="Titulo" style="font-size:13px; font-weight:bold">LOTES </span>

    </h1>

</div>
<?php
require_once 'cado/ClaseContabilidad.php';
$osucursal = new Contabilidad();
$lista_sucursales = $osucursal->ListarTodoSucursal();


?>

<input type="hidden" id="IdFilaUsu" />
<input type="hidden" id="idvalor" />
<div class="bodycontainer scrollable">

    <table class="table table-responsive table-bordered table-striped text-left" style="margin:0">
        <thead>
            <tr>
                <th width="">N°</th>
                <th>Nro</th>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Unid.</th>
                <th>Fecha venc.</th>

            </tr>
        </thead>
        <tbody id="lista" style="font-size:12px;"></tbody>

    </table>
    <div id="paginacion" align='right'>

    </div>


</div>


<div class="page-header" style="background-color:#EFF3F8;padding-left:10px; padding-top:15px">
    <table width="100%">
        <tr>
            

            <td width="35%">

                <select onchange="javascript:Listar()" id="id_cmb_suc" class='form-control' style="width:90%">
                    <option value="">Seleccione sucursal</option>
                    <?php foreach ($lista_sucursales as $s) { ?>
                    <option value="<?= $s[0] ?>"><?= $s[1] ?> - <?= $s["nombre_empresa"] ?></option>
                    <?php } ?>

                </select>
            </td>


            <td width="35%">
                <select onchange="javascript:Listar()" id="id_cmb_alm" class=" input" style="width:90%">
                    <option value="">Seleccione almacén</option>

                </select>
            </td>

            <td width="40%"><span class="input-icon" style="width:90%">
                    <input type="text" id="buscar" placeholder=" Buscar lote" class="form-control"
                        onkeyup="javascript:Listar()" autocomplete="off" />
                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                </span></td>

        </tr>
    </table>
</div>




<script src='js/log_lote.js'></script>




<style>
.bodycontainer {
    max-height: 340px;
    width: 100%;
    margin: 0;
    overflow-y: auto;
    height: 340px;
}

.table-scrollable {
    margin: 0;
    padding: 0;
}
</style>