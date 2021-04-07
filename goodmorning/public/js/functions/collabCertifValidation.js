function collabCertifValidation(id1,id2)
{ 
    var ggid=$("#"+id1).val();
    var title=$("#"+id2).val();
    
    $.ajax( {
        url: "model/ajax/createCollabCertif.php",
        method: "post",
        //dataType:"JSON",
        data: {ggid:ggid,title:title},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[0]);
            if (res[1]=="OK") {
                $("#bodyCertif").html("");
                $("#bodyCertif").append(res[2]);
                //Changement des id des inputs de la ligne de certification
                // document.getElementById(id2).id="collabCertifTitle"+data[2];
                // document.getElementById(id3).id="collabCertifValid"+data[2];

                // désactivitation de tous les inputs et boutons de la ligne de Certif
                // $("#collabCertifValid"+data[2]).closest('tr').find('input,select,button').prop('disabled', true);
                //désactivation du bouton de validation
                //$("#collabCertifValid"+data[2]).prop('disabled', true);   
                // activation du bouton de rajout d'une nouvelle ligne de tache
                $("#newCertif").prop('disabled', false); 
            }  
        }
    });
    window.scrollTo(0, 0);
}