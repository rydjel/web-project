function enableDisableYear(id1,id2)
{
    // Check the value transmitted
    if (document.getElementById(id1).checked==true) {
        $("#"+id2).prop("disabled",false);
    }
    else{
        $("#"+id2).prop("disabled",true);
    }

}