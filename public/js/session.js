
$.ajax({
    url: "/getCountComp",
    type: "GET",
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    dataType: "JSON",
})

.done(function (response) {
    if (response.length > 0) {
        $("#numbercomportaiment").text(response.length)
        $("#numbercomportaiment").removeClass('hide')
    }
})

.fail(function () {
    console.log("error");
});

$.ajax({
    url: "/getCountAct",
    type: "GET",
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    dataType: "JSON",
})

.done(function (response) {
    if (response.length > 0) {
        $("#numberactivities").text(response.length)
        $("#numberactivities").removeClass('hide')
    }
})

.fail(function () {
    console.log("error");
});



setInterval(function () {
    $.ajax({
        url: "/getCountComp",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length > 0) {
                $("#numbercomportaiment").text(response.length)
                $("#numbercomportaiment").removeClass('hide')
            }
        })

        .fail(function () {
            console.log("error");
        });
}, 60000);

setInterval(function () {
    $.ajax({
        url: "/getCountAct",
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dataType: "JSON",
    })

        .done(function (response) {
            if (response.length > 0) {
                $("#numberactivities").text(response.length)
                $("#numberactivities").removeClass('hide')
            }
        })

        .fail(function () {
            console.log("error");
        });
}, 60000);

$('#readNotification').on('click', function () {
    var id_n = $(this).attr('data-id');
    // alert("id: " + id_n)
    $.ajax({
        url: "/readNotification/" + id_n,
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { id: id_n },
    })

        .done(function (response) {
            if (response.length > 0) {
                $("#numberactivities").text(response.length)
                $("#numberactivities").removeClass('hide')
            }
        })

        .fail(function () {
            console.log("error");
        });
});



