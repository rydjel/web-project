function createMU(id1,id2)
{
    var mu=$("#"+id1).val();
    
    $.ajax( {
        url: "model/ajax/newMU.php",
        data:{mu:mu},
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

                            
                            