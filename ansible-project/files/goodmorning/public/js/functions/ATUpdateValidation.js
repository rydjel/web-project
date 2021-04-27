function ATUpdateValidation(id1,id2,id3,id4)
{
    //alert("click! "+id1+" "+id2);
    var at=$("#"+id1).val();
    var impactTACE=$("#"+id2).val();
    var facturable=$("#"+id3).is(":checked");
    //var initialisation=$("#"+id4).is(":checked");
   // var dateDebut=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/updateAT.php",
        method: "post",
        data: {at:at,impactTACE:impactTACE,facturable:facturable,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id4).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id4).prop('disabled', true);  
            }  
        }
    });
    window.scrollTo(0, 0);
}