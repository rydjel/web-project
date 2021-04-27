function getTACEandFact(id1,id2,id3)
{
    typeActivite=$("#"+id1).val();
    $.ajax( {
        url: "model/ajax/getTACEandFact.php",
        method: "post",
        //dataType:'JSON',
        data: {typeActivite:typeActivite},
        success: function(data) {
            var res=data.split(":");
            $("#"+id2).val(res[0]);
            if (res[1]==1) {
                $("#"+id3).prop("checked",true);
            }
            else{
                $("#"+id3).prop("checked",false);
            }
        }
    });
}