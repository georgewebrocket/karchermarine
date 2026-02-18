<!DOCTYPE html>
<html lang="en">
<head>
   <!--jQuery-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		
    
       
    <script>
        $(function() {
            $("#objectID").load(
                "products-inc.php",
                {
                  CATEGORY_ID: "16",
                  SORT: 'title'
                },
                function(){alert("Получен ответ от сервера.")}
              );
        });
    
    </script>
    
    
</head>

<body>
    <div id="objectID"></div>
</body>
</html>

