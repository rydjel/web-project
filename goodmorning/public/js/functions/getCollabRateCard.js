function getCollabRateCard(val,id)
{
    $.ajax( {
        url: "model/ajax/getCollabRateCard.php",
        method: "post",
        data: {collab:val},
        success: function(data) {
            $("#"+id).val(data);
            //$("#"+id2).val(data/((100-50)/100));
        }
    });

}