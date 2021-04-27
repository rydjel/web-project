function JOCollabUpdateValidation(id1,id2)
{
    //alert("click! "+id1+" "+id2);
    var joCollab=$("#"+id1).val();
    
    $.ajax( {
        url: "model/ajax/updateJOCollab.php",
        method: "post",
        data: {JOCollab:joCollab,idExtend:id1},
        success: function(data) {
            $("#message").html(data);
            $("#"+id1).prop('disabled', true);
            $("#"+id2).prop('disabled', true);
        }
    });
    window.scrollTo(0, 0);

}