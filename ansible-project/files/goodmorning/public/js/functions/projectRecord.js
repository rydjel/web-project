function projectRecord(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10)
{
    var pu=$("#"+id1).val();
    var codeProjet=$("#"+id2).val();
    var titreProjet=$("#"+id3).val();
    var Commercial=$("#"+id4).val();
    var rfa=$("#"+id5).val();
    var client=$("#"+id6).val();
    var typeProjet=$("#"+id7).val();
    var VolJourVendu=$("#"+id8).val();
    var BudgetVendu=$("#"+id9).val();
    var codeGen=document.getElementById(id10).checked;
    
    $.ajax( {
        url: "model/ajax/createProj.php",
        method: "post",
        dataType:'JSON',
        data: {pu:pu,codeProjet:codeProjet,titreProjet:titreProjet,Commercial:Commercial,rfa:rfa,client:client,typeProjet:typeProjet,VolJourVendu:VolJourVendu,
            BudgetVendu:BudgetVendu,codeGen:codeGen},
        success: function(data) {
            $("#message").html(data[0]);
            $("#tbody").html(data[1]);
            if (data[2]=="OK") {
                $("#newTask").prop('disabled',false);
                $("#taskAffectation").prop('disabled',false);
                $("#registerNewProj").prop('disabled',true);
            }
            //$("#newTask").prop('disabled',false);
            //$("#taskAffectation").prop('disabled',false);

        }
    });
    window.scrollTo(0, 0);
}