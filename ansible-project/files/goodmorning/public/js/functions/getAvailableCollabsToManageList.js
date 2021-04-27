function getAvailableCollabsToManageList(val,id)
{
   document.getElementById(id).value="";
    $.ajax( {
        url: "model/ajax/getAvailableCollabsToManageList.php",
        method: "post",
        data: 'pu='+val,
        success: function(data) {
            $("#"+id).html(data);
            /* if (val!="Sélectionner une PU ...") {
                $("#collabConsultation").prop('disabled',false);
                $("#collabModification").prop('disabled',false);    
            }
            else{
                $("#collabConsultation").prop('disabled',true);
                $("#collabModification").prop('disabled',true);  
            } */
        }
    });
}