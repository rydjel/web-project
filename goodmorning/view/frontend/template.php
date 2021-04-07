<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
        <script href="public/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
        
        <link href="public/css/bootstrap.css" rel="stylesheet"/>
        <!-- <link href="public/css/bootstrap.min.css" rel="stylesheet"/> -->
        
        <link href="public/css/screens/welcomeView.css" rel="stylesheet"/>
        <link href="public/css/screens/inputNumbers.css" rel="stylesheet"/>
        
        <script src="public/js/functions/closeAlert.js"></script>
        <script src="public/js/functions/newselection.js"></script>
        <script src="public/js/functions/getElement.js"></script>
        <!-- <script src="public/js/functions/clientCreation.js"></script> -->
    
    </head>
        
    <body>
        <?= $content ?>
    </body>
</html>
