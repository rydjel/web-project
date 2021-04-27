function getCollabList(val,id)
{
   //document.getElementById(id).value="";
    $.ajax( {
        url: "model/ajax/getCollabList.php",
        method: "post",
        data: 'pu='+val,
        success: function(data) {
            //$("#"+id).html(data);
            var res=data.split(":");
            if (val!="Sélectionner une PU ...") {
                $("#"+id).html(res[1]);
                /* $("#collabConsultation").prop('disabled',false);
                $("#collabModification").prop('disabled',false);     */
            }
            else{
                $("#"+id).html(res[0]);
                /* $("#collabConsultation").prop('disabled',true);
                $("#collabModification").prop('disabled',true); */  
            }
        }
    });
}