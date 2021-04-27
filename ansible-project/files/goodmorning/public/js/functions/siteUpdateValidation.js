function siteUpdateValidation(id1,id2,id3)
{
    //alert("click! "+id1+" "+id2);
    var site=$("#"+id1).val();
    var region=$("#"+id2).is(":checked");
   // var dateDebut=$("#"+id3).val();
    
    $.ajax( {
        url: "model/ajax/updateSite.php",
        method: "post",
        data: {site:site,region:region,idExtend:id1},
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