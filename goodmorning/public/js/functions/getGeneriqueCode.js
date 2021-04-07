function getGeneriqueCode(val,id)
{
    // Check the value transmitted
    if (val=='Activité Interne') {
        $("#"+id).prop("checked",true);
    }
    else{
        $("#"+id).prop("checked",false);
    }

}