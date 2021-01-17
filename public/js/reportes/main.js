$(document).ready(function () {

    alert('js');
    function openWindowWithPostRequest(url, params) {
        var winName = 'reporte';
        var winURL = url;
        // var windowoption = 'resizable=yes,height=1000,width=800,location=0,menubar=0,scrollbars=1';

        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", winURL);
        form.setAttribute("target", winName);
        for (var i in params) {
            if (params.hasOwnProperty(i)) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = i;
                input.value = params[i];
                form.appendChild(input);
            }
        }

        let csrfField = document.createElement('input');
        csrfField.setAttribute('type', 'hidden');
        csrfField.setAttribute('name', '_token');
        csrfField.setAttribute('value', $('meta[name="csrf-token"]').attr('content'));
        form.appendChild(csrfField);

        document.body.appendChild(form);
        window.open('', winName);
        form.target = winName;
        form.submit();
        document.body.removeChild(form);
    }

    $('#create_pdf').on('click', function () {
        openWindowWithPostRequest('/make_pdf', $('#testing').html());
    });

    google.charts.load('current', {
        'packages': ['corechart']
    });


    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Gender', 'Number'],
            ['M', 6],
            ['F', 3]
        ]);

        var options = {
            title: 'Percentage of Male and Female Employee',
            pieHole: 0.4,
            chartArea: {
                left: 100,
                top: 70,
                width: '100%',
                height: '80%'
            }
        };
        var chart_area = document.getElementById('piechart');
        var chart = new google.visualization.PieChart(chart_area);

        google.visualization.events.addListener(chart, 'ready', function () {
            chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
        });
        chart.draw(data, options);
    }

});