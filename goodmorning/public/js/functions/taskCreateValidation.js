function taskCreateValidation(id1,id2,id3,id4,id5,id6,id7,id8)
{ 
    var taskName=$("#"+id1).val();
    var typeActivity=$("#"+id2).val();
    var tace=$("#"+id3).val();
    var facturable=document.getElementById(id4).checked;
    var codeProjet=$("#"+id5).val();
    var codeGen; // Code Générique
    if ($('#'+id7).is(":checked")) {
        codeGen=1;
    }
    else{
        codeGen=0;
    }
    var yearGen=$("#"+id8).val();
    var actionEnCours='<div class="alert alert-info" role="alert"> <h3> Création de la nouvelle tâche en cours .... </h3> </div>'
    $.ajax( {
        url: "model/ajax/createTask.php",
        method: "post",
        //dataType:"JSON",
        data: {taskName:taskName,typeActivity:typeActivity,tace:tace,facturable:facturable,codeProjet:codeProjet,codeGen:codeGen,yearGen:yearGen},
        beforeSend: function(){
            // Show message for action's going on
            $("#message").html(actionEnCours);
            $("#"+id6).prop('disabled', true);  // Disable new task button before send
            $("#projAction :submit").prop("disabled", true);
            $("#projAction :button").prop("disabled", true);



            /* $("#"+id15).prop('disabled',true);
            $("#collabCancel").prop('disabled',true); */
            },
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[0]);
            if (res[1]=="OK") {
                //Changement des id des inputs de la ligne de tache
                /* document.getElementById(id1).id="taskType"+data[2];
                document.getElementById(id2).id="activityType"+data[3];
                document.getElementById(id3).id="tace"+data[3];
                document.getElementById(id4).id="facturable"+data[3];
                document.getElementById(id6).id="validationDone"+data[2]; */
                // désactivitation de tous les inputs et boutons de la ligne de tache
               //$("#validationDone"+data[2]).closest('tr').find('input,select,button').prop('disabled', true);
                //désactivation du bouton de validation
                //$("#validationDone"+data[2]).prop('disabled', true);   
                // activation du bouton de rajout d'une nouvelle ligne de tache
                $("#tbody").html("");
                $("#tbody").append(res[2]);
                $("#"+id6).prop('disabled', false);
                $("#projAction :submit").prop("disabled", false);
                $("#projAction :button").prop("disabled", false); 
            }else{
                $("#projAction :submit").prop("disabled", false);
                $("#projAction :button").prop("disabled", false); 
            }  
        }
    });
    window.scrollTo(0, 0);
}