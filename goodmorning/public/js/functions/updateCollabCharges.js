function updateCollabCharges()
{
    var form=$("#collabChargesForm");
    var formData=form.serializeArray();

    // Check if there are forbidden characters in comment Fields
    var inputComment=document.getElementsByClassName("comment")
    var nbDefault=0
    for (var index = 0; index < inputComment.length; index++) {
        var content=inputComment[index].value;
        if (content.indexOf('"')!==-1 || content.indexOf(':')!==-1 ) {
            nbDefault=nbDefault+1;
        }   
    }
    if (nbDefault>=1) {
        $("#commentErrorInputModal").show();
    }
    else{
        $.ajax( {
            url: "model/ajax/updateCollabCharges.php",
            // method: "post",
            type:'POST',
            data: formData,
            beforeSend: function(){
                // Disable Buttons
                $("#Retour").prop('disabled',true);
                $("#Enregistrer").prop('disabled',true);
                },
            success: function(data) {
                var res=data.split(":_:_:");
                $("#message").html(res[0]);
                if (res[1]!=="") {
                    $("#collabCharges").html("");
                    $("#collabCharges").append(res[1]);
                } 
                //$("#collabCharges").html("");
                //$("#collabCharges").append(res[1]);
                $("#Retour").prop('disabled',false);
                $("#Enregistrer").prop('disabled',false);
            }
        });
    }

    /* $.ajax( {
        url: "model/ajax/updateCollabCharges.php",
        // method: "post",
        type:'POST',
        data: formData,
        beforeSend: function(){
            // Disable Buttons
            $("#Retour").prop('disabled',true);
            $("#Enregistrer").prop('disabled',true);
            },
        success: function(data) {
            var res=data.split(":_:_:");
            $("#message").html(res[0]);
            $("#collabCharges").html("");
            $("#collabCharges").append(res[1]);
            $("#Retour").prop('disabled',false);
            $("#Enregistrer").prop('disabled',false);
        }
    }); */
    window.scrollTo(0, 0);
}