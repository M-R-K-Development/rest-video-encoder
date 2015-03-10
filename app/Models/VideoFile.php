<?php namespace Rve\Models;

use Illuminate\Database\Eloquent\Model;

class VideoFile extends File {

	public static function boot() {
        parent::boot();
       
        VideoFile::creating(function ($file) {
			$file->type = 'video';
		});
    }
}

