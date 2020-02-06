<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Input;
use Illuminate\Http\Request;

class MediaController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->component = app()->context->component
        ->where(['variable' => 'media'])
        ->first();
    }

    public function initListing(Request $request)
    {
        $this->page['title'] = 'Media';
        if ($this->component->is_admin_create) {
          $this->page['action_links'][] = [
            'text' => t('Add ' . $this->component->name),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->initProcessFilter();

        if ($this->filter) {
          $media = app()->context->media
          ->orderBy('id', 'desc')
          ->where($this->filter_search);
        } else {
          $media = app()->context->media
          ->orderBy('id', 'desc');
        }

        $this->page['badge'] = count($media->get());
        $this->obj = $media->paginate(80);

        $listable = $this->component->fields
        ->where('use_in_listing', 1);

        $this->assign = [
          'listable' => $listable,
          'variable' => 'media'
        ];

        if ($request->ajax()) {
          $data = $this->assign;
          $html = getAdminTemplate('media/_partials/list-only-media', $data, true);
          return json('success', $html, true, prepareHTML($media->paginate(80)->links()));
        }

        return $this->template('media.list');
    }

    public function initContentCreate($id = null)
    {
        if ($this->component->is_admin_list) {
          $this->page['action_links'][] = [
            'text' => t($this->component->name),
            'slug' => route($this->component->variable . '.list'),
            'icon' => '<i class="material-icons">list</i>'
          ];
        }

        if ($this->component->is_admin_create && $id) {
          $this->page['action_links'][] = [
            'text' => t('Add'),
            'slug' => route($this->component->variable . '.add'),
            'icon' => '<i class="material-icons">add_circle_outline</i>'
          ];
        }

        $this->obj = app()->context->media;
        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        if (!$id) {
          $this->page['title'] = 'Add Media';
        } else {
          $this->page['title'] = 'Media: ' . $this->obj->name;
        }

        $fillable = $this->component->fields
        ->where('is_fillable', 1);

        $this->assign = [
          'fillable' => $fillable
        ];

        return $this->template('media.create');
    }

    public function initProcessUpload()
    {
        $files = config('adlara.request')->file('files');
        if (count($files)) {
          foreach ($files as $file) {
            $name = $file->getClientOriginalName();
            $media_type = explode('/', $file->getMimeType());
            $type = $media_type[0];
            $format = $media_type[1];
            $path = $file->storeAs($type, $name);
            $abs_path = explode('/', $path);
            $media = new \App\Objects\Media;
            $media->name = end($abs_path);
            $media->path = $path;
            $media->type = $type;
            $media->format = $format;
            $media->save();
          }
        }
        return json('success', 'File saved');
    }

    public function initProcessEmbed()
    {
        $code = input('code');
        $media = new \App\Objects\Media;
        $media->name = $code;
        $media->path = '';
        $media->type = 'video';
        $media->format = 'embeded';
        $media->save();
        return json('success', 'Embeded code saved');
    }

    public function initProcessCreate($id = null)
    {
        $data = $this->validateFields();
        $this->obj = app()->context->media;

        if ($id) {
          $this->obj = $this->obj->find($id);
        }

        $data = $this->obj;
        $data->name = input('name');
        $data->title = input('title');
        $data->format = input('format');
        $data->status = input('status');
        $data->type = input('type');
        $path = config('adlara.request')->file('file')->store('files');
        $data->type = $path;
        $data->save();


        if (!$id) {
          return json('redirect', AdminURL($this->component->slug . '/edit/' . $data->id));
        }

        return json('success', t($this->component->name . ' updated'));
    }

    public function initProcessDelete($id = null)
    {
        $obj = app()->context->media->find($id);
        if ($obj) {
          $obj->delete();
                              $this->flash('success', 'Media with title <strong>' . $obj->name . '</strong> is deleted successufully');
        }
        return redirect(route('media.list'));
    }

    public function initListingPartial()
    {
        $type = input('media');
        if ($type) {
          $media = app()->context->media
          ->where('type', $type)
          ->orderBy('id', 'desc')
          ->paginate(80);
        } else {
          $media = app()->context->media
          ->orderBy('id', 'desc')
          ->paginate(80);
        }

        $data = [
          'media' => $media
        ];

        $html = view('media._partials.list-only-media', $data);
        $tools = app()->context->tools;
        $tools->prepareHTML($html);
        return $tools->buildHTML();
    }
}
