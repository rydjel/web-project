function cancelATModif(id1,id2,id3,id4,id5){
    $.ajax( {
        url: "model/ajax/reloadAT.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id4},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id2).val(res[1]);
            if (res[2]==1) {
                $("#"+id3).prop("checked",true);
            }
            else{
                $("#"+id3).prop("checked",false);
            }
        }
    });
    // $("#"+id1).val(val1);
    // $("#"+id2).val(val2);
    // if (val3==1) {
    //     $("#"+id3).prop("checked",true);
    // }
    // else{
    //     $("#"+id3).prop("checked",false);
    // }
    $("#"+id4).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id5).prop('disabled', true);
}