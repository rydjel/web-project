function collabModification(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10,id11,id12,id13,id14,id15,id16,id17,id18,id19)
{
    //alert("click! "+id1+" "+id2);
    var Nom=$("#"+id1).val();
    var Prenom=$("#"+id2).val();
    var ggid=$("#"+id3).val();
    var pu=$("#"+id4).val();
    var Site=$("#"+id5).val();
    var dateEntree=$("#"+id6).val();
    var dateSortie=$("#"+id7).val();
    var statut=$("#"+id8).val();
    var role=$("#"+id9).val();
    var Grade=$("#"+id10).val();
    var RateCard=$("#"+id11).val();
    var pourcentageActivite=$("#"+id12).val();
    var support=$("#"+id13).val();
    var manager=$("#"+id14).val();
    var CM=$("#"+id17).val();
    var commentaire=$("#"+id15).val();
    var id=$("#"+id16).val();
    var cvBook=document.getElementById(id18).checked;
    var tjmCible=$("#"+id19).val();
   // var dateDebut=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/modifCollab.php",
        method: "post",
        data: {Nom:Nom,Prenom:Prenom,ggid:ggid,pu:pu,Site:Site,dateEntree:dateEntree,dateSortie:dateSortie,statut:statut,role:role,Grade:Grade,RateCard:RateCard,
            pourcentageActivite:pourcentageActivite,support:support,manager:manager,CM:CM,cvBook:cvBook,commentaire:commentaire,id:id,tjmCible:tjmCible},
        success: function(data) {
            $("#message").html(data);
        }
    });
    window.scrollTo(0, 0);
}