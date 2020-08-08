function selectAll() {
    var select_all = document.getElementById("select_all").checked;
    var check_invoices = document.getElementsByClassName("ui checkbox");
    var intLength = check_invoices.length;
    for(var i = 0; i < intLength; i++) {
        var check_invoice = check_invoices[i];
        check_invoice.checked = select_all;
    }
}

