function kpiTypeUpdateValidation(id1,id2)
{
    //alert("click! "+id1+" "+id2);
    var kpiType=$("#"+id1).val();
    /* var region=$("#"+id2).is(":checked");
    var dateDebut=$("#"+id3).val(); */ 
    $.ajax( {
        url: "model/ajax/updateKpiType.php",
        method: "post",
        data: {kpiType:kpiType,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id2).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id2).prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);
}