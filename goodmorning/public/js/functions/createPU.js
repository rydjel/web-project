function createPU(id1,id2,id3,id4,id5)
{
    var pu=$("#"+id1).val();
    var region;
    if ($("#"+id2).prop("checked")) {
        region=1;
    }
    else{
        region=0;
    }
    if ($("#"+id4).prop("checked")) {
        mu=1;
    }
    else{
        mu=0;
    }
    var entite=$("#"+id5).val();
    //var region=$("#"+id2).val();
    $.ajax( {
        url: "model/ajax/newPU.php",
        data:{pu:pu,region:region,mu:mu,entite:entite},
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

                            
                            