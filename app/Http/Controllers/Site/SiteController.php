<?php

namespace App\Http\Controllers\Site;

use App\Models\Message;
use App\Models\Subscriber;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\StoreSubscriberRequest;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.pages.index', get_defined_vars());
    }

    public function about()
    {
        return view('site.pages.about', get_defined_vars());
    }

    public function service()
    {
        return view('site.pages.service', get_defined_vars());
    }

    public function contact()
    {
        return view('site.pages.contact', get_defined_vars());
    }

    public function subscriberStore(StoreSubscriberRequest $request)
    {
        $data = $request->validated();
        Subscriber::create($data);
        return back()->with('subscriber_success_msg', 'Subscribed Successfully');
    }

    public function contactStore(StoreMessageRequest $request)
    {
        $data = $request->validated();
        Message::create($data);
        return back()->with('success', 'Your Message sent Successfully');
    }
}
