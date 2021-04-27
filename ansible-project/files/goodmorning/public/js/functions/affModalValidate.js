function affModalValidate(id1,id2)
{
    var affDetails=$("#"+id1).val();
    var codeProjet=$("#codeProjet").val();
    
    $.ajax( {
        url: "model/ajax/affModalValidate.php",
        method: "post",
        data: {affDetails:affDetails,codeProjet:codeProjet},
        success: function(data) {
            $('#'+id2).hide();
            var res=data.split(":");
            //location.reload(true);
            $("#message").html(res[0]);
            $("#tbody").html("");
            $("#tbody").append(res[1]);
            //$("#tableTaskAffModif").load(window.location + "#tableTaskAffModif");
            //$("#tbody").ajax.reload();
            //$("#tableAffCreateModify").load("#tableAffCreateModify");
        }
    });

}