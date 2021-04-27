function createRC(id1,id2,id3,id4,id5,id6,id7)
{
    var code=$("#"+id3).val();
    var role=$("#"+id2).val();
    var grade=$("#"+id4).val();
    var region=$("#"+id1).val();
    var ratecard=$("#"+id5).val();
    var year=$("#"+id6).val();
    
    $.ajax( {
        url: "model/ajax/newRC.php",
        data:{code:code,role:role,grade:grade,region:region,ratecard:ratecard,year:year},
        method: "post",
        success: function(data) {
            $("#tbody_id").html("");
            var res=data.split(":");
            $("#"+id7).hide();
            $("#message").html(res[0]);
            //document.getElementById("tbody").innerHTML = "";
            $("#tbody_id").append(res[1]);
            $("#region").val("Tous");
            $("#select").val(res[2]);  
        }
    });
      
}
