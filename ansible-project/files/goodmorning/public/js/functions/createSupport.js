function createSupport(id1,id2,id3)
{
    var nom=$("#"+id1).val();
    var prenom=$("#"+id2).val();
    
    $.ajax( {
        url: "model/ajax/newSupport.php",
        data:{nom:nom,prenom:prenom},
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

                            
                            