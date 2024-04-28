<?php

namespace App\Services\Portfolio;

use App\Models\V1\Talent;
use App\Models\V1\TalentPortfolio;
use App\Services\ImageKit\DeleteService;
use App\Services\ImageKit\ImageKitService;
use App\Traits\HttpResponses;

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

            $file = $request->portfolio['featured_image'];
            $folderName = "portfolio";
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            $parts = explode('@', $talent->email);
            $name = $parts[0];
            $path = $folderName . '/' . $name;

            $response = (new ImageKitService($file, $file_name, $path))->run();
            $data = $response->getData();

        } else {
            $data = [
                'url' => null,
                'file_id' => null
            ];
        }

        $talentproject = $talent->portfolios()->create([
            'title' => $request->portfolio['title'],
            'category_id' => $request->portfolio['category_id'],
            'description' => $request->portfolio['description'],
            'tags' => json_encode($request->portfolio['tags']),
            'link' => $request->portfolio['link'],
            'featured_image' => $data->url ?? $data['url'],
            'file_id' => $data->file_id ?? $data['file_id'],
            'is_draft' => $request->portfolio['is_draft']
        ]);

        foreach($request->portfolio['project_image'] as $image){

            $file = $image['image'];
            $folderName = "portfolio/";
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);

            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'_'.uniqid().'.'.$extension;
            $parts = explode('@', $talent->email);
            $name = $parts[0];
            $path = $folderName . $name . '/projectimages';

            $response = (new ImageKitService($file, $file_name, $path))->run();
            $data = $response->getData();

            $talentproject->portfolioprojectimage()->delete();
            $talentproject->portfolioprojectimage()->create([
                'talent_id' => $talent->id,
                'talent_portfolio_id' => $talentproject->id,
                'image' => $data->url,
                'file_id' => $data->file_id
            ]);
        }

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

            $file = $request->featured_image;
            $folderName = "portfolio";
            $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            $replace = substr($file, 0, strpos($file, ',')+1);
            $sig = str_replace($replace, '', $file);
            $sig = str_replace(' ', '+', $sig);
            $file_name = time().'.'.$extension;
            $parts = explode('@', $talent->email);
            $name = $parts[0];
            $path = $folderName . '/' . $name;

            $fileId = $port->file_id;
            (new DeleteService($fileId, null))->run();

            $response = (new ImageKitService($file, $file_name, $path))->run();
            $data = $response->getData();

        } else {
            $data = [
                'url' => null,
                'file_id' => null
            ];
        }

        $port->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'tags' => json_encode($request->tags),
            'link' => $request->link,
            'featured_image' => $data->url ?? $data['url'],
            'file_id' => $data->file_id ?? $data['file_id'],
            'is_draft' => $request->is_draft
        ]);

        if($request->project_image){
            foreach($request->project_image as $image){

                $file = $image['image'];
                $folderName = "portfolio/";
                $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
                $replace = substr($file, 0, strpos($file, ',')+1);
                $sig = str_replace($replace, '', $file);

                $sig = str_replace(' ', '+', $sig);
                $file_name = time().'_'.uniqid().'.'.$extension;
                $parts = explode('@', $talent->email);
                $name = $parts[0];
                $path = $folderName . $name . '/projectimages';

                $imageIds = $port->portfolioprojectimage->pluck('file_id')->toArray();
                (new DeleteService(null, $imageIds))->run();
                $port->portfolioprojectimage()->delete();

                $response = (new ImageKitService($file, $file_name, $path))->run();
                $data = $response->getData();

                $port->portfolioprojectimage()->create([
                    'talent_id' => $talent->id,
                    'talent_portfolio_id' => $port->id,
                    'image' => $data->url,
                    'file_id' => $data->file_id
                ]);
            }
        }

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
}

