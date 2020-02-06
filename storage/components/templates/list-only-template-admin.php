@foreach ($obj as $key => $o)
<tr class="m-datatable__row">
  <td>{{ $o->id }}</td>
  <?php foreach ($listable as $list) : ?>
    <?php if ($list->column_type == 'relationship' && $list->relationship_type == 'belongsToMany') : ?>
          <td>
            @foreach ($o-><?php echo $list->component->variable ?> as $t)
              <span>{{ $t->name }}</span>
            @endforeach
          </td>
    <?php else : ?>
      <td>
        <span>
          <?php if ($list->column_type == 'relationship') : ?>
            {{ model($o-><?php echo $list->component->variable ?>, 'name') }}
          <?php else : ?>
            {{ $o-><?php echo makeColumn($list->field_name) ?> }}
          <?php endif; ?>
        </span>
      </td>
    <?php endif; ?>
  <?php endforeach; ?>
  <td>
    <div class="dropdown">
      <button class="btn btn-secondary btn-action dropdown-toggle" type="button" id="dropdownMenuButton_{{ $o->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ t('Action') }}
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $o->id }}" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
        <?php if ($component->is_admin_create) : ?><a class="dropdown-item" href="{{ AdminURL('<?php echo $component->slug ?>/edit/' . $o->id) }}">{{ t('Edit') }}</a>
        <?php endif; ?><?php if ($component->is_admin_delete) : ?><a class="dropdown-item" href="{{ AdminURL('<?php echo $component->slug ?>/delete/' . $o->id) }}">{{ t('Delete') }}</a>
        <?php endif; ?>

      </div>
    </div>
  </td>
</tr>
@endforeach
