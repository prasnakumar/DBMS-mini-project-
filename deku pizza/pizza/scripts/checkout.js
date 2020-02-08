/*$(document).ready(function() {
    $(".cart-item-quantity").on("change", function() {
        var cartCount = parseInt($("#cart-items-count").text());
        var id = $(this).attr("id").slice(4);
        var ppu = parseFloat($("#price-per-unit-"+id).text());

        var newqty = parseInt($("#"+$(this).attr("id")).val());

        $("#pricetag-"+id).text(ppu * newqty);
    });

});
*/
$(document).ready(function() {
    recalcTotal();
    var prev = new Array();
    for (var i = 0; i < parseInt($("#cart-rows").val()); i++) {
        prev[i] = parseInt($("#qta-"+i).val());
    }
    $(".cart-item-quantity").change(function() {
        var cartCount = parseInt($("#cart-items-count").text());


        //trovo id della riga che ha lanciato l'evento
        var id = $(this).attr("id").slice(4);
        //trovo prezzo unitario della riga
        var ppu = parseFloat($("#price-per-unit-"+id).text());

        //trovo la nuova quantita nell'input
        var newqty = parseInt($("#"+$(this).attr("id")).val());
        //ricalcolo totale riga
        $("#pricetag-"+id).text(ppu * newqty);

        //ricalcolo prezzo totale carrello
        recalcTotal();

        //aggiorno numero elementi nel carrello
        $("#cart-items-count").text(cartCount - prev[id] + newqty);
        prev[id] = newqty;

    });

    $(".del-icon").on("click", function() {
        var r = confirm("Do You really want to delete this item from the cart?");
        if(r == true) {
            var id = $(this).attr("id").slice(4);
            recalcQty(parseInt($("#qta-"+id.slice(4)).val()));
            /*$("#"+id).hide(300, function() {
                $("#"+id).remove();
            });*/
            $("#"+id).hide('slow').promise().done(function() {
                updateCartDB(id.slice(4));
                $("#"+id).remove();
                recalcTotal();
            });
        }
    });

    $("#empty-cart").on("click", function(e) {
        if(!confirm("Do you really want to empty the cart?")) {
            e.preventDefault();
        };
    })
});

function recalcTotal() {
    var pricetags = $(".pricetag");
    var totalPerRow = 0;
    for (var i = 0; i < pricetags.length; i++) {
        totalPerRow += parseFloat(pricetags[i].innerHTML);
    }

    $("#total").text(totalPerRow);
}

function recalcQty(toSub) {
    var cartCount = parseInt($("#cart-items-count").text());
    $("#cart-items-count").text(cartCount - toSub);
}

function updateCartDB(row_id) {
    var email = $("#cart-field").val();
    var id_prod = $("#id-prod-row-"+row_id).val();
    $.ajax({
        type: "POST",
        url: "../php_utils/cartDelete.php",
        data: "email=" +email+ "&id=" +id_prod,
        success: function(data) {
            
        }
    });
}
