function cancelJOCollabModif(id1,id2,id3){
    $.ajax( {
        url: "model/ajax/reloadJOCollab.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id1},
        success: function(data) {
            $("#"+id1).val(data);
        }
    });
    $("#"+id2).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id3).prop('disabled', true);
}