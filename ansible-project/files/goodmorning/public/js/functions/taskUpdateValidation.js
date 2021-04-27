function taskUpdateValidation(id1,id2,id3,id4,id5)
{
    var taskName=$("#"+id1).val();
    var typeActivity=$("#"+id2).val();
    var tace=$("#"+id3).val();
    var facturable=document.getElementById(id4).checked;
    
    $.ajax( {
        url: "model/ajax/updateTask.php",
        method: "post",
        data: {taskName:taskName,typeActivity:typeActivity,tace:tace,facturable:facturable,idtaskExtend:id1,idActivityExtend:id2},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            //$("#message").html(data);
            if (res[0]=="OK") {
                $("#"+id5).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id5).prop('disabled', true); 
            }
        }
    });
   /*  $("#"+id5).closest('tr').find('input,select').prop('disabled', true);
    $("#"+id5).prop('disabled', true); */
    window.scrollTo(0, 0);
}