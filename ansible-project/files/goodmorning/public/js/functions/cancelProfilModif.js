function cancelProfilModif(id1,id2,id3,id4){

    $.ajax( {
        url: "model/ajax/reloadProfil.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id2},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id4).val(res[1]);
        }
    });

    $("#"+id1).prop('disabled', true);
    $("#"+id3).prop('disabled', true);
    $("#"+id4).prop('disabled', true);
}