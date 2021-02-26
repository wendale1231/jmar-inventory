//update this then minify
function calculate_retail() {
    var capital = $("#input-capital-wholesale").val();
    var revenue = $("#input-tax").val();
    var total = 0;
    total = math.add(capital, math.multiply(math.divide(revenue, 100), capital)).toFixed(2);
    console.log(total);
    $("#input-capital").val(total);
}
$(function() {
    $('[data-toggle="tooltip"]').tooltip(
        {
            container: "body"
         }
    );
});

function validateForm() {
    console.log("checking..");
    $("form#add-item-form :input").each(function() {
        var data = $(this).val();
        console.log(data);
        if (data == '') {
            $(this).addClass("border,border-danger");
            return false
        }
    });
    return true;
}
$("form#add-item-form").submit(function(e) {
    e.preventDefault();
    if (validateForm()) {
        $('#add-item-modal').modal('toggle');
        var formData = new FormData(this);
        formData.set("submit", "submit");
        $.ajax({
            url: url(window.location.href) + "/controller/add-item.php",
            method: "POST",
            data: formData,
            success: function(d) {
                var data = JSON.parse(d);
                console.log(d);
                $(".alert").addClass("alert" + data.status);
                $(".alert").html(data.message);
                $(".alert").fadeTo(3000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                });
                $('#add-item-form')[0].reset();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
$('#image-file').change(function() {
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#item-image-selected').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#item-image-selected').attr('src', '/img/item.jpg');
    }
});
$(document).on("change", "#item-unit", function() {
    var $unit = $(this).val();
    $("#u1-selected").text($unit);
});
$(document).on("input", "#u1-val,#u2-val,#divisor", function() {
    var u1 = $("#u1-val").val();
    var u2 = $("#u2-val").val();
    var divisor = $("#divisor").val();
    var total = (u1 * divisor) + Number(u2);
    $("#item_stock").val(total);
});
$("#show_per_unit").change(function(){
    if($(this).is(":checked")){
        $("#per_unit").slideDown(500);
    }else{
        $("#per_unit").slideUp(500);
    }
});
$(document).on("input", "#input-capital-wholesale", function() {
    calculate_retail();
});
$(document).on("input", "#input-tax", function() {
    calculate_retail();
});
$("#manual-input").change(function() {
    if ($(this).is(':checked')) {
        $(this).parent().parent().prev().children().last().attr("readonly", false);
    } else {
        $(this).parent().parent().prev().children().last().attr("readonly", true);
        $("#input-capital").val(($("#input-capital-wholesale").val() / $("#divisor").val()).toFixed(2));
    }
});
$(document).ready(function() {
    $("#item-quantity").click(function() {
        if ($(this).is(':checked')) {
            $("#quantity-per-package").slideDown(500);
            $("#q1-name").slideDown(500);
            $("#u1-selected").text($("#item-unit").val());
            $("#no_qpp").addClass("move-up");
            $("#rev").addClass("move-down");
        } else {
            $("#quantity-per-package").slideUp(500);
            $("#q1-name").slideUp(500);
            $("#no_qpp").removeClass("move-up");
            $("#rev").removeClass("move-down");
        }
    });
});
