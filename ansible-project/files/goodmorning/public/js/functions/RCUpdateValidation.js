function RCUpdateValidation(id1,id2,id3,id4,id5,id6,id7)
{
    //alert("click! "+id1+" "+id2);
    var region=$("#"+id1).val();
    var role=$("#"+id2).val();
    var code=$("#"+id3).val();
    var grade=$("#"+id4).val();
    var rateCard=$("#"+id5).val();
    var year=$("#"+id7).val();
   // var dateDebut=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/updateRC.php",
        method: "post",
        data: {region:region,role:role,code:code,grade:grade,rateCard:rateCard,idExtend:id1,year:year},
        success: function(data) {
            $("#message").html(data);
            $("#"+id6).closest('tr').find('input,select').prop('disabled', true);
            $("#"+id6).prop('disabled', true);
        }
    });
    window.scrollTo(0, 0);
}