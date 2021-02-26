<?php
    include "controller/connect.php";
    $sql = "SELECT * FROM items 
    INNER JOIN
    category ON category.category_id = items.category_id
    ";
    $result = mysqli_query($conn, $sql);
    while($data = $result->fetch_assoc()){
        if($data["sell_in_wholesale"] == "false")  $data["item_unit_divisor"] = "1";
        if($data["sell_in_wholesale"] == "false")  $data["item_tax_wholesale"] = "1";
        $r_price = (floatval(($data["item_tax"]) / 100) * floatval($data["item_price"])) + floatval($data["item_price"]);
        $w_price = (floatval(($data["item_tax_wholesale"]) / 100) * floatval($data["item_price"])) + floatval($data["item_price_wholesale"]);
        $u1 = intval($data["item_stock"] / $data["item_unit_divisor"]);
        $u2 =  floatval($data["item_stock"] - ($u1 * $data["item_unit_divisor"]));
        $u2_name = "";
        if($data["item_unit"] == "Box") $u2_name = "pieces";
        else if($data["item_unit"] == "Roll") $u2_name = "meter(s)";
        else if($data["item_unit"] == "Sack") $u2_name = "kilo(s)";
?>
<tr>
    <td>
        <img src="img/item/<?php echo $data["item_img"] ?>" alt="" width="100" >
    </td>
    <td>
        <p><b>ID: </b><?php echo $data["item_id"];?></p>
        <p><b>Name: </b><?php echo $data["item_name"];?></p>
        <p><b>Brand: </b><?php echo $data["item_brand"];?></p>
        <p><b>Category: </b><?php echo $data["category_name"];?></p>
        <p><b>Description: </b><?php echo $data["item_desc"];?></p>
    </td>
    <td width="200px">
        <?php
            if($data["item_stock"] > 0){
        ?>
        <div class="d-flex mb-2">
            <input type="text" class="form-control border-success" id="stock_<?php echo $data["item_id"] ?>" value="<?php echo $data["item_stock"] ?>" readonly>
            <b class="p-2">Total <?php echo $u2_name ?></b>
        </div>
        <div class="d-flex" id="count_input_<?php echo $data["item_id"] ?>">
            <input min="1" max="<?php echo $data["item_stock"]; ?>" type="number" id="item_<?php echo $data["item_id"] ?>" class="form-control" value="1">
            <select id="unit_<?php echo $data["item_id"] ?>" class="custom-select unit-select">
                <option name="<?php echo $data["item_unit"] ?>" value="<?php echo $u1; ?>"><?php echo $data["item_unit"] ?></option>
            </select>
            <button class="add btn btn-success" value="<?php echo $data["item_id"] ?>"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </div>
        <?php
            }else{
        ?>
        <div class="d-flex mb-2">
            <input type="text" class="form-control is-invalid mb-2" value="Out Of Stock" readonly>
        </div>
        <?php
            }
        ?>
        <div class="alert alert-success" role="alert" style="display: none">
            Item Added!
        </div>
    </td>
</tr>
<?php
    }

?>