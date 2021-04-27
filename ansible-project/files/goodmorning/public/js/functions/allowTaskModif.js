function allowTaskModif(id1,id2){

    $("#"+id1).closest('tr').find('select,button').prop('disabled', false);	
    $("#"+id2).prop('disabled', false);	
}