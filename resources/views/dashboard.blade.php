<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('css/bootstrap-datetimepicker.css')}}" rel="stylesheet" media="screen">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('')}}">Bicycle Data</a>
            <a class="navbar-brand" href="{{url('logs')}}">Logs</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form navbar-left" role="search">
                        <input class="form-control" type="datetime" name="start" id="start" placeholder="Start...">
                        <input class="form-control" type="datetime" name="end" id="end" placeholder="End...">
                        <div class="form-group">
                            <select name="name" id="name" class="form-control"></select>
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
                    </form>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Chart for {{$name}}</h3>
        </div>
        <div class="panel-body">
            <canvas id="chart" width="auto" height="auto"></canvas>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/Chart.bundle.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/moment-timezone.js')}}"></script>
<script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
@include ('footer')
<script>
    $(document).ready(function () {
        $(station_names).each(function (index, station_name) {
            var option = $('<option>' + station_name + '</option>');
            if (name === station_name) {
                option.attr('selected', '')
            }
            $('#name').append(option)
        });
        $("#start").datetimepicker();
        $("#end").datetimepicker();
        var ctx = $("#chart");
        var labels = [];
        var dataset_remaining = {
            label: '剩余车辆数',
            data: [],
            borderColor: 'green'
        };
        var dataset_rented = {
            label: '剩余空位数',
            data: [],
        };

        $(records).each(function (index, record) {
            dataset_remaining['data'].push(record['remaining_bicycles']);
            dataset_rented['data'].push(record['rented_bicycles']);
            labels.push(moment.unix(record['time']));
        });
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [dataset_remaining, dataset_rented],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        type: 'time',
                        time: {
                            displayFormats: {
                                'minute': 'M/D HH:mm',
                            }
                        }
                    }],
                }
            }
        });
    });

</script>
</body>
</html>