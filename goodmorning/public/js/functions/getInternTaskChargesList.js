function getInternTaskChargesList(val,val2,id3,id4,id5,id6)
{  
    var task=val;
    var collab=val2;
    var year=$("#"+id3).val();
    var initMonth=$("#"+id4).val();
    var lastMonth=$("#"+id5).val();
    var lastYear=$("#"+id6).val();
    
    document.getElementById("ITaskNullChargesComment").setAttribute("name","comment-"+val+"-"+val2);

    $.ajax( {
        url: "model/ajax/getInternTaskChargesList.php",
        method: "post",
        dataType:"JSON",
        data: {task:task,collab:collab,year:year,initMonth:initMonth,lastMonth:lastMonth,lastYear:lastYear},
        success: function(data) {
            for (var index = 0; index < data.length; index++) {
                var ele = data[index];
                $("#taskIntAffMonth-"+index).html(ele);
                
            }
            //$("#"+id1).htm(data);
        }
    });
}