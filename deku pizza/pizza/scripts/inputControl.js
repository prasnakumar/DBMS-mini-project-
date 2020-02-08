$(document).ready(function() {
    $("#oggetto_combo").on("change", function() {
        var id = $("#oggetto_combo").val();
        hideDescr();
        $.ajax({
            type: "POST",
            url: "../php_utils/inputControl.php",
            data: "id=" +id,
            success: function(data) {
                updateInputControls(data);
            }
        });
    })
});

function hideDescr() {
    var val = $("#categoria").val();
    if (val === "4") {
        $(".to-hide").hide('slow');
    }
    else {
        $(".to-hide").show('slow');
    }
}

//nome_prezzo_descrizione
function updateInputControls(data) {
    var fields = data.split("_");
    $("#nome").val(fields[0]);
    $("#prezzo").val(fields[1]);
    if(fields.length === 3) {
        $("#descr").text(fields[2]);
    }
}
