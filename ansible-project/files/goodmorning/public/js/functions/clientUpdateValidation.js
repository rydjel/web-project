function clientUpdateValidation(id1,id2,id3)
{
    //alert("click! "+id1+" "+id2);
    var client=$("#"+id1).val();
    var marketUnit=$("#"+id2).val();
    
    $.ajax( {
        url: "model/ajax/updateClient.php",
        method: "post",
        data: {client:client,marketUnit:marketUnit,idExtend:id1},
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