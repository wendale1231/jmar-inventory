<?php
    include "controller/connect.php";
?>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
<link rel="stylesheet" href="css/incoming.css">
<div class="inventory-head d-flex mb-3">
    <h1 class="h3 mb-0 text-gray-800">Incoming</h1>
    <div class="ml-auto p-2">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".add-item-modal" id="add-item">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Add Item
        </button>
    </div>
</div>
<div class="alert alert-success" role="alert" style="display: none">
  This is a success alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="d-flex">
    <div class="shadow mb-4 p-3">
        <table id="example"  class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Capital</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Capital</th>
                    <th>Stock</th>
                </tr>
            </tfoot>
            <tbody id="item_data">
                <?php include "incoming-get-items.php"; ?>
            </tbody>
        </table>		
    </div>
    <div class="shadow m-1 p-3" style="max-width: 400px; min-width: 400px">
        <h4 id="transaction" >Incoming Transaction</h4>
        <div class="alert alert-success" id="trans-message" role="alert" style="display: none">
        </div>
        <div class="overflow-auto" style="min-height: 600px; max-heigth: 600px" id="items">
        </div>
        <div class="mt-2">
            <div class="d-flex"><b>Total Items:&nbsp;</b><p id="total_items">0</p></div>
            <div class="d-flex"><b>Total:&nbsp;</b>₱ <p id="total">0</p></div>
            <button class="submit-transaction btn btn-primary" style="display: none; min-width: 100%">Submit</button>
        </div>
    </div>
</div>
<?php include "new-item-modal.php"; ?>
<script src="js/incoming.js"></script>