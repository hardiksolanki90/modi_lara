<?php

use \Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

function pre($array, $exit = true)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';

    if ($exit) {
      exit();
    }
}

function theme($file, $global = false)
{
    if ($global) {
      return url('resources/views/_shared/' . $file);
    }

    if (config('modilara.app_scope') == 'admin') {
      return url('resources/views/admin/' . config('modilara.admin_theme') . '/' . $file);
    }

    return url('resources/views/front/' . config('modilara.front_theme') . '/' . $file);
}

function json($status, $message, $data = array())
{
    echo json_encode([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
    exit();
}

function jsonResponse($status, $message, $data = array())
{
    return response()->json([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
}

function input($field)
{
    return request()->input($field);
}

function media($name, $size = null, $type = 'image')
{
    return url('storage/media/' . $type . '/' . $name);
}

function getMedia($media, $size = null)
{
    if (!$media) {
        return;
    }

    $type = $media->type;

    if ($type == 'image' && $size) {
        $image = resize($media, $size);
        if (!$image) {
          return api_resize($media, $size);
        } else {
          return $image;
        }
    }

    return url('storage/app/' . $media->path);
}

function resize($media, $size)
{
    $size = explode(',', $size);

    $size1 = $size[0];
    $size2 = $size[1];

    $size1 = trim($size1);
    $background = Image::canvas($size1, $size2);
    $size_folder = $size1.'X'.$size2;
    $path = storage_path('app/image/' . $size_folder);
    $extension = explode('.', $media->name);
    $ext = end($extension);
    $ext = strtolower($ext);
    $img_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (file_exists($path . '/' . $media->name)) {
        return url('storage/app/image/' . $size_folder . '/' . $media->name);
    }

    if ($media->format == 'svg+xml' || !in_array($ext, $img_ext)) {
        return url('storage/app/image/'. $media->name);
    }

    if (!file_exists($path)) {
        mkdir($path);
    }

    $m = new \App\Objects\MediaImageSize;
    $c = $m->where('id_media', $media->id)
    ->where('size', $size_folder)
    ->first();

    if (!$c) {
        $m->id_media = $media->id;
        $m->size = $size_folder;
        $m->save();
    }

    if (!file_exists(storage_path('app/image') . '/' . $media->name)) {
        return;
    }

    $img = Image::make(storage_path('app/image') . '/' . $media->name);
    $img->resize($size1, $size2, function ($constraint) {
        $constraint->aspectRatio();
    });

    $img->save($path.'/'.$media->name);

    return url('storage/app/image/' . $size_folder . '/' . $media->name);


    // Fill up the blank spaces with transparent color
    // if ($img) {
    //     $img->resizeCanvas($size1, $size2, 'center', false, array(255, 255, 255, 0));
    // }
}

function AdminURL($url = null)
{
    return url(config('modilara.admin_route') . ($url ? '/' . $url : ''));
}

function t($string)
{
    return $string;
}

/**
 * output value if found in object or array
 * @param  [object/array] $model             Eloquent model, object or array
 * @param  [string] $key
 * @param  [boolean] $alternative_value
 * @return [type]
 */
function model($model, $key, $alternative_value = null, $type = 'object', $pluck = false)
{
    if ($pluck) {
      $count = $model;
      $array = array();
      if ($count && count($count)) {
        $array = $count->pluck($key)->toArray();
      }

      if (count($array)) {
        return implode(',', $array);
      }

      return $alternative_value;
    }

    if ($type == 'object') {
        if (isset($model->$key)) {
            return $model->$key;
        }
    }

    if ($type == 'array') {
        if (isset($model[$key]) && $model[$key]) {
            return $model[$key];
        }
    }

    return $alternative_value;
}

function c($data)
{
    if (isset($data->id) && $data->id) {
      return true;
    }

    return false;
}

function addTab($string, $number = 2) {
  for ($t = 1; $t <= $number; $t++) {
    $string = "\t".$string;
  }
  return $string;
}

function formatLine($string, $tab = 2, $end_line_break = 0) {
  $tabs = '';
  for ($t = 1; $t <= $tab; $t++) {
    $tabs .= "\t";
  }

  return PHP_EOL . $tabs.$string . PHP_EOL;
}

function formatLine2($string, $tab = 2, $end_line_break = 0) {
  $tabs = '';
  for ($t = 1; $t <= $tab; $t++) {
    $tabs .= "\t";
  }

  $string = $tabs . $string;
  return $string . PHP_EOL;
}

function formatLine3($string, $tab = 2, $end_line_break = 0) {
  $tabs = '';
  for ($t = 1; $t <= $tab; $t++) {
    $tabs .= "\t";
  }

  return $tabs.$string;
}

function writeHTML($file, $pass)
{
    $context = config('modilara.context');
    $html = view($file, $pass);
    $core = $context->tools;
    $core->prepareHTML($html);
    $html = $core->buildHTML();
    return $html;
}

function writeFile($file_path, $file, $html = 'Html', $php_tag = false)
{
    $dir = $file_path;
    if (!file_exists($dir)) {
      mkdir($dir);
    }

    $file = fopen($dir . '/' . $file, 'w');
    if ($php_tag) {
      $html = '<?php' . PHP_EOL . $html;
    }
    fwrite($file, $html);
    fclose($file);
}

function makeColumn($field)
{
    if (is_array($field)) {
      $co = [];
      foreach ($field as $key => $f) {
        $field[$key] = str_slug($f);
        $field[$key] = str_replace('-', '_', $f);
        $field[$key] = str_replace(' ', '_', $field[$key]);
        $field[$key] = strtolower($field[$key]);
      }
      return $field;
    } else {
      $column = str_slug($field);
      $column = str_replace('-', '_', $column);
      return $column;
    }
}

function makeColumnToString($column)
{
    $column = ucfirst($column);
    $column = explode('_', $column);
    return implode(' ', $column);
}

function getNumber($string)
{
    return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
}

function makeObject($string)
{
    $object = explode('_', $string);
    foreach ($object as $key => $d) {
      $object[$key] = ucfirst($d);
    }
    $object = implode('', $object);
    $object = str_replace('_', '', $object);
    return ucfirst($object);
}

function block($identifier)
{
    $context = config('modilara.context');
    $block = $context->block
    ->where('identifier', $identifier)
    ->where('status', 1)
    ->first();
    if (c($block)) {
      return $block->content;
    }
}

function filter($content)
{
    $content = filter_replace('BLOCK', 'block', $content);
    $content = filter_replace('MEDIA', 'media', $content);
    $content = filter_replace('APP_MEDIA', 'app_media', $content);
    $content = filter_replace('URL', 'custom_url', $content);
    $content = filter_replace('BLADE', 'blade_file', $content);
    $content = filter_replace('ROUTE', 'route', $content);
    $content = filter_replace('INCLUDE', 'include_file', $content);
    $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);
    return $content;
}

function custom_url($url)
{
    return env('APP_URL_PLAIN') . '/' . $url;
}

function filter_replace($identifier, $function, $content)
{
    $actual_content = $content;
    $block = preg_match_all('/%'.$identifier.'_(.*?)%/', $content, $results);
    if (count($results[1])) {
      foreach ($results[1] as $result) {
        $output = call_user_func_array($function, [strip_tags($result)]);
        if ($output) {
          $actual_content = str_replace('%' . $identifier . '_' . $result . '%', $output, $actual_content);
        }
      }
    }

    return $actual_content;
}


function str_text($string, $capitalize = true)
{
    $string = str_replace('id_', '', $string);
    $explode = explode('_', $string);
    if (count($explode)) {
      $string = implode(' ', $explode);
    }

    $explode = explode('-', $string);
    if (count($explode)) {
      $string = implode(' ', $explode);
    }

    if ($capitalize) {
      return ucwords($string);
    }

    return $string;
}

function generateMedia(array $data = array())
{
    if (!isset($data['type'])) {
        $data['type'] = 'image';
    }

    if (!isset($data['var_type'])) {
        $data['var_type'] = 'string';
    }

    $id = $data['id'];
    $mediaList = $data['media'];
    $type = $data['type'];
    $var_type = $data['var_type'];

    if (!$mediaList) {
        return;
    }

    $pass_data = [
      'media' => $mediaList,
      'id' => $id,
      'type' => $type,
      'var_type' => $var_type,
      'data' => $data
    ];

    $html = view('media.view', $pass_data);
    $tools = config('modilara.context')->tools;
    $tools->prepareHTML($html);
    return $tools->buildHTML();
}

function generateMediaHTML($media)
{
    $html = view('media.html', ['media' => $media]);
    $tools = config('modilara.context')->tools;
    $tools->prepareHTML($html);
    return $tools->buildHTML();
}

function prepareHTML($html)
{
    $tools = config('modilara.context')->tools;
    $tools->prepareHTML($html);
    return $tools->buildHTML();
}

function curl_request($url)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);

    if($errno = curl_errno($curl)) {
        $error_message = curl_strerror($errno);
        return $error_message;
    }

    // Close request to clear up some resources
    curl_close($curl);

    return $resp;
}

function ps($string)
{
    $string = str_replace('(', '', $string);
    $string = str_replace(')', '', $string);
    $string = str_replace('#', '', $string);
    $string = str_replace('-', '', $string);
    $string = str_replace(' ', '', $string);
    return $string;
}

function removeStyle($content)
{
    $output = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);
    $output = preg_replace('/(<[^>]+) dir=".*?"/i', '$1', $output);
    return $output;
}

