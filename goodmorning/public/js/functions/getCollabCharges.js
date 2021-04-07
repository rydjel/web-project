function getCollabCharges(val)
{

    $.ajax( {
        url: "model/ajax/getCollabCharges.php",
        method: "post",
        data: {idCollab:val},
        beforeSend: function(){
            // Disable Buttons
            $("#Retour").prop('disabled',true);
            $("#Enregistrer").prop('disabled',true);
            $("#accessCollabProfil").prop('disabled',true);
            },
        success: function(data) {
            var res=data.split(":_:_:");
            $("#message").html(res[0]);
            $("#collabCharges").html("");
            $("#collabCharges").append(res[1]);
            $("#Retour").prop('disabled',false);
            if (res[1] !== "") {
                $("#Enregistrer").prop('disabled',false);
                $("#accessCollabProfil").prop('disabled',false);
            }
        }
    });
    window.scrollTo(0, 0);
}