function createPT(id1,id2)
{
    var PT=$("#"+id1).val();
    
    $.ajax( {
        url: "model/ajax/newPT.php",
        data:{PT:PT},
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

                            
                            