function protectedString($content)
{
    $h = removeStyle($content);
    $h = strip_tags($h, '<a><ul><li><ol><h1><h2><h3><h4><h5><h6><p><div>');
    return $h;
}

function include_file($file)
{
    if (config('modilara.app_scope') != 'front') {
        return;
    }

    $data = config('modilara.assign');

    return view($file, $data);
}

function blade_file($file)
{
    $data = config('modilara.assign');
    return prepareHTML(view($file, $data));
}

function mailFilter($email, $object, $content = 'content')
{
    $email_content = filter($email->$content);
    $actual_object = $object;
    $actual_content = str_replace('http://', '', $email_content);
    $data = preg_match_all('/%(.*?)%/', $email_content, $results);
    if (count($results[1])) {
        foreach ($results[1] as $result) {
            $result = str_replace('25', '', $result);
            $explode = explode('/', $result);
            if (count($explode) > 1) {
                $new_output = null;
                foreach ($explode as $ex) {
                    if (strpos($ex, '()')) {
                        $object = call_user_func(array($object, str_replace('()', '', $ex)));
                    } else {
                        if (isset($object->$ex)) {
                            $object = $object->$ex;
                        }
                    }
                    $new_output = $object;
                }
                if (is_string($new_output)) {
                    $output = $new_output;
                } else {
                    $output = 'Not found';
                }
                $object = $actual_object;
            } else {
                $output = $object->$result;
            }
            if ($result == 'status') {
                if ($output == 1) {
                    $output = 'enabled';
                } else {
                    $output = 'disabled';
                }
            }
            if ($result == 'url') {
                $var = $email->component->variable;
                $output = url(config('modilara.context')->$var . '/' . $output);
            }
            if ($output) {
                $actual_content = str_replace('%' . $result . '%', $output, $actual_content);
            }
        }
    }

    return $actual_content;
}

function alt_value($data, $alt)
{
    if ($data) {
        return $data;
    }

    return $alt;
}

function cleanString($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function getMediaType($ex) {
    $image = ['jpg', 'jpeg', 'png', 'svg'];
    $video = ['avi', 'flv', 'wmv', 'mov', 'mp4'];
    $pdf = ['pdf'];
    $cad = ['cad'];

    if (in_array($ex, $image)) {
      return 'image';
    }
    if (in_array($ex, $video)) {
      return 'video';
    }
    if (in_array($ex, $pdf)) {
      return 'pdf';
    }
    if (in_array($ex, $cad)) {
      return 'cad';
    }
}

function createURL($title)
{
    $url = strtolower($title);
    $url = str_replace(' ', '-', $title);
    return $url;
}
