// Function returning the element dependant on a value of an input/select field
function getElement(val,id,location) {
     $.ajax({
    type: "POST",
    // url: "model/ajax/getClientMarketUnit.php",
    url:location,
    dataType:"json",
    data:{field:val},
    success: function(data){
      $("#"+id).prop('checked',data=='1');
      //$("#"+id).prop('unchecked',data=='0');
      $("#"+id).val(data);
   
    }
    }); 
  }