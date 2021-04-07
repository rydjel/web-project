function profilUpdateValidation(id1,id2,id3)
{
    var profil=$("#"+id1).val();
    var PT=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/updateProfil.php",
        method: "post",
        data: {profil:profil,idExtend:id2,PT:PT},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id1).prop('disabled', true);
                $("#"+id2).prop('disabled', true);
                $("#"+id3).prop('disabled', true);  
            }
        }
    });
    window.scrollTo(0, 0);
}