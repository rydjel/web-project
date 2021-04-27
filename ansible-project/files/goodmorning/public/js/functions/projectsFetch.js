$(document).ready(function () {
    $('#projectCode').typeahead({ // 
        source: function (query, result) {
            $.ajax({
                url:"model/ajax/searchProjectCode.php",
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

