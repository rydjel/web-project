function cancelTaskModif(id1,id2,id3,id4,id5,id6){

    $.ajax( {
        url: "model/ajax/reloadATask.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id5},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id2).val(res[1]);
            $("#"+id3).val(res[2]);
            if (res[3]==0) {
                $("#"+id4).prop("checked",false)
            }
            else{
                $("#"+id4).prop("checked",true)
            }
        }
    });
    $("#"+id5).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id6).prop('disabled', true);
}