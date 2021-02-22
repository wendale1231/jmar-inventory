<?php
    include "../controller/connect.php";
    session_start();
    $result;
    if($_POST["cat"] != "all"){
        $cat = $_POST["cat"];
        $sql = "SELECT * FROM items 
        INNER JOIN
        category ON category.category_id = items.category_id
        WHERE
            category.category_name = '$cat'
        ";
        $result = mysqli_query($conn, $sql);
    }else{
        $sql = "SELECT * FROM items 
        INNER JOIN
        category ON category.category_id = items.category_id
        ";
        $result = mysqli_query($conn, $sql);
    }
    while($data = $result->fetch_assoc()){
        if($data["sell_in_wholesale"] == "false")  $data["item_unit_divisor"] = "1";
        if($data["sell_in_wholesale"] == "false")  $data["item_tax_wholesale"] = "1";
        $r_price = (floatval(($data["item_tax"]) / 100) * floatval($data["item_price"])) + floatval($data["item_price"]);
        $w_price = (floatval(($data["item_tax_wholesale"]) / 100) * floatval($data["item_price"])) + floatval($data["item_price_wholesale"]);
        $u1 = intval($data["item_stock_warehouse"] / $data["item_unit_divisor"]);
        $u2 =  floatval($data["item_stock"] - ($u1 * $data["item_unit_divisor"]));
        if($u1 <= 2 && $u1 != 0) $color = "warning";
        else if($u1 == 0 && $u2 == 0) $color = "danger";
        else $color = "success";
        $u2_name = "";
        if($data["item_unit"] == "Box") $u2_name = "pieces";
        else if($data["item_unit"] == "Roll") $u2_name = "meter(s)";
        else if($data["item_unit"] == "Sack") $u2_name = "kilo(s)";
?>
<tr>
    <td>
        <img id="img<?php echo $data["item_id"]?>" src="img/item/<?php echo ($data["item_img"] == "") ? "item.jpg" : $data["item_img"]; ?>" alt="" width="200" >
    </td>
    <td>
        <div class="p-2">
            <div class="d-flex p-2"><b>ID:&nbsp;</b><p><?php echo $data["item_id"]?></p></div>
            <div class="d-flex p-2"><b>Name:&nbsp;</b><p id="name<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_name"]?></p></div>
            <div class="d-flex p-2"><b>Brand:&nbsp;</b><p id="brand<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_brand"]?></p></div>
            <div class="d-flex p-2"><b>Description:&nbsp;</b><p id="desc<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_desc"]?></p></div>
            <div class="d-flex p-2">
                <b>Category:&nbsp;</b>
                <p style="width: 1px">
                    <div class="form-group">
                        <select class="form-control" style="width: 200px" id="category<?php echo $data["item_id"]?>">
                        <?php
                            $sql1 = "SELECT * FROM category";
                            $result1 = mysqli_query($conn, $sql1);
                            while($data1 = $result1->fetch_assoc()){
                        ?>
                            <option value="<?php echo $data1["category_id"]; ?>" <?php if($data1["category_id"] == $data["category_id"]) echo "selected"; ?>><?php echo $data1["category_name"] ?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>

                </p>
                <?php if($_SESSION["user"]["role"] == "admin" && $data["sell_in_wholesale"] == "false") {?>
                    <b class="float-left">Capital:&nbsp;₱&nbsp;</b><p id="capital_w<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_price_wholesale"]?></p>
                <?php } ?>
            </div>

            <hr>
            <div class="d-flex p-2">
                <b>Store Stock:&nbsp;</b>
                    <p class="text-<?php echo $color; ?>">
                    <?php echo $data["item_stock"] . " " . $u2_name ?>
                    </p>
                <b>Warehouse Stock:&nbsp;</b>
                    <p class="text-<?php echo $color; ?>">
                        <?php echo $u1 . " " . $data["item_unit"] ?>
                    </p>
            </div>
            <hr>
        </div>
    </td>
    <td>
        <div class="p-2" style="width: 200px">
            <center><h5><b>RETAIL</b></h5></center>
            <?php
                if($_SESSION["user"]["role"] == "admin"){ 
            ?>
            <div class="d-flex p-2"><b>Capital:&nbsp;₱</b><p id="capital<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_price"]?></p></div>
            <div class="d-flex p-2"><b>Revenue&nbsp;</b><p id="tax<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_tax"]?></p>%</div>
            <?php 
                }
            ?>
            <div class="d-flex p-2"><b>Price:&nbsp;₱<?php echo $r_price?></b></div>
            <hr class="sidebar-divider">
            <?php if($data["sell_in_wholesale"] == "true"){ ?>
            <center><h5><b>WHOLESALE</b></h5></center>
            <?php
                if($_SESSION["user"]["role"] == "admin"){ 
            ?>
            <div class="d-flex p-2"><b>Capital:&nbsp;₱</b><p id="capital_w<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_price_wholesale"]?></p></div>
            <div class="d-flex p-2"><b>Revenue:&nbsp;</b><p id="tax_w<?php echo $data["item_id"]?>" class="edit" contenteditable><?php echo $data["item_tax_wholesale"]?></p>%</div>
            <?php 
                }
            ?>
            <div class="d-flex p-2"><b>Price:&nbsp;₱<?php echo $w_price?></b></div>
            <?php }?>
        </div>
    </td>
    <td>
        <div class="col p-2">
            <button class="btn btn-danger delete m-1" style="width: 100%" data-target="#logoutModal" data-toggle="modal" value="<?php echo $data["item_id"]; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
            <button class="btn btn-success update m-1" style="width: 100%" value="<?php echo $data["item_id"]; ?>"><i class="fa fa-refresh" aria-hidden="true"></i> Update</button>
        </div>
    </td>
</tr>
<?php
    }

?>
