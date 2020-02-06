
namespace App\Objects;

use App\Objects\IDB;
use Illuminate\Database\Eloquent\SoftDeletes;

class {{ $object }} extends IDB
{
    use SoftDeletes;

    protected $table = '{{ $table }}';
@if (count($fields))
@foreach ($fields as $key => $field)
@if ($field->relationship_type == 'belongsTo')

    public function {{ str_replace('id_', '', $field->field_name) }}()
    {
        return $this->belongsTo('App\Objects\{{ makeObject($field->component->variable) }}', '{{ $field->local_key }}');
    }
@endif
@if  ($field->relationship_type == 'hasOne')

    public function {{ $comp = $field->component->variable }}()
    {
        return $this->hasOne('App\Objects\{{ makeObject($comp) }}', '{{ $field->foreign_key }}', '{{ ($field->local_key ? $field->local_key : 'id') }}');
    }
@endif
@if  ($field->relationship_type == 'hasMany')

    public function {{ str_plural($field->field_name) }}()
    {
        return $this->hasMany('App\Objects\{{ makeObject($field->component->variable) }}', 'id_<?php echo $field->core_component->variable ?>');
    }
@endif
@if  ($field->relationship_type == 'belongsToMany')

    public function {{ $comp = $field->component->variable }}()
    {
        return $this->belongsToMany('App\Objects\{{ makeObject($comp) }}', '{{ $field->mediator_table }}', '{{ $field->mediator_table_key }}', '{{ $field->local_key }}');
    }
@endif
@endforeach
@endif
}
