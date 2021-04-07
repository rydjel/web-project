function taskCreation()
{
    $.ajax( {
        url: "model/ajax/newTask.php",
        success: function(data) {
            $("#tbody").append(data);
            $("#newTask").prop('disabled',true);  
        }
    });
      
}

                            
                            