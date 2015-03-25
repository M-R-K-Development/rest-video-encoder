<?php 
/**
 * Video encoding worker
 */
namespace Rve\Services;

class VideoEncoding {
  /**
   * Start Encoding of a file.
   */
  public function startEncoding($job, $data) {
    $quality = $data['quality'];
    $fileId = $data['id'];
    $file = \Rve\Models\File::find($fileId);

    $file->status = 'encoding';
    $file->save();
    $links = json_decode($file->links, true);
    $videoFile = storage_path('user-data' . $file->path);
    if (file_exists($videoFile)) {
      
      $links[$quality] = env('PUBLIC_URL', 'http://localhost').'/videos/'.$this->encode($videoFile, $quality);
      
      $file->links = json_encode($links);
      if (isset($data['last'])) {
        $file->status = 'ready';
      }
      $file->save();
      $job->delete();
    } else {
      dd('File does not exist.');
    }
    
  }


  private function encode($file, $quality = 'low') {
    $qualities = [
      'low' => '426x240',
      'med' => '924x540',
      'hi' => '1280x720',
    ];

    $pathinfo = pathinfo($file);
    $filename = $pathinfo['filename'].'_'.$quality.'.mp4';
    $output   = $pathinfo['dirname'] . '/' . $filename;
    $command = sprintf('ffmpeg -i "%s" -y -c:v libx264 -preset medium  -s '.$qualities[$quality].' -r 25 -profile:v baseline -level 3.0  "%s"', $file, $output);
    exec($command);
    
    $destination = public_path('videos/'.$filename);
    rename($output, $destination);  
    return $filename;
  }
}
