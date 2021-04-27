function cancelExpModif(id1,id2,id3,id4,id5){

    $.ajax( {
        url: "model/ajax/reloadExp.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id4},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id2).val(res[1]);
            $("#"+id3).val(res[2]);
        }
    });
    $("#"+id4).closest('tr').find('input,select,textarea').prop('disabled', true);
    $("#"+id5).prop('disabled', true);
}