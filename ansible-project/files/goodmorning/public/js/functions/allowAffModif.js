function allowAffModif(id){

    $("#"+id).closest('tr').find('input,select,button').prop('disabled', false);	

}