$(document).ready(function () {


    $("#ExportToWord").on('click', function (event) {
        // $("#contenido").wordExport();
        var blob = new Blob(["Hello, world!"], { type: "text/plain;charset=utf-8" });
        FileSaver.saveAs(blob, "hello world.txt");
    });

});