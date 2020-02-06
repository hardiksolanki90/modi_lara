@extends('layouts.dashboard')
@section('content')
<div class="con">  
  <div class="_tw card">
    <div class="_tw_w card-body">
      <table class="table table-striped _ft" id="table_block">
        <thead>
          <tr>
            <th filter="id">ID</th>
            <th filter="name">name</th>
            <th filter="status">status</th>
            <th filter="identifier">identifier</th>
            <th>{{ t('Actions') }}</th>
          </tr>
          <tr class="filter"></tr>
        </thead>
        <tbody class="m-datatable__body">
          @include('block/_partials/list-only-block')
        </tbody>
      </table>
      <div class="links" table="table_block">
        {{ $obj->links() }}
      </div>
    
  </div>
</div>
</div>
@endsection
