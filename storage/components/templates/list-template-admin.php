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
      <?php if (count($listable)) : ?><table class="table table-striped _ft" id="table_<?php echo $variable ?>">
        <thead>
          <tr>
            <th filter="id">ID</th>
            <?php foreach($listable as $list) : ?><th filter="<?php echo ($list->column_type == 'relationship' ? str_replace('_', '-', $list->component->variable) . '.name' : $list->field_name) ?>"><?php echo str_text($list->field_name) ?></th>
            <?php endforeach; ?><th>{{ t('Actions') }}</th>
          </tr>
          <tr class="filter"></tr>
        </thead>
        <tbody class="m-datatable__body">
          @include('<?php echo $variable ?>/_partials/list-only-<?php echo $variable ?>')
        </tbody>
      </table>
      <div class="links" table="table_<?php echo $variable ?>">
        {{ $obj->links() }}
      </div>
    <?php endif; ?>

  </div>
</div>
</div>
@endsection
