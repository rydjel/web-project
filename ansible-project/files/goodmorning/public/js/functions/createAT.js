function createAT(id1,id2,id3,id4)
{
    var at=$("#"+id1).val();
    var tace=$("#"+id2).val();
    var facturable;
    if ($("#"+id3).prop("checked")) {
        facturable=1;
    }
    else{
        facturable=0;
    }
    
    $.ajax( {
        url: "model/ajax/newAT.php",
        data:{at:at,tace:tace,facturable:facturable},
        method: "post",
        success: function(data) {
            $("#tbody_id").html("");
            var res=data.split(":");
            $("#"+id4).hide();
            $("#message").html(res[0]);
            //document.getElementById("tbody").innerHTML = "";
            $("#tbody_id").append(res[1]);  
        }
    });
      
}

                            
                            