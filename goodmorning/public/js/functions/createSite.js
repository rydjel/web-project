function createSite(id1,id2,id3)
{
    var site=$("#"+id1).val();
    var region;
    if ($("#"+id2).prop("checked")) {
        region=1;
    }
    else{
        region=0;
    }
    //var region=$("#"+id2).val();
    $.ajax( {
        url: "model/ajax/newSite.php",
        data:{site:site,region:region},
        method: "post",
        success: function(data) {
            $("#tbody_id").html("");
            var res=data.split(":");
            $("#"+id3).hide();
            $("#message").html(res[0]);
            //document.getElementById("tbody").innerHTML = "";
            $("#tbody_id").append(res[1]);  
        }
    });
      
}

                            
                            