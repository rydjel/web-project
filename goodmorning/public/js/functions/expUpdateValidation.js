function expUpdateValidation(id1,id2,id3,id4)
{
    var debut=$("#"+id1).val();
    var fin=$("#"+id2).val();
    var details=$("#"+id3).val();

    
    $.ajax( {
        url: "model/ajax/updateCollabExp.php",
        method: "post",
        data: {debut:debut,fin:fin,details:details,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id4).closest('tr').find('input,select,textarea').prop('disabled', true);
                $("#"+id4).prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);
}