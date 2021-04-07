function compUpdateValidation(id1,id2,id3)
{
    var title=$("#"+id1).val();
    var level=$("#"+id2).val();

    
    $.ajax( {
        url: "model/ajax/updateCollabComp.php",
        method: "post",
        data: {title:title,level:level,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id3).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id3).prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);
}