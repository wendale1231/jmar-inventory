<?php
    include "controller/connect.php";
?>

<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
    <i class="fas fa-fw fa-archive"></i>
    <span>Inventory</span>
</a>
<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Inventory Tools:</h6>
        <a class="collapse-item" href="?p=incoming">Incoming Items</a>
        <h6 class="collapse-header">Categories:</h6>
        <?php
            $sql = "SELECT * FROM category";
            $result = mysqli_query($conn, $sql);
            while($data = $result->fetch_assoc()){
        ?>
            <a class="collapse-item cat" href="?p=inventory&cat=<?php echo $data["category_name"] ?>"><?php echo $data["category_name"] ?></a>
        <?php
            }

        ?>
        <button class="collapse-item btn btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Manage Category</button>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card p-3">
                    <h4>Add Category</h4>
                    <hr class="divider"></hr>
                    <div id="category-message"></div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="input-category" placeholder="New Category">
                    </div>
                    <button class="btn btn-primary btn-sm" id="add-cat-btn" style="display: none;">Add</button>
                </div>
                <hr class="divider"></hr>
                <div class="card p-3">
                    <h4>Manage Category</h4>
                    <hr class="divider"></hr>
                    <table class="table table-striped" id="cat-table">
                        <thead>
                            <td>ID</td>
                            <td>Name</td>
                            <td></td>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn, $sql);
                                while($data = $result->fetch_assoc()){
                            ?>
                                <tr>
                                    <td><?php echo $data["category_id"] ?></td>
                                    <td contenteditable><?php echo $data["category_name"] ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                        <button class="btn btn-success btn-sm">Update</button>
                                    </td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>
<link rel="stylesheet" href="css/sidebar.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<script>
$(document).ready(function() {
    $("#cat-table").DataTable();
});
</script>