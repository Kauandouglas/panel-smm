<?php


namespace App\Filters;


use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class PersonFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(request()->w ?? 1280, request()->h ?? 1280)->encode();
    }
}
