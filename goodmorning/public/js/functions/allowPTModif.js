function allowPTModif(id){

    $("#"+id).closest('tr').find('input,select,button').prop('disabled', false);	

}