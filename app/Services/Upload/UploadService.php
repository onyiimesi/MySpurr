<?php

namespace App\Services\Upload;

use App\Services\ImageKit\ImageKitService;
use Illuminate\Support\Facades\App;

class UploadService
{
    protected $folder;
    protected $file;

    public function __construct($folder, $file)
    {
        $this->folder = $folder;
        $this->file = $file;
    }

    public function run()
    {
        if(App::environment('production')){

            $file = $this->file;
            $folderName = $this->folder;
            $folderPath = time() . '.' . $file->getClientOriginalExtension();
            $response = (new ImageKitService(base64_encode($file->get()), $folderPath, $folderName))->run();
            $data = $response->getData();

        } elseif(App::environment(['staging', 'local'])){

            $file = $this->file;
            $filename = time() . rand(10, 1000) . '.' . $file->extension();
            $file->move(public_path($this->folder), $filename, 'public');

            $data = config('services.base_url') . $this->folder.'/' . $filename;
        }

        return $data;
    }
}

