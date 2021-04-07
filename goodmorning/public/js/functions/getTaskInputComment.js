function getTaskInputComment(val1,val2,id)
{

    $.ajax( {
        url: "model/ajax/getTaskInputComment.php",
        method: "post",
        data: {task:val1,collab:val2},
        success: function(data) {
            $("#"+id).val(data);
        }
    });

}