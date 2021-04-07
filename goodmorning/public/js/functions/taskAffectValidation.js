function taskAffectValidation(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10,id11,id12,id13,id14,id15,id16,id17,id18,id19,id20)
{
    var collabChoice=$("#"+id1).val();
    var task=$("#"+id2).val();
    var tjm=$("#"+id3).val();
    var budgetInit=$("#"+id4).val();
    var budgetComp=$("#"+id5).val();
    var volJoursInit=$("#"+id6).val();
    var volJoursComp=$("#"+id7).val();
    var fraisInit=$("#"+id8).val();
    var fraisComp=$("#"+id9).val();
    var autresCouts=$("#"+id10).val();
    var debutAnnee=$("#"+id11).val();
    var debutMois=$("#"+id12).val();
    var finAnnee=$("#"+id13).val();
    var finMois=$("#"+id14).val();
    var isow=$("#"+id15).val();
    var odm=$("#"+id16).val();
    var fop=document.getElementById(id17).checked;
    var coverage=$("#"+id18).val();
    var sowid=$("#"+id19).val();
    var codeProj=$("#"+id20).val();
   
    $.ajax( {
        url: "model/ajax/taskAffect.php",
        method: "post",
        data: {collabChoice:collabChoice,task:task,tjm:tjm,budgetInit:budgetInit,budgetComp:budgetComp,volJoursInit:volJoursInit,volJoursComp:volJoursComp,
            fraisInit:fraisInit,fraisComp:fraisComp,autresCouts:autresCouts,debutAnnee:debutAnnee,debutMois:debutMois,finAnnee:finAnnee,finMois:finMois,isow:isow,
            odm:odm,fop:fop,coverage:coverage,sowid:sowid,codeProj:codeProj},
        success: function(data) {
            //$("#message").html(data);
            //location.reload();
            var res=data.split(":");
            alert(data);
            $("#message").html(res[0]);
            $("#tbody").html("");
            $("#tbody").append(res[1]);

           /*  setTimeout(function(){// wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
           }, 5000); */ 
        }
    });
    window.scrollTo(0, 0);

}