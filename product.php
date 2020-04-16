<?php
require_once 'header.php';

$id = htmlspecialchars($_GET['id']);
$url = "http://localhost/Webbshoppen/api.php";


$json = file_get_contents($url);
$jsonArr = json_decode($json, true);

$product = '';
for($i=0; $i < count($jsonArr); $i++) {

    if($jsonArr[$i]['id'] == $id){
        $product = $jsonArr[$i];
    }
}

    $id = $product['id'];
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $stock = $product['stock'];
    $img = $product['images'];
 
$productContainer = "<main><section><div class='imgContainer'>";

foreach ($img as $key => $value) {
    $productContainer .= "<div>
                            <img src='$value' alt='Produkt bild'>
                        </div>";
}
$productContainer .= '</div>';

$productContainer .= "<article>
                        <h1 id='product'>$name</h1>
                        <p id='desc'>$description</p>
                        <p id='price'>$price Kr</p>
                        <br>
                        <p>$stock st finns i lager</p>
                        <br>
                        <input type='num' id='quantityInput'>
                        <button id='addBtn' type='submit'>Lägg till i varukorg</button>
                        <input type='hidden' id='id' value='$id'>
                    </article>
                </section>
            </main>";    

echo $productContainer;
require_once 'footer.php';
?>

<script src="cartfunc.js" type="module"></script>