function getTaskActivity(val,id1,id2,id3)
{ 
    $.ajax( {
        url: "model/ajax/getTaskActivity.php",
        method: "post",
        dataType:'JSON',
        data: {task:val},
        success: function(data) {
            $("#"+id1).val(data[0]);
            $("#"+id2).val(data[1]);
            if (data[2]==1) {
                $("#"+id3).prop("checked",true);
            }
            else{
                $("#"+id3).prop("checked",false); 
            }
        }
    });

}