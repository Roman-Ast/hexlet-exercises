<?php
namespace App\HTMLbuilder;

require __DIR__ . '/../vendor/autoload.php';

function build($tag)
{
    $main_keys = ['name', 'body', 'tagType'];
    $mapping = [
        'name' => function ($value) {
            return "<{$value}";
        },
        'body' => function($value) {
            return "{$value}";
        },
        'tagType' => function($value, $tag) {
            if ($value === 'pair') {
              return "</{$tag['name']}>";
            }
        }
    ];

    $mainArray = \collect($main_keys)->map(function($value) use($tag, $mapping) {
        if (isset($tag[$value])) {
            return $mapping[$value]($tag[$value], $tag);
        }
    })->all();
    
    $attributes = \collect($tag)
      ->map(function($value, $key) use($mapping, $main_keys) {
          if (!in_array($key, $main_keys)) {
            return " {$key}=\"{$value}\"";
        }
    })->filter()->all();
    
    array_push($attributes, '>');
    array_splice($mainArray, 1, 0, $attributes);
    return implode(array_diff($mainArray, array('')));
}