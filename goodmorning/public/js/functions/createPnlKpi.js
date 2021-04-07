function createPnlKpi(id1,id2,id3,id4,id5)
{
    var idkpiType=$("#"+id1).val();
    var idMonth=$("#"+id2).val();
    var budget=$("#"+id3).val();
    var forecast=$("#"+id4).val();

    $.ajax( {
        url: "model/ajax/newPnlKpi.php",
        data:{idkpiType:idkpiType,idMonth:idMonth,budget:budget,forecast:forecast},
        method: "post",
        success: function(data) {
            $("#tbody_id").html("");
            var res=data.split(":");
            $("#"+id5).hide();
            $("#message").html(res[0]);
            //document.getElementById("tbody").innerHTML = "";
            $("#tbody_id").append(res[1]);  
        }
    });
      
}

                            
                            