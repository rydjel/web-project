$(document).ready(function () {
    $('#PU').typeahead({ // 
        // #Country <> 
        source: function (query, result) {
            $.ajax({
                url:"model/ajax/searchPU.php",
                data:{query:query},            
                dataType:"json",
                type:"POST",
                success: function (data) {
                    result($.map(data, function (item) {
                        return item;
                    }));
                }
            });
        }
        });
    });