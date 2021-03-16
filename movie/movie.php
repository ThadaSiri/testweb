<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $JsonFile = file_get_contents("movies.json")
    ?>
    <div>
        Year:<br>
        <select id="year" onchange="create_list_title()">
            <option value="N/A">N/A</option>
        </select><br>
        movie Name:<br>
        <select id="movie" onchange="create_movie_detail()">
            <option value="N/A">N/A</option>
        </select><br>
    </div>
    <script>
        var jsonEx = <?php echo $JsonFile ?>;
        var doc = document.getElementById("year");
        var ref_year = new Set();
        for(i=0;i<jsonEx.length;i++){
            ref_year.add(jsonEx[i].year);
        }
        alert("Total year = "+ ref_year.size);

        const val = ref_year.values();
        for(i=0; i<ref_year.size ;i++){
            var option = document.createElement("option");
            option.text = val.next().value;
            doc.add(option);
        }

        function create_list_title(){
            alert("Create List Start");
            var docmovie = document.getElementById("movie");
            docmovie.innerHTML = "";
            for(i=0;i<jsonEx.length;i++){
                if(jsonEx[i].year == doc.value){
                    var option = document.createElement("option");
                    option.text = jsonEx[i].title;
                    docmovie.add(option);
                }
            }
        }

        function create_movie_detail(){

        }

    </script>
</body>
</html>