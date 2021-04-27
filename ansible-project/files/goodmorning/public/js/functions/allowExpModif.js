function allowExpModif(id){

    $("#"+id).closest('tr').find('input,select,button,textarea').prop('disabled', false);	

}