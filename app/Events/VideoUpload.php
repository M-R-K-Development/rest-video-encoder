<?php namespace Rve\Events;

use Rve\Events\Event;

use Illuminate\Queue\SerializesModels;

class VideoUpload extends Event {

	use SerializesModels;

	private $file;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($file)
	{
		$this->file = $file;
	}

	/**
	 * Return the file parameter
	 * @return \Rve\Models\File
	 */
	public function getFile() {
		return $this->file;
	}
}
