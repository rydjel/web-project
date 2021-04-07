function pnlKpiUpdateValidation(id1,id2,id3,id4,id5)
{

    var idkpiType=$("#"+id1).val();
    var idMonth=$("#"+id2).val();
    var budget=$("#"+id3).val();
    var forecast=$("#"+id4).val();

    $.ajax( {
        url: "model/ajax/updateKpi.php",
        method: "post",
        data: {idkpiType:idkpiType,idMonth:idMonth,budget:budget,forecast:forecast,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id5).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id5).prop('disabled', true);
            }
        }
    });
    
    window.scrollTo(0, 0);
}