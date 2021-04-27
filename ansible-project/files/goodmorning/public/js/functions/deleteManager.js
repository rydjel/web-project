function deleteManager(id1,id2)
{
    var manager=$("#"+id1).val();
    
    $.ajax( {
        url: "model/ajax/deleteManager.php",
        data:{manager:manager},
        method: "post",
        success: function(data) {
            $("#tbody_id").html("");
            var res=data.split(":");
            $("#"+id2).hide();
            $("#message").html(res[0]);
            //document.getElementById("tbody").innerHTML = "";
            $("#tbody_id").append(res[1]);  
        }
    });
      
}

                            
                            