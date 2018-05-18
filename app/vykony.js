function getUserVykony(id) {
    $("#user_id").val(id); //zapamatanie user id
    $.ajax({
        url: "../db/vykonydb.php",
        type: "post",
        data: {user_id: id},
        success: function (response) {
            try {
                let json = JSON.parse(response);
                json = JSON.parse(json);
                let mainTable = $("#tabVykonov");
                mainTable.find("tr:gt(0)").remove();
                mainTable.append(json["result"]);
                $("#priemer").html(json["priemer"]);
            } catch (e) {
                let mainTable = $("#tabVykonov");
                mainTable.find("tr:gt(0)").remove();
                $("#priemer").html("");
            }
        }
    });
}
//sortovanie tabulky vykonov
function sort(columnName) {
    let order = $("#tabOrder").val();
    let idElement =  $("#user_id");
    let id = idElement.val();
    console.log("colname " + columnName + " order " + order + " id " + id);
    $.ajax({
        url: "../db/vykonydb.php",
        type: "post",
        data: {user_id: id, columnName: columnName, order: order},
        success: function (response) {
            let mainTable = $("#tabVykonov");
            mainTable.find("tr:gt(0)").remove();
            mainTable.append(response);

            let order = $("#tabOrder");
            if(order.val() === "asc") {
                order.val("desc");
            }
            else order.val("asc");
            $("#tabColumn").val(columnName);
        }
    });
}

function createPdf() {
    let order = $("#tabOrder");
    let orderVal = order.val();
    let idElement =  $("#user_id");
    let id = idElement.val();
    if(id === undefined) {
        id = "";
    }
    if(orderVal === "asc") {
        orderVal = "desc";
    }
    else orderVal = "asc";
    let col = $("#tabColumn").val();
    window.location.href = "../scripts/create_pdf.php?col="+col+"&order="+orderVal+"&id="+id;
}