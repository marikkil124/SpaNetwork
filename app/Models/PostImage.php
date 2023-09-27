<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    use HasFactory;
    protected $guarded = false;
//protected $table="post_images";

public static function clearStorage()
{
    $images = PostImage::where('user_id',auth()->id())->whereNull('post_id')->get();

    foreach ($images as $image)
    {
        Storage::disk('public')->delete($image->path);
        echo $image;
    }

}

    protected function urlPath(): Attribute
    {
        return Attribute::make(
            get: fn () => url('storage/' . $this->path)
        );
    }






}
