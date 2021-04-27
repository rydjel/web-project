function DTUpdateValidation(id1,id2,id3)
{
    //alert("click! "+id1+" "+id2);
    var task=$("#"+id1).val();
    var activityT=$("#"+id2).val();
    
    $.ajax( {
        url: "model/ajax/updateDT.php",
        method: "post",
        data: {task:task,activityT:activityT,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id3).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id3).prop('disabled', true); 
            }
        }
    });
    window.scrollTo(0, 0);
}