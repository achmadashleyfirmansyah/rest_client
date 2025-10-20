<?php
include("config/config.php");

// API KEY Spoonacular
$api_key = "dd151ab80819442d8cc006ae68f71933";

// fungsi ambil data
function get_recipes($url) {
    $data = http_request_get($url);
    return json_decode($data, true);
}

// ambil resep (tinggal ganti berapa angka atau resep yg mau di ambil)
$url = "https://api.spoonacular.com/recipes/random?number=50&apiKey=" . $api_key;
$hasil = get_recipes($url);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tugas Rest Client</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { transition: transform .2s; }
        .card:hover { transform: scale(1.03); }
        #loading { text-align: center; padding: 20px; display: none; }
    </style>
</head>
<body>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="#">Spoonacular Client</a>
</nav>

<div class="container" style="margin-top: 90px;">
    <div class="row" id="recipe-container">
        <?php foreach ($hasil['recipes'] as $row) { ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo $row['image']; ?>" class="card-img-top" height="200px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <a href="<?php echo $row['spoonacularSourceUrl']; ?>" target="_blank" class="btn btn-outline-info btn-sm">Lihat Resep</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div id="loading"><p>Loading more recipes...</p></div>
</div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
let loading = false;
let apiKey = "<?php echo $api_key; ?>";

// fungsi load resep baru
function loadMoreRecipes() {
    if (loading) return;
    loading = true;
    $("#loading").show();

    $.getJSON(`https://api.spoonacular.com/recipes/random?number=50&apiKey=${apiKey}`, function(result){
        if(result.recipes && result.recipes.length > 0){
            result.recipes.forEach(row => {
                let html = `
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="${row.image}" class="card-img-top" height="200px">
                        <div class="card-body">
                            <h5 class="card-title">${row.title}</h5>
                            <a href="${row.spoonacularSourceUrl}" target="_blank" class="btn btn-outline-info btn-sm">Lihat Resep</a>
                        </div>
                    </div>
                </div>`;
                $("#recipe-container").append(html);
            });
        }
        $("#loading").hide();
        loading = false;
    }).fail(function(){
        $("#loading").html("<p>Terjadi kesalahan mengambil data.</p>");
        loading = false;
    });
}

// event scroll
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        loadMoreRecipes();
    }
});
</script>

</body>
</html>
