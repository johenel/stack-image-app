<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class ImageService
{
    public function groupByIndex(Collection $images, $raw_image_url = false)
    {
        $grouped_images = [];

        $images->each(function($image) use (&$grouped_images, $raw_image_url) {
            $grouped_images[$image->index][] = $raw_image_url ? $image->toArray()['image_url'] : $image->toArray();
        });

        return $grouped_images;
    }

    public function uploadImage(UploadedFile $file): string
    {
        return str_replace('/public', '', env('APP_URL') . '/storage/' . $file->store('public/images'));
    }

    public function getCombinations(Collection $images)
    {
        $grouped_images = $this->groupByIndex($images, true);
        $combinations = $this->generateCombinations($grouped_images);

        return $combinations;
    }

    public function generateCombinations($image_array, $index = 0)
    {
        if (!isset($image_array[$index])) {
            return [];
        }

        if ($index == count($image_array) - 1) {
            return $image_array[$index];
        }

        $temp = $this->generateCombinations($image_array, $index + 1);

        foreach ($image_array[$index] as $v) {
            foreach ($temp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }
}
