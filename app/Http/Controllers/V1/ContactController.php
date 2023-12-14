<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ContactUsResource;
use App\Http\Resources\V1\SubcriberResource;
use App\Models\V1\ContactUs;
use App\Models\V1\Subscriber;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use HttpResponses;

    public function contact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'email', 'max:200'],
            'subject' => ['string', 'max:200'],
            'message' => ['required', 'string']
        ]);

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return $this->success(null, "Message sent successfully", 200);
    }

    public function getcontact()
    {
        $contact = ContactUs::get();
        $data = ContactUsResource::collection($contact);

        return $this->success($data, "", 200);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:subscribers,email']
        ]);

        Subscriber::create([
            'email' => $request->email
        ]);

        return $this->success(null, "You have been subscribed!", 200);
    }

    public function getsubscribe()
    {
        $subscribe = Subscriber::get();
        $data = SubcriberResource::collection($subscribe);

        return $this->success($data, "", 200);
    }
}
