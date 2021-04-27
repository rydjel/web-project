function getNIProjectTaskList(val,id1,val2,id3,id4,id5,id6)
{ 
   /*var project=$("#"+id1).val();
   var collab=$("#"+id2).val();*/

    var year=$("#"+id3).val();
    var initMonth=$("#"+id4).val();
    var lastMonth=$("#"+id5).val();
    var lastYear=$("#"+id6).val();
    
    $.ajax( {
        url: "model/ajax/getNIProjectTaskList.php",
        method: "post",
        data: {project:val,collab:val2,year:year,initMonth:initMonth,lastMonth:lastMonth,lastYear:lastYear},
        success: function(data) {
            $("#"+id1).html(data);
        }
    });

}