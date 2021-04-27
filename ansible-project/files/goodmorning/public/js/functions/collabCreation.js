function collabCreation(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10,id11,id12,id13,id14,id15,id16,id17,id18)
{
    //alert("click! "+id1+" "+id2);
    var Nom=$("#"+id1).val();
    var Prenom=$("#"+id2).val();
    var ggid=$("#"+id3).val();
    var pu=$("#"+id4).val();
    var siteID=$("#"+id5).val();
    var dateEntree=$("#"+id6).val();
    var dateSortie=$("#"+id7).val();
    //var statut=$("#"+id8).val();
    var role=$("#"+id8).val();
    var Grade=$("#"+id9).val();
    var RateCard=$("#"+id10).val();
    var pourcentageActivite=$("#"+id11).val();
    var support=$("#"+id12).val();
    var manager=$("#"+id13).val();
    var commentaire=$("#"+id14).val();
    var CM=$("#"+id16).val();
    var cvBook=document.getElementById(id17).checked;
    var tjmCible=$("#"+id18).val();

    var actionEnCours='<div class="alert alert-info" role="alert"> <h3> Création du nouveau Collaborateur en cours .... </h3> </div>'
    //var profil=$("#"+id14).val();
   // var dateDebut=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/createCollab.php",
        method: "post",
        data: {Nom:Nom,Prenom:Prenom,ggid:ggid,pu:pu,siteID:siteID,dateEntree:dateEntree,dateSortie:dateSortie,role:role,Grade:Grade,RateCard:RateCard,
            pourcentageActivite:pourcentageActivite,support:support,manager:manager,CM:CM,cvBook:cvBook,tjmCible:tjmCible,commentaire:commentaire},
        beforeSend: function(){
            // Show message for action's going on
            $("#message").html(actionEnCours);
            $("#"+id15).prop('disabled',true);
            $("#collabCancel").prop('disabled',true);
            },
        success: function(data) {
            var res=data.split(":");
            //$("#message").html(data);
            $("#message").html(res[0]);
            if (res[1]=='OK') {
                $("#ID").val(res[2]);
                $("#newProfil").prop('disabled', false);
                $("#newComp").prop('disabled', false);
                $("#newCertif").prop('disabled', false);  
                $("#newExp").prop('disabled', false);
                $("#messageRecordCollab").html("");
                $("#collabCancel").prop('disabled',false);
                //$("#"+id14).prop('disabled',true);   
            }
            else{
                $("#"+id15).prop('disabled',false);
                $("#collabCancel").prop('disabled',false);
            }
            /* $("#newComp").prop('disabled', false);
            $("#newCertif").prop('disabled', false);  
            $("#newExp").prop('disabled', false); */      
        }
    });
    window.scrollTo(0, 0);
}