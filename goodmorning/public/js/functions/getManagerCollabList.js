function getManagerCollabList(val,id)
{
    var inOut='in' // var to explicite if the checkbox is checked or not

    if ($("#"+id).prop("checked")==true) {
        inOut='out'
    } 

    $.ajax( {
        url: "model/ajax/getManagerCollabList.php",
        method: "post",
        data: {idManager:val,inOut:inOut},
        success: function(data) {
            $("#collabCharges").html("");
            $("#collab").html(data);
        }
    });

}