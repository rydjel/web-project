function allowMUModif(id){

    $("#"+id).closest('tr').find('input,select,button').prop('disabled', false);	

}