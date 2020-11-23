Listar();

var $area = $("#id_cmb_area").select2({
    dropdownAutoWidth: true,
    width: '97%'
});

$("#id_cmb_area").change(function () {
   
    
       Listar()

});



function Listar() {

    //  $("#lista").html("<tr><td class='text-center' colspan='5'>Cargando ...<td></tr>");
    //    $("#paginacion").html("<span class='btn btn-info'>Anterior</span> <span class='btn btn-success'>1</span> <span class='btn btn-info'>Siguiente</span>")

    $.ajax({

        url: 'controlador/Clogistica.php?op=LIS_TRANS_AREA&nombre_producto=' + $("#buscar").val() + "&id_area=" + $("#id_cmb_area").val(),
        type: "POST",
        dataType: "json",

        success: function (data) {
            console.log(data)
            $("#lista").html("");


            $.each(data, function (key, val) {

                $("#lista").append("<tr>"
                +"<td width='5%'>" + val[0] + "</td>"
                +"<td width='10%' align='right'>" + val[1] + "</td>"
                +"<td width='10%'>" + val[2] + "</td>"
                +"<td width='35%' >" + val[3] + "</td>"
                +"<td width='10%' >" + val[4] + "</td>"
                +"<td width='10%'>"+val[5]+"</td>"
                +"<td width='20%'>"+val[6]+"</td>"
             

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



