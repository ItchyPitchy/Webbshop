<?php

require_once "db.php";

$output = "";
$arr = [];

if (isset($_GET["q"])) {

    $q = trim(htmlspecialchars($_GET["q"]));

    if (mb_strlen($q) >= 2 && mb_strlen($q) <= 50) {
        $sql1 = "SELECT id, name, price
                FROM products
                WHERE name LIKE CONCAT('%', :q, '%')";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam(":q", $q);
        $stmt1->execute();

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)):

            $sql2 = "SELECT image FROM product_images WHERE product_id = :id";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(":id", $row["id"]);
            $stmt2->execute();
            $image = $stmt2->rowCount() ? $stmt2->fetch(PDO::FETCH_ASSOC)["image"] : "";

            $arr[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "price" => $row["price"],
                "image" => $image
            );

        endwhile;

        foreach ($arr as $value) {
            $output .= 
            "<ul class='product-ul'>
                <a href='product.php?id=$value[id]' class='product-link'>
                    <li class='product-li'><img class='search-img' src=./images/" . $value["image"] . "></li>
                    <li class='product-li product-li-name'><h3 class='title'>$value[name]</h3></li>
                    <li class='product-li product-li-price'>$value[price]kr</li>
                </a>
            </ul>";
        }
    } else {
        $output = "<h2>Fel: Sökordet måste innehålla mellan 2-20 tecken</h2>";
    }
}

require_once "header.php";

?>

<h1 class="startpageHeading">Du fick <?php echo count($arr); ?> träffar för "<?php echo $q; ?>":</h1>
<main class="productContainer">
    <?php echo $output; ?>
</main>

<?php require_once "footer.php"; ?>