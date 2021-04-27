function cancelSiteModif(id1,id2,id3,id4){
    $.ajax( {
        url: "model/ajax/reloadSite.php",
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
        }
    });
    $("#"+id3).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id4).prop('disabled', true);
}