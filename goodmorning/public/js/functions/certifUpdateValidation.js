function certifUpdateValidation(id1,id2)
{
    //alert("click! "+id1+" "+id2);
    var certif=$("#"+id1).val();
    
    $.ajax( {
        url: "model/ajax/updateCollabCertif.php",
        method: "post",
        data: {certif:certif,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id2).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id2).prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);
}