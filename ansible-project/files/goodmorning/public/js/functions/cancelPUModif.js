function cancelPUModif(id1,id2,id3,id4,id5,id6){
    $.ajax( {
        url: "model/ajax/reloadPU.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id3},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            if (res[1]==1) {
                $("#"+id2).prop("checked",true);
            }
            else{
                $("#"+id2).prop("checked",false);
            }
            if (res[2]==1) {
                $("#"+id5).prop("checked",true);
            }
            else{
                $("#"+id5).prop("checked",false);
            } 
            $("#"+id6).val(res[3]); 
        }
    });
    $("#"+id3).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id4).prop('disabled', true);
}