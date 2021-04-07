function PTUpdateValidation(id1,id2)
{
    //alert("click! "+id1+" "+id2);
    var PT=$("#"+id1).val();
    /* var region=$("#"+id2).is(":checked");
    var dateDebut=$("#"+id3).val(); */ 
    $.ajax( {
        url: "model/ajax/updatePT.php",
        method: "post",
        data: {PT:PT,idExtend:id1},
        success: function(data) {
            var res=data.split(":");
            $("#message").html(res[1]);
            if (res[0]=="OK") {
                $("#"+id2).closest('tr').find('input,select').prop('disabled', true);
                $("#"+id2).prop('disabled', true);
            }
        }
    });
    window.scrollTo(0, 0);
}