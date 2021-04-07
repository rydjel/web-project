function getSiteRoleList(val,id)
{
    //alert("click! "+id1+" "+id2);
    //var Site=$("#"+id1).val();
   // var dateDebut=$("#"+id3).val();
   //document.getElementById(id).value="";
    $("#"+id).html("");
    $.ajax( {
        url: "model/ajax/getSiteRoleList.php",
        method: "post",
        data: 'siteID='+val,
        success: function(data) {
            $("#"+id).html(data);
        }
    });
}