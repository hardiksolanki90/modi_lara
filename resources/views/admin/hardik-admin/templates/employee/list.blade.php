@extends('layouts.dashboard')
@section('content')
<div class="con">
  <div class="_tw card">
    @if (count($page['action_links']))
      <div class="_ph">
        <div class="_pas">
          <div class="action-bar-panel">
            @foreach ($page['action_links'] as $link)
              <a data-toggle="tooltip" data-placement="top" data-original-title="{{ $link['text'] }}" class="rounded-s action-link {{ (isset($link['class']) ? $link['class'] : '') }}" href="{{ $link['slug'] }}">
                @if ($link['icon'])
                  {!! $link['icon'] !!}
                @endif
                <span>{{ $link['text'] }}</span>
              </a>
            @endforeach
          </div>
        </div>
        <div class="_h">
          {{ $page['title'] }}
        </div>
      </div>
    @endif
    <div class="_tw_w card-body">
      <table class="table table-striped _ft" id="table_faq">
        <thead>
          <tr>
            <th filter="id">ID</th>
            <th filter="question">Name</th>
            <th filter="status">Email</th>
            <th>{{ t('Actions') }}</th>
          </tr>
          <tr class="filter"></tr>
        </thead>
        <tbody class="m-datatable__body">
          @include('employee/_partials/list-only')
        </tbody>
      </table>
      <div class="links" table="table_faq">
        {{ $obj->links() }}
      </div>

  </div>
</div>
</div>
@endsection
