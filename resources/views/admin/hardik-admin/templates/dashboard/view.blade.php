@extends('layouts.dashboard')
@section('content')
<div class="row">
   <div class="col-12 col-sm-6 col-md-3">
      <a href="" class="text-black" title="BSC Admission">
         <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="mdi mdi-account-multiple-plus-outline"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">BSC Admission</span>
               <span class="info-box-number">
               </span>
            </div>
            <!-- /.info-box-content -->
         </div>
      </a>
      <!-- /.info-box -->
   </div>
   <!-- /.col -->
   <div class="col-12 col-sm-6 col-md-3">
      <a href="" class="text-black" title="BA Admission">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="mdi mdi-account-multiple-plus-outline"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">BA Admission</span>
            </div>
            <!-- /.info-box-content -->
         </div>
      </a>
      <!-- /.info-box -->
   </div>
   <!-- /.col -->
   <!-- fix for small devices only -->
   <div class="clearfix hidden-md-up"></div>
   <div class="col-12 col-sm-6 col-md-3">
      <a href="" class="text-black" title="Transactions">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="mdi mdi-credit-card-outline"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">Fees Transaction</span>
            </div>
         </div>
      </a>
   </div>
   <!-- /.col -->
   <div class="col-12 col-sm-6 col-md-3">
      <a href="" class="text-black" title="Alumni">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="mdi mdi-account-network-outline"></i></span>
            <div class="info-box-content">
               <span class="info-box-text">Alumni</span>
            </div>
         </div>
      </a>
   </div>
   <div class="col-md-8">
      <!-- TABLE: LATEST ORDERS -->
      <div class="card">
         <div class="card-header border-transparent">
            <h3 class="card-title"><i class="mdi mdi-credit-card-outline left mr-2"></i> Fees Transactions</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body p-0">
            <div style="height: 400px; overflow: auto;">
               <table class="table m-0">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Rollno</th>
                        <th>Name</th>
                        <th>Transaction ID</th>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Gender</th>
                        <th>Grant Total</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <!-- /.table-responsive -->
         </div>
         <!-- /.card-body -->
         <div class="card-footer clearfix">
            <a href="" class="btn btn-sm btn-info float-right">All Transaction</a>
         </div>
         <!-- /.card-footer -->
      </div>
      <!-- /.card -->
   </div>
   <div class="col-md-4">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title"><i class="mdi mdi-newspaper left mr-2"></i> Recently Added NEWS</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2"  style="height: 400px; overflow: auto;">
            </ul>
         </div>
         <!-- /.card-body -->
         <div class="card-footer text-center">
            <a href="" class="uppercase">View All News</a>
         </div>
         <!-- /.card-footer -->
      </div>
   </div>
   <!-- /.col -->
</div>
@endsection
@section('footer_script')
{{-- <script>
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
</script> --}}
@endsection