function getContrib(val,id1,id2) {

    var rateCard=$("#"+id1).val();

    if (val===0) {
        $("#"+id2).val(0);
    }
    else if(rateCard!=="" && val!==""){
        $("#"+id2).val(((val-rateCard)/val*100).toFixed(2));
    }
    
}