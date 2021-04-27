function collabProfilAdd(id1,id2,id3)
{ 
    var details=$("#"+id1).val();
    var idCollab=$("#"+id2).val();
    var idPT=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/createCollabProfil.php",
        method: "post",
        data: {details:details,idCollab:idCollab,idPT:idPT},
        success: function(data) {
            var res=data.split(":");
            //$("#message").html(data); 
            $("#message").html(res[0]); 
            if (res[1]=="OK") {
                //$("#"+id3).prop("disabled",true);
                $("#bodyProfil").html("");
                $("#bodyProfil").append(res[2]);
            }
        }
    });
    window.scrollTo(0, 0);
}