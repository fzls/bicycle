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
                        <select name="time_span" class="form-control">
                            <option value="">Choose time span</option>
                            <option value="1 Hour">1 hour</option>
                            <option value="6 Hours">6 hours</option>
                            <option value="12 Hours">12 hours</option>
                            <option value="1 Day">1 day</option>
                            <option value="2 Days">2 days</option>
                            <option value="1 Week">1 week</option>
                            <option value="2 Weeks">2 weeks</option>
                            <option value="1 Month">1 month</option>
                            <option value="2 Months">2 month</option>
                        </select>
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

            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255,99,132,0.1)',
            borderWidth: 1,
        };
        var dataset_rented = {
            label: '剩余空位数',
            data: [],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 0.1)',
            borderWidth: 1,
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
                                'millisecond': 'M/D HH:mm',
                                'second': 'M/D HH:mm',
                                'minute': 'M/D HH:mm',
                                'hour': 'M/D HH:mm',
                                'day': 'M/D HH:mm',
                                'week': 'M/D HH:mm',
                                'month': 'M/D HH:mm',
                                'quarter': 'M/D HH:mm',
                                'year': 'M/D HH:mm',

                            }
                        }
                    }],
                }
            }
        });
    });
</script>
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85758851-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- End Google Analytics -->
</body>
</html>