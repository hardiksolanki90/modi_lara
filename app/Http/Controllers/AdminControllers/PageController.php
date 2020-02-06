<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Objects\Page;
use App\Objects\PageBlocks;

class PageController extends AdminController
{

    public function initContentCreate($id = null)
    {
        $page = new Page;

        if ($id) {
          $page = Page::find($id);
        }

        $this->page['action_links'][] = [
            'text' => 'List',
            'slug' => route('page.list'),
            'icon' => '<i class="material-icons">reply</i>'
        ];

        $page->static_blocks = $page->preparedBlocks();

        $this->obj = $page;

        $this->assign = [
          'obj' => $page
        ];

        return $this->template('page.create');
    }

    public function initProcessCreate($id = null)
    {

        $page = new Page;

        if ($id) {
          $page = Page::find($id);
        }

        $page->title = request()->input('title');
        $page->url = \Str::slug(request()->input('url'));
        $page->sub_title = request()->input('sub_title');
        $page->quote_form_content = protectedString(request()->input('quote_form_content'));
        $page->quote_form_title = request()->input('quote_form_title');
        $page->content = protectedString(request()->input('content'));
        $page->template = request()->input('template');
        $page->transparent_header = request()->input('transparent_header');
        $page->show_lead_form = request()->input('show_lead_form');
        $page->id_image = request()->input('id_image');
        $page->id_video = request()->input('id_video');
        $page->meta_title = request()->input('meta_title');
        $page->meta_description = request()->input('meta_description');
        $page->save();

        $this->savePageBlocks($page);

        return array(
          'status' => 'redirect',
          'message' => AdminURL('page/edit/' . $page->id)
        );

    }

    public function initListing()
    {
        $this->page['action_links'][] = [
          'text' => t('Add Page'),
          'slug' => route('page.add'),
          'icon' => '<i class="material-icons">add_circle_outline</i>'
        ];

        $this->initProcessFilter();

        $pages = Page::orderBy('id', 'desc');

        $this->page['badge'] = $pages->count();

        $this->obj = $pages->paginate(25);

        return $this->template('page.list');
    }

    private function savePageBlocks($data)
    {

        $block_content_head = request()->input('block_content_head');
        $block_content = request()->input('block_content');
        $block_image = request()->input('block_image');
        $block_image_position = request()->input('block_image_position');
        $block_class = request()->input('block_class');
        $block_reference = request()->input('block_reference');
        $block_position = request()->input('position');
        $block_content_position = request()->input('content_position');

        // saved_blocks IDS
        $saved_blocks = PageBlocks::where('id_page', $data->id)->get()->pluck('id')->toArray();

        if (is_array($block_content) && count($block_content)) {

            foreach ($block_content as $key => $content) {

                if (!$content) {
                  continue;
                }

                $b_content_head = $block_content_head[$key];
                $b_image = $block_image[$key];
                $b_image_position = $block_image_position[$key];
                $b_class = $block_class[$key];
                $b_reference = $block_reference[$key];
                $b_position = $block_position[$key];
                $b_content_position = $block_content_position[$key];
                // $b_content_position = 'full';

                // $epb = Equipment Page Block
                $epb = new PageBlocks;
                $epb->block_reference = $b_reference;
                $epb->content_head = $b_content_head;
                $epb->content = protectedString($content);
                $epb->id_image = $b_image;
                $epb->id_page = $data->id;
                $epb->class = $b_class;
                $epb->image_position = $b_image_position;
                $epb->position = $b_position;
                $epb->content_position = $b_content_position;
                $epb->save();

            }

        }


        PageBlocks::whereIn('id', $saved_blocks)->delete();
    }

}
