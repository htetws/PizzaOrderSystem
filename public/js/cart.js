$(document).ready(() => {
    $(".btn-plus").click(function () {
        parentChild($(this));
        totalSummary();
    });

    //minus btn
    $(".btn-minus").click(function (event) {
        parentChild($(this));
        totalSummary();
    });

    // callback functions
    function parentChild(This) {
        $parentNode = This.parents("tr");
        $price = $parentNode.find("#pricePizza").val();
        $qty = $parentNode.find("#qty").val();

        $parentNode.find("#total").text($price * $qty + " kyats");
    }

    function totalSummary() {
        $total = 0;
        $("tr").each(function (index, row) {
            $total += Number($(row).find("#total").text().replace("kyats", ""));
        });

        $("#subTotal").text(`${$total} kyats`);
        $("#finalPrice").text(`${$total + 3000} kyats`);
    }
});
