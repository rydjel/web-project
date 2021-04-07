function puUpdateValidation(id1,id2,id3,id4,id5)
{
    //alert("click! "+id1+" "+id2);
    var pu=$("#"+id1).val();
    var region=$("#"+id2).is(":checked");
    var mu=$("#"+id4).is(":checked");
   // var dateDebut=$("#"+id3).val();
   var entite=$("#"+id5).val();
    
    $.ajax( {
        url: "model/ajax/updatePU.php",
        method: "post",
        data: {pu:pu,region:region,idExtend:id1,mu:mu,entite:entite},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id3).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id3).prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);
}