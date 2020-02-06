@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="_tw card">
    <div class="_tw_w card-body">
      <table class="table table-striped _ft" id="table_admin_menu_child">
        <thead>
          <tr>
            <th filter="id">ID</th>
            <th filter="name">Name</th>
            <th filter="slug">Slug</th>
            <th filter="admin_menu.name">Menu</th>
            <th>{{ t('Actions') }}</th>
          </tr>
          <tr class="filter"></tr>
        </thead>
        <tbody class="m-datatable__body">
          @include('admin_menu_child/_partials/list-only-admin_menu_child')
        </tbody>
      </table>
      <div class="links" table="table_admin_menu_child">
        {{ $obj->links() }}
      </div>
    
  </div>
</div>
</div>
@endsection
