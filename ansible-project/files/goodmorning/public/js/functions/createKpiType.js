function createKpiType(id1,id2)
{
    var kpiType=$("#"+id1).val();
    
    $.ajax( {
        url: "model/ajax/newKpiType.php",
        data:{kpiType:kpiType},
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

                            
                            