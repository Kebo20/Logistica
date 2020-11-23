Listar(1);
var $sucursal = $("#id_cmb_suc").select2({
    dropdownAutoWidth: true,
    width: '97%'
});
var $almacen = $("#id_cmb_alm").select2({
    dropdownAutoWidth: true,
    width: '97%'
});

$("#id_cmb_suc").change(function () {
   
    
        almacenxsucursal()
        setTimeout(function () {
            $("#id_cmb_alm").select2('open');

        }, 200);

});


function almacenxsucursal() {
    $("#id_cmb_alm").val("").change();
    $.post("controlador/Clogistica.php?op=LISTAR_ALM_GRALxSUC", {
        sucursal: $("#id_cmb_suc").val(),

    }, function (data) {

        $("#id_cmb_alm").html(data);

    });
}


function Listar() {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_LOTE&q=' + $("#buscar").val() + "&id_almacen=" + $("#id_cmb_alm").val(),
        type: "POST",
        dataType: "json",

        success: function (data) {
            console.log(data)
            $("#lista").html("");


            $.each(data, function (key, val) {

                $("#lista").append("<tr>"
                +"<td width='5%'>" + val[0] + "</td>"
                +"<td width='15%' align='right'>" + val[1] + "</td>"
                +"<td width='25%'>" + val[2] + "</td>"
                +"<td width='5%' align='right'>" + val[3] + "</td>"
                +"<td width='10%' >" + val[4] + "</td>"
                +"<td width='10%'>"+val[5]+"</td>"
             

                +"</tr>");

            })

        },

        error: function (e) {
            console.log(e)
            $("#paginacion").html("");
            $("#lista").html("<td class='text-center' colspan='7'>No se encontraron resultados<td></tr>");
        }
    });
}



