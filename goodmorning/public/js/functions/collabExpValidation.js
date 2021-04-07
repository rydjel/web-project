function collabExpValidation(id1,id2,id3,id4)
{ 
    var ggid=$("#"+id1).val();
    var debutExp=$("#"+id2).val();
    var finExp=$("#"+id3).val();
    var expDetails=$("#"+id4).val();

    
    $.ajax( {
        url: "model/ajax/createCollabExp.php",
        method: "post",
        //dataType:"JSON",
        data: {ggid:ggid,debutExp:debutExp,finExp:finExp,expDetails:expDetails},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[0]);
            if (res[1]=="OK") {
                //Changement des id des inputs de la ligne de competence
               /*  document.getElementById(id2).id="collabExpDebut"+data[2];
                document.getElementById(id3).id="collabExpEnd"+data[2];
                document.getElementById(id4).id="collabExpDetails"+data[2];
                document.getElementById(id5).id="ExpValid"+data[2]; */

                // désactivitation de tous les inputs et boutons de la ligne de tache
                // $("#ExpValid"+data[2]).closest('tr').find('input,select,button,textarea').prop('disabled', true);
                //désactivation du bouton de validation
                // $("#ExpValid"+data[2]).prop('disabled', true);   
                // activation du bouton de rajout d'une nouvelle ligne de tache
                $("#bodyExp").html("");
                $("#bodyExp").append(res[2]);
                $("#newExp").prop('disabled', false); 
            }  
        }
    });
    window.scrollTo(0, 0);
}