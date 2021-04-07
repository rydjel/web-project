function getProjectList(val,id)
{
    //alert("click! "+id1+" "+id2);
    //var Site=$("#"+id1).val();
   // var dateDebut=$("#"+id3).val();
   document.getElementById(id).value="";
    $.ajax( {
        url: "model/ajax/getProjectList.php",
        method: "post",
        data: 'Client='+val,
        success: function(data) {
            $("#"+id).html(data);
        }
    });
}