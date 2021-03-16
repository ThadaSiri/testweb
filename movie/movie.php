<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php $JsonFile = file_get_contents("movies.json"); ?>
    <div>
        Year:<br>
        <select id="year">
        </select><br>
        movie Name:<br>
        <select id="movie">
        </select><br>
    </div>
    <script>
        var jsonEx = <?php echo $jsonfile ?>;
        doc = document.getElementById("movie");
        for(i=0;i<jsonEx.length;i++){
            var option = document.createElement("option");
            option.text = jsonEx[i].title;
            doc.add(option);
        }
    </script>
</body>
</html>