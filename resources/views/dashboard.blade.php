<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
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
            <a class="navbar-brand" href="#">Bicycle Data</a>
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
            <h3 class="panel-title">Chart</h3>
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
        $(station_names).each(function (index, name) {
            $('#name').append($('<option>' + name + '</option>'))
        });
        $("#start").datetimepicker();
        $("#end").datetimepicker();
        var ctx = $("#chart");
        var labels = [];
        var datasets = [{
            label: '# of remaining bicycles for '+name,
            data: [],
        }];

        $(records).each(function (index, record) {
            datasets[0]['data'].push(record['remaining_bicycles']);
            labels.push(moment.unix(record['time']).format('M/D HH:mm'));
        });
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                }
            }
        });
    });

</script>
</body>
</html>