function collabChargesFilter(id1,id2,id3,id4,id5)
{
    var year=$("#"+id1).val();
    var initMonth=$("#"+id2).val();
    var lastMonth=$("#"+id3).val();
    var lastYear=$("#"+id4).val();
    var idCollab=$("#"+id5).val();
    $.ajax( {
        url: "model/ajax/collabChargesFilter.php",
        method: "post",
        data: {year:year,initMonth:initMonth,lastMonth:lastMonth,lastYear:lastYear,idCollab:idCollab},
        beforeSend: function(){
            // Disable Buttons
            $("#Retour").prop('disabled',true);
            $("#Enregistrer").prop('disabled',true);
            },
        success: function(data) {
            var res=data.split(":_:_:");
            $("#message").html(res[0]);
            $("#chargesTable").html("");
            $("#chargesTable").append(res[1]);
            $("#Retour").prop('disabled',false);
            $("#Enregistrer").prop('disabled',false);
        }
    });
    window.scrollTo(0, 0);
}