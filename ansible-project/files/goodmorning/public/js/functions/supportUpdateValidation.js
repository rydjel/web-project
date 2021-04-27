function supportUpdateValidation(id1,id2,id3)
{
    //alert("click! "+id1+" "+id2);
    var nom=$("#"+id1).val();
    var prenom=$("#"+id2).val();
    /* var region=$("#"+id2).is(":checked");
    var dateDebut=$("#"+id3).val(); */ 
    $.ajax( {
        url: "model/ajax/updateSupport.php",
        method: "post",
        data: {nom:nom,prenom:prenom,idExtend:id1},
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