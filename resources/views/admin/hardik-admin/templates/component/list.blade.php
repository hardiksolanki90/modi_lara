@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="_tw card">
    <div class="card-header">Components <span class="badge badge-secondary">{{ count($components) }}</span></div>
    <div class="_tw_w card-body">
      <table class="table" id="html_table">
        <thead>
          <tr>
            <th filter="id">ID</th>
            <th filter="name">Name</th>
            <th filter="table">Table</th>
            <th fitler="variable">Variable</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if (count($components))
          @foreach ($components as $c)
          <tr>
            <td><span>{{ $c->id }}</span></td>
            <td><span>{{ $c->name }}</span></td>
            <td><span>{{ $c->table }}</span></td>
            <td><span>{{ $c->variable }}</span></td>
            <td>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle btn-action" type="button" id="dropdownMenuButton_{{ $c->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $c->id }}" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                  <a class="dropdown-item" href="{{ AdminURL('component/edit/' . $c->id)  }}">
                    Edit
                  </a>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
