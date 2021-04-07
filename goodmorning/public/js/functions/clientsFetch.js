$(document).ready(function () {
    $('#client').typeahead({ // 
        // #Country <> 
        source: function (query, result) {
            $.ajax({
                url:"model/ajax/searchClient.php",
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