function cancelDTModif(id1,id2,id3,id4){
    $.ajax( {
        url: "model/ajax/reloadDT.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id3},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id2).val(res[1]);
        }
    });
    $("#"+id3).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id4).prop('disabled', true);
}