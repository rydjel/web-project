function affUpdateValidation(id1,id2,id3,id4,id5,id6,id7,id8,id9,id10,id11,id12,id13,id14,id15,id16,id17,id18,val1,val2)
{
    var tjm=$("#"+id1).val();
    var budgetInit=$("#"+id2).val();
    var budgetComp=$("#"+id3).val();
    var volJoursInit=$("#"+id4).val();
    var volJoursComp=$("#"+id5).val();
    var fraisInit=$("#"+id6).val();
    var fraisComp=$("#"+id7).val();
    var autresCouts=$("#"+id8).val();
    var debutAnnee=$("#"+id9).val();
    var debutMois=$("#"+id10).val();
    var finAnnee=$("#"+id11).val();
    var finMois=$("#"+id12).val();
    var isow=$("#"+id13).val();
    var sowid=$("#"+id14).val();
    var odm=$("#"+id15).val();
    var fop=document.getElementById(id16).checked;
    var coverage=$("#"+id18).val();
    var codeProjet=$("#codeProjet").val();
    $.ajax( {
        url: "model/ajax/taskAffUpdate.php",
        method: "post",
        data: {tjm:tjm,budgetInit:budgetInit,budgetComp:budgetComp,volJoursInit:volJoursInit,volJoursComp:volJoursComp,
            fraisInit:fraisInit,fraisComp:fraisComp,autresCouts:autresCouts,debutAnnee:debutAnnee,debutMois:debutMois,
            finAnnee:finAnnee,finMois:finMois,isow:isow,sowid:sowid,odm:odm,fop:fop,coverage:coverage,idExtend:id1,
            idCollab:val1,idTask:val2,codeProjet:codeProjet},
        success: function(data) {
            var res=data.split(":");
            if (res[0]=="caution") {
                $("#AffModifParam").val(data);
                $("#ModifPeriodAffModal").show();
            }else{
                //$("#message").html(data);
                $("#message").html(res[0]);
                $("#tbody").html("");
                $("#tbody").append(res[1]);
            }
            //$("#message").html(data);
        }
    });
    $("#"+id17).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id17).prop('disabled', true);
    window.scrollTo(0, 0);
}