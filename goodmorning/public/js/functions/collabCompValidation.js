function collabCompValidation(id1,id2,id3)
{ 
    var ggid=$("#"+id1).val();
    var title=$("#"+id2).val();
    var level=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/createCollabComp.php",
        method: "post",
        //dataType:"JSON",
        data: {ggid:ggid,title:title,level:level},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[0]);
            if (res[1]=="OK") {
                //Changement des id des inputs de la ligne de competence
                // document.getElementById(id2).id="collabCompetenceTitle"+data[2];
                // document.getElementById(id3).id="collabNivComp"+data[2];
                // document.getElementById(id4).id="collabCompValid"+data[2];
                $("#bodyComp").html("");
                $("#bodyComp").append(res[2]);
                // désactivitation de tous les inputs et boutons de la ligne de tache
                //$("#collabCompValid"+data[2]).closest('tr').find('input,select,button').prop('disabled', true);
                //désactivation du bouton de validation
                //$("#collabCompValid"+data[2]).prop('disabled', true);   
                // activation du bouton de rajout d'une nouvelle ligne de tache
                $("#newComp").prop('disabled', false); 
            }  
        }
    });
    window.scrollTo(0, 0);
}