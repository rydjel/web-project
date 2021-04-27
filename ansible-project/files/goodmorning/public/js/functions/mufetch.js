$(document).ready(function () {
    $('#MU').typeahead({ // 
        // #Country <> 
        source: function (query, result) {
            $.ajax({
                url:"model/ajax/searchMU.php",
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