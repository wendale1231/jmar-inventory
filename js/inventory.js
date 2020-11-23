$(document).on("click", ".open-details", function() {
    // Add this later
    var $t = $(this);
    $(".item-data").remove();
    $(".details-toggle").html('<i class="fa fa-plus-circle" aria-hidden="true"></i>');
    $(".details-toggle").addClass("open-details");
    $(".details-toggle").removeClass("close-details");
    $t.html('<i class="fa fa-minus-circle" aria-hidden="true"></i>');
    $t.addClass("close-details");
    $t.removeClass("open-details");
    $.ajax({
        url: url(window.location.href) + "/includes/item-details.php",
        method: "POST",
        data: {
            "id": $(this).children().first().text()
        },
        success: function(data) {
            var el = $(data);
            $t.parent().children(".child").hide();
            $t.parent().parent().after(el);
            el.show("slow");
        }
    });
});

$(document).on("click", ".close-details", function() {
    $(".item-data").remove();
    $(this).html('<i class="fa fa-plus-circle" aria-hidden="true"></i>');
    $(this).addClass("open-details");
    $(this).removeClass("close-details");
});
var $t;
var $t_id;
$(document).ready(function() {
    $t = $('#example').DataTable({
        // responsive: true,
        // "scrollX": true,
        // columnDefs: [
        //     { responsivePriority: 1, targets: 0 },
        //     { responsivePriority: 2, targets: 1 },
        //     { responsivePriority: 3, targets: 2 },
        //     { responsivePriority: 4, targets: 3 }
        // ]
    });
    $("div.toolbar").append($('#stock-filter'));
});
$(document).on("click", "#confirm-delete", function() {
    var $id = $(this).val();
    $.ajax({
        url: url(window.location.href) + "/controller/delete-item.php",
        method: "POST",
        data: {
            submit: "submit",
            item_id: $id,
        },
        success: function(d) {
            var data = JSON.parse(d);
            $t.row($t_id).remove().draw();
            $("#example").find("$row_" + $t_id).remove();
            $(".alert").addClass("alert" + data.status);
            $(".alert").text(data.message);
            $(".alert").fadeTo(3000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        }
    });

});
$(document).on("click", ".delete", function() {
    var $id = $(this).val();
    $t_id = $(this).parent().parent().parent().parent();
    console.log($t_id);
    $('.alert').alert('show');
    $("#exampleModalLabel").text("Please Confirm Item Delete");
    $(".modal-body").html(
        '<b>Item Name:</b> ' + $("#name" + $id).val() + "</br>" +
        '<b>Item Brand:</b> ' + $("#brand" + $id).val() + "</br>" +
        '<b>Description:</b> ' + $("#desc" + $id).val() + "</br>"
    );
    $(".modal-footer").html(
        '<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>' +
        '<button class="btn btn-primary" value="' + $id + '" data-dismiss="modal" id="confirm-delete" >Delete</button>'
    );

});
$(document).on("click", ".update", function() {
    $('.toast').toast('show');
    var $id = $(this).val();
    console.log($id);
    $.ajax({
        url: url(window.location.href) + "/controller/edit-item.php",
        method: "POST",
        data: {
            submit: "submit",
            item_id: $id,
            item_capital: $("#capital" + $id).val(),
            item_name: $("#name" + $id).val(),
            item_brand: $("#brand" + $id).val(),
            item_tax: $("#tax" + $id).val(),
            item_desc: $("#desc" + $id).val(),
            item_category: $("#cat" + $id).val(),
            item_unit: $("#unit" + $id).val(),
        },
        success: function(d) {
            var data = JSON.parse(d);
            $(".alert").addClass("alert" + data.status);
            $(".alert").text(data.message);
            $(".alert").fadeTo(3000, 500).slideUp(500, function() {
                $(".alert").slideUp(500);
            });
        }
    });
});


$(document).on('change', '.custom-file-input', function(e) {
    var filename = $('input[type=file]').val().split('\\').pop();
    $(".custom-file-label").text(filename);
})

function calculate() {
    var price = parseFloat($("#input-capital").val());
    var tax = parseFloat($("#input-tax").val());
    var total = ((tax / 100) * price) + price;
    console.log(total + " " + price + " " + tax);
    $("#total-item-price").val(total);
}
$(document).on("input", "#input-capital", function() {
    calculate();
});
$(document).on("input", "#input-tax", function() {
    calculate();
});