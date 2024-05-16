<?php

namespace App\Services\Portfolio;

use App\Models\V1\Talent;
use App\Models\V1\TalentPortfolio;
use App\Services\ImageKit\DeleteService;
use App\Services\ImageKit\ImageKitService;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\App;

class PortfolioService
{
    use HttpResponses;

    public function createPortfolio($user, $request)
    {
        $talent = Talent::where('email', $user->email)->first();

        if(!$talent){
            return $this->error('', 401, 'Error');
        }

        if($request->portfolio['featured_image']){

            $data = $this->handleImageUpload($request->portfolio['featured_image'], $talent, null);

        } else {
            $data = $this->handleNoFeaturedImage();
        }

        $talentproject = $talent->portfolios()->create([
            'title' => $request->portfolio['title'],
            'category_id' => $request->portfolio['category_id'],
            'description' => $request->portfolio['description'],
            'tags' => json_encode($request->portfolio['tags']),
            'link' => $request->portfolio['link'],
            'featured_image' => $data->url ?? $data['url'] ?? $data,
            'file_id' => $data->file_id ?? $data['file_id'] ?? $data,
            'is_draft' => $request->portfolio['is_draft']
        ]);

        $this->handleProjectImages($request->portfolio['project_image'], $talent, $talentproject);

        return $this->success(null, "Created Successfully");
    }

    public function updatePortfolio($user, $request)
    {
        $talent = Talent::where('email', $user->email)->first();

        $port = TalentPortfolio::where('id', $request->id)->first();

        if(!$port){
            return $this->error('', 400, 'Does not exist');
        }

        if($request->featured_image){

            $data = $this->handleImageUpload($request->featured_image, $talent, $port);

        } else {
            $data = $this->handleNoFeaturedImage();
        }

        $port->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'tags' => json_encode($request->tags),
            'link' => $request->link,
            'featured_image' => $data->url ?? $data['url'] ?? $data,
            'file_id' => $data->file_id ?? $data['file_id'] ?? $data,
            'is_draft' => $request->is_draft
        ]);

        $this->handleProjectImages($request->project_image, $talent, $port);

        return $this->success(null, "Updated Successfully");
    }

    public function deletePortfolio($user, $id)
    {
        $talent = Talent::where('email', $user->email)->first();

        if(!$talent){
            return $this->error('', 400, 'User does not exist');
        }

        $port = TalentPortfolio::where('talent_id', $talent->id)
        ->where('id', $id)->first();

        if(!$port){
            return $this->error('', 400, 'Does not exist');
        }

        $fileId = $port->file_id;
        (new DeleteService($fileId, null))->run();

        $imageIds = $port->portfolioprojectimage->pluck('file_id')->toArray();
        (new DeleteService(null, $imageIds))->run();

        $port->portfolioprojectimage()->delete();
        $port->delete();

        return $this->success(null, "Deleted successfully");
    }

    private function handleImageUpload($image, $talent, $port = null)
    {
        if(App::environment('production')){

            $file = $image;
            $folderName = "portfolio";
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            $parts = explode('@', $talent->email);
            $name = $parts[0];
            $path = $folderName . '/' . $name;

            if($port !== null){
                $fileId = $port->file_id;
                (new DeleteService($fileId, null))->run();
            }

            $response = (new ImageKitService($file, $file_name, $path))->run();
            $data = $response->getData();

        } elseif(App::environment('staging') || App::environment('local')){

            $file = $image;
            $folderName = config('services.portfolio.base_url');
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = uniqid().'.'.$extension;

            $path = public_path().'/portfolio/'.$file_name;
            $success = file_put_contents($path, base64_decode($sig));

            if ($success === false) {
                throw new \Exception("Failed to write file to disk.");
            }

            $data = $folderName.'/'.$file_name;
        }

        return $data;
    }

    private function handleNoFeaturedImage()
    {
        if (App::environment('production')) {
            return [
                'url' => null,
                'file_id' => null
            ];
        } elseif (App::environment('staging') || App::environment('local')) {
            return '';
        }
    }

    private function handleProjectImages($projectImages, $talent, $port)
    {
        if (App::environment('production')) {
            $imageIds = $port->portfolioprojectimage->pluck('file_id')->toArray();
            (new DeleteService(null, $imageIds))->run();
            $port->portfolioprojectimage()->delete();
        } else {
            $port->portfolioprojectimage()->delete();
        }

        foreach ($projectImages as $image) {
            $file = $image['image'];
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'_'.uniqid().'.'.$extension;

            if (App::environment('production')) {
                $folderName = "portfolio/";
                $parts = explode('@', $talent->email);
                $name = $parts[0];
                $path = $folderName . $name . '/projectimages';
                
                $response = (new ImageKitService($file, $file_name, $path))->run();
                $data = $response->getData();

                $port->portfolioprojectimage()->create([
                    'talent_id' => $talent->id,
                    'talent_portfolio_id' => $port->id,
                    'image' => $data->url,
                    'file_id' => $data->file_id
                ]);
            } elseif (App::environment('staging') || App::environment('local')) {
                $folderName = config('services.portfolio.project_image');
                $folderPath = 'public/portfolio/projectimages';

                // Create folder if it doesn't exist
                if (!file_exists(public_path($folderPath))) {
                    mkdir(public_path($folderPath), 0777, true);
                }

                $path = public_path().'/portfolio/projectimages/'.$file_name;
                $success = file_put_contents($path, base64_decode($sig));

                if ($success === false) {
                    throw new \Exception("Failed to write file to disk.");
                }

                $url = $folderName.'/'.$file_name;

                $port->portfolioprojectimage()->create([
                    'talent_id' => $talent->id,
                    'talent_portfolio_id' => $port->id,
                    'image' => $url
                ]);
            }
        }
    }


}

