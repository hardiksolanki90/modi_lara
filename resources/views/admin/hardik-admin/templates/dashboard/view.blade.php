@extends('layouts.dashboard')
@section('content')
<div class="content">
  <div class="flex space-between _top_s _stb">
    <div class="box flex space-between top-box">
      <div class="icon-block">
        <i class="ion-ios-people-outline"></i>
      </div>
      <div class="block-content">
        <div id="live_users" class="digit fetch-user">0</div>
        <h4>Active users</h4>
        <a href="https://analytics.google.com/analytics/web/#realtime/rt-overview" target="_blank">View in Google</a>
      </div>
    </div>
    <div class="box flex space-between top-box">
      <div class="icon-block">
        <i class="ion-ios-paper"></i>
      </div>
      <div class="block-content">
        <div class="digit">171</div>
        <h4>Workers</h4>
        <a href="https://beta.chotuji.com/authority/worker/list">View</a>
      </div>
    </div>
    <div class="box flex space-between top-box">
      <div class="icon-block">
        <i class="ion-ios-paper"></i>
      </div>
      <div class="block-content">
        <div class="digit">171</div>
        <h4>Workers</h4>
        <a href="https://beta.chotuji.com/authority/worker/list">View</a>
      </div>
    </div>
    <div class="box flex space-between top-box">
      <div class="icon-block">
        <i class="ion-ios-paper"></i>
      </div>
      <div class="block-content">
        <div class="digit">171</div>
        <h4>Workers</h4>
        <a href="https://beta.chotuji.com/authority/worker/list">View</a>
      </div>
    </div>
  </div>
  <div class="flex space-between _stb">
      <div class="box">
        <div class="flex space-between">
          <h4>Daily Visits</h4>
          <p>Updated just now</p>
        </div>
        <canvas id="dailyVisits"></canvas>
      </div>
      <div class="box">
        <div class="flex space-between">
          <h4>Top Devices</h4>
          <p>Updated just now</p>
        </div>
        <canvas id="topDevices"></canvas>
      </div>
    </div>
    <div class="_stb flex space-between">
    <div class="box _lu">
      <div class="flex space-between">
        <h4>Most Viewed</h4>
        <p>Updated just now</p>
      </div>
      @if (count($most_visited))
      <table class="table table-mv">
        <tr>
          <th>Page</th>
          <th>Page Views</th>
        </tr>
        @foreach ($most_visited as $mv)
        <tr>
          <td>{{ $mv['url'] }}</td>
          <td>{{ $mv['pageViews'] }}</td>
        </tr>
        @endforeach
      </table>
      @endif
    </div>
    <div class="box">
      <div class="flex space-between">
        <h4>Top Referrers</h4>
        <p>Updated just now</p>
      </div>
      @if (count($top_referrers))
      <table class="table table-mv">
        <tr>
          <th>URL</th>
          <th>Views</th>
        </tr>
        @foreach ($top_referrers as $mv)
        <tr>
          <td>{{ $mv['url'] }}</td>
          <td>{{ $mv['pageViews'] }}</td>
        </tr>
        @endforeach
      </table>
      @endif
    </div>
    <div class="box">
      <div class="flex space-between">
        <h4>Top Browsers</h4>
        <p>Updated just now</p>
      </div>
      @if (count($top_browsers))
      <table class="table table-mv">
        <tr>
          <th>Browser</th>
          <th>Sessions</th>
        </tr>
        @foreach ($top_browsers as $mv)
        <tr>
          <td><i class="fa fa-{{ strtolower($mv['browser']) }}"></i> {{ $mv['browser'] }}</td>
          <td>{{ $mv['sessions'] }}</td>
        </tr>
        @endforeach
      </table>
      @endif
    </div>
  </div>
</div>
@endsection
@section('footer_script')
<script>
const app = new Vue({
  el: '#apps',
  data: {
    login: false,
    user: null,
    live_users: 0,
    interval: null,
    devices: [],
    os: []
  },
  methods: {
    getLiveUsers: function() {
       this.$http.get(URL + '/dashboard/live/users')
       .then(response => response.json())
       .then(live_users => {
         this.live_users = live_users;
       });
    },
    getTopDevices() {
      this.$http.get(URL + '/dashboard/top/os')
        .then(response => response.json())
        .then(top_os => {

          labels = [];
          Object.keys(top_os.labels).forEach(function(v, i) {
            labels.push(v);
          });

          c_data = {
            'id': 'topDevices',
            'type': 'bar',
            'labels': labels,
            'sets': top_os.sets
          };
          myChart(c_data);
        });
    },
    getDailyVisits() {
      this.$http.get(URL + '/dashboard/daily/visits')
        .then(response => response.json())
        .then(daily_visits => {
          c_data = {
            'id': 'dailyVisits',
            'type': 'line',
            'labels': daily_visits.labels,
            'sets': daily_visits.sets
          }
          myChart(c_data);
        });

    }
  },
  created() {
    this.getLiveUsers();
    this.getTopDevices();
    this.getDailyVisits();
    this.interval = setInterval(function () {
     this.getLiveUsers();
   }.bind(this), 50000);
  },
});

function myChart(data) {
  var ctx = document.getElementById(data.id);
  datasets = [];
  if (data.sets.length) {
    for (i = 0; i < data.sets.length; i++) {
      datasets[i] = {
        'label': data.sets[i].label
      };
      datasets[i]['data'] = data.sets[i].data;
      datasets[i]['backgroundColor'] = [data.sets[i].bg];
      datasets[i]['borderWidth'] = 1;
    }
  }

  var myChart = new Chart(ctx, {
    type: data.type,
    data: {
      labels: data.labels,
      datasets: datasets,
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
}
</script>
@endsection
