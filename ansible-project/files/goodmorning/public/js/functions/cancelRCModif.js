function cancelRCModif(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10){
    $.ajax( {
        url: "model/ajax/reloadRC.php",
        method: "post",
        //dataType:'JSON',
        data: {idExtend:id7},
        success: function(data) {
            var res=data.split(":");
            $("#"+id1).val(res[0]);
            $("#"+id2).val(res[1]);
            $("#"+id3).val(res[2]);
            $("#"+id4).val(res[3]);
            $("#"+id5).val(res[4]);
            var ctb1=res[4]/((100-50)/100);
            var ctb2=res[4]/((100-45)/100);
            var ctb3=res[4]/((100-40)/100);
/*             $("#"+id8).val(ctb1);
            $("#"+id9).val(ctb2);
            $("#"+id10).val(ctb3); */
            $("#"+id8).val(ctb1.toFixed(2));
            $("#"+id9).val(ctb2.toFixed(2));
            $("#"+id10).val(ctb3.toFixed(2));
        }
    });
    $("#"+id6).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id7).prop('disabled', true);
}