<?php

namespace App\Classes;

class Form
{
    private $form = [];

    private $required = [];

    private $required_label = [];

    public $token = true;

    public function start($name, $class, $action = '')
    {
        $this->form = new \stdClass;
        $this->form->name = $name;
        $this->form->class = $class;
        $this->form->action = $action;
        return '<form name="'.$name.'" class="'.$class.'" id="'.$name.'" action="'.$action.'" enctype="multipart/form-data">';
    }

    public function end()
    {
        $html = '';
        if (isset($this->required[$this->form->name]) && count($this->required[$this->form->name])) {
            $html .= $this->hidden('required', implode(',', $this->required[$this->form->name]));
            $html .= $this->hidden('required_label', implode(',', $this->required_label[$this->form->name]));
        }

        $html .= $this->hidden('form_class', $this->form->class);
        if ($this->token) {
            $html .= $this->hidden('_token', csrf_token());
        }

        $html .= '</form>';
        return $html;
    }

    public function hidden($name, $value = null)
    {
        return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.($value ? $value : '').'">';
    }

    public function text(array $data = array())
    {
        $default = [
          'label' => '',
          'id' => $data['name'],
          'class' => '',
          'width' => 'full',
          'length' => 100,
          'value' => '',
          'required' => false,
          'type' => 'text',
          'placeholder' => false,
          'wrapper_class' => '',
          'material' => false,
          'textarea' => false
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
              $data[$key] = $value;
            }
        }

        if ($data['required']) {
          $this->required[$this->form->name][] = $data['name'];
          $this->required_label[$this->form->name][] = $data['label'];
        }

        // $key = $this->form->name . '_' . $data['name'] . '_' . $data['value'] . '_' . $this->form->name;
        $html = view('form.text', ['data' => $data]);
        $tools = app()->context->tools;
        $tools->prepareHTML($html);
        return $tools->buildHTML();
        // return cache()->remember($key, '2400', function () use ($data) {
        //   $html = view('form.text', ['data' => $data]);
        //   $tools = app()->context->tools;
        //   $tools->prepareHTML($html);
        //   return $tools->buildHTML();
        // });
    }

    public function file($data = array())
    {
        $default = [
          'label' => '',
          'id' => $data['name'],
          'class' => '',
          'value' => '',
          'required' => false,
          'type' => 'file',
          'material' => false,
          'wrapper_class' => '',
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
              $data[$key] = $value;
            }
        }

        if ($data['required']) {
          $this->required[$this->form->name][] = $data['name'];
          $this->required_label[$this->form->name][] = $data['label'];
        }

        $key = $this->form->name . '_' . $data['name'] . '_' . $data['value'] . '_' . $this->form->name;
        $html = view('form.text', ['data' => $data]);
        $tools = app()->context->tools;
        $tools->prepareHTML($html);
        return $tools->buildHTML();
        return cache()->remember($key, '2400', function () use ($data) {
          $html = view('form.text', ['data' => $data]);
          $tools = app()->context->tools;
          $tools->prepareHTML($html);
          return $tools->buildHTML();
        });
    }

    public function choice($data = array())
    {
        $default = [
          'label' => '',
          'options' => [],
          'value' => null,
          'name' => $data['name'],
          'id' => str_replace('[]', '', $data['name']),
          'class' => '',
          'wrapper_class' => '',
          'text_key' => '',
          'value_key' => '',
          'multiple' => false,
          'required' => false,
          'attribute' => '',
          'show_label_as_option' => true,
          'text_as_value' => false,
          'type' => 'select',
          'inline' => false,
          'switch' => false,
          'reverse' => false
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        if ($data['multiple'] && !is_array($data['value'])) {
          return response('Field ' . $data['name'] . ' is multiple but value is string', 500);
        }

        if (!count($data['options'])) {
          return;
        }

        if ($data['reverse']) {
          $data['options'] = array_reverse($data['options'], true);
        }

        // $data_implode = $data;
        // $data_implode['options'] = implode(';', $data['options']);
        // $data_implode = implode(',', $data_implode);
        // $key = $this->form->name . '_' . $data_implode . '_' . '_' . $this->form->name;
        $html = view('form.select', ['data' => $data]);
        $tools = app()->context->tools;
        $tools->prepareHTML($html);
        return $tools->buildHTML();

        return cache()->remember($key, '2400', function () use ($data) {
          $html = view('form.select', ['data' => $data]);
          $tools = app()->context->tools;
          $tools->prepareHTML($html);
          return $tools->buildHTML();
        });
    }

    public function media($data)
    {
        $default = [
          'label' => '',
          'name' => $data['name'],
          'id' => $data['name'],
          'class' => '',
          'media' => $data['media'],
          'multiple' => false,
          'object_type' => 'image',
        ];

        foreach ($default as $key => $value) {
            if (!isset($data[$key])) {
                $data[$key] = $value;
            }
        }

        $html = view('form.media', ['data' => $data]);
        $tools = app()->context->tools;
        $tools->prepareHTML($html);
        return $tools->buildHTML();

        return $html;
    }
}
