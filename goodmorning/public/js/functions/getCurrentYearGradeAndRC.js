function getCurrentYearGradeAndRC(val,id1,id2,id3)
{
    //alert("click! "+id1+" "+id2);
    //var site=$("#"+id1).val();
    var siteID=$("#"+id1).val();
    //var dateEntree=$("#"+id2).val();
    /* var region=$("#"+id2).is(":checked");
    var dateDebut=$("#"+id3).val(); */ 
    $.ajax( {
        url: "model/ajax/getCurrentYearGradeAndRC.php",
        method: "post",
        dataType:'JSON',
        data: {role:val,siteID:siteID},
        success: function(data) {
            //document.getElementById(id3).innerHTML=data[0];
            //document.getElementById(id4).innerHTML=data[1];
            $("#"+id2).val(data[0]);
            $("#"+id3).val(data[1]);
        }
    });

}