function cancelAffUpdate(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10,id11,id12,id13,id14,id15,id16,id17,id18,id19){

    $.ajax( {
        url: "model/ajax/reloadAff.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id16},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id2).val(res[1]);
            $("#"+id3).val(res[2]);
            $("#"+id4).val(res[3]);
            $("#"+id5).val(res[4]);
            $("#"+id6).val(res[5]);
            $("#"+id7).val(res[6]);
            $("#"+id8).val(res[7]);
            $("#"+id9).val(res[8]);
            $("#"+id10).val(res[9]);
            $("#"+id11).val(res[10]);
            $("#"+id12).val(res[11]);
            $("#"+id13).val(res[12]);
            $("#"+id14).val(res[13]);
            $("#"+id15).val(res[14]);
            if (res[15]==0) {
                $("#"+id16).prop("checked",false)
            }
            else{
                $("#"+id16).prop("checked",true)
            }
            $("#"+id19).val(res[16]);
        }
    });
    $("#"+id17).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id18).prop('disabled', true);
}