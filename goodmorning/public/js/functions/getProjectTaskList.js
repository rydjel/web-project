function getProjectTaskList(val,id1,val2,id2,id3,id4,id5)
{
    var initYear=$("#"+id2).val();
    var initMonth=$("#"+id3).val();
    var lastMonth=$("#"+id4).val();
    var lastYear=$("#"+id5).val();

    $.ajax( {
        url: "model/ajax/getProjectTaskList.php",
        method: "post",
        data: {project:val,collab:val2,initYear:initYear,initMonth:initMonth,lastMonth:lastMonth,lastYear:lastYear},
        success: function(data) {
            $("#"+id1).html(data);
        }
    });

}