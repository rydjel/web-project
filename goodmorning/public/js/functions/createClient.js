function createClient(id1,id2,id3)
{
    var client=$("#"+id1).val();
    var marketUnit=$("#"+id2).val();
    
    $.ajax( {
        url: "model/ajax/newClient.php",
        data:{client:client,marketUnit:marketUnit},
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

                            
                            