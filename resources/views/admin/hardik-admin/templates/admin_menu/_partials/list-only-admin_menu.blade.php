@foreach ($obj as $key => $o)
<tr class="m-datatable__row">
  <td>{{ $o->id }}</td>
            <td>
        <span>
                      {{ $o->name }}
                  </span>
      </td>
                <td>
        <span>
                      {{ $o->slug }}
                  </span>
      </td>
        <td>
    <div class="dropdown">
      <button class="btn btn-secondary btn-action dropdown-toggle" type="button" id="dropdownMenuButton_{{ $o->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ t('Action') }}
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $o->id }}" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
        <a class="dropdown-item" href="{{ AdminURL('admin/menu/edit/' . $o->id) }}">{{ t('Edit') }}</a>
        <a class="dropdown-item" href="{{ AdminURL('admin/menu/delete/' . $o->id) }}">{{ t('Delete') }}</a>
        
      </div>
    </div>
  </td>
</tr>
@endforeach
