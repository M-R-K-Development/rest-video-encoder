<?php namespace Rve\Handlers\Events;

use Rve\Events\VideoUpload;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class StartVideoEncoding {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  VideoUpload  $event
	 * @return void
	 */
	public function handle(VideoUpload $event)
	{
		$file = $event->getFile();
		\Queue::push('\Rve\Services\VideoEncoding@startEncoding', ['id' => $file->id, 'quality' => 'low']);
		\Queue::push('\Rve\Services\VideoEncoding@startEncoding', ['id' => $file->id, 'quality' => 'med']);
		\Queue::push('\Rve\Services\VideoEncoding@startEncoding', ['id' => $file->id, 'quality' => 'hi', 'last' => true]);
	}

}
