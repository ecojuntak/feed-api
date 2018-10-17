<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feed;
use App\Http\AMQP\Sender;

class FeedController extends Controller
{
    public function index() {
        return Feed::all();
    }

    public function get_by_hashtag_name(Request $request) {
        $str_id_only = preg_replace("/[^\d]/", ",", $request->ids);
        $ids = explode(',', $str_id_only);
        $feeds = Feed::whereIn('id', $ids)->get();
        
        return response()->json($feeds);
    }

    public function store(Request $request) {
        $feed = Feed::create($request->all());

        if($feed) {
            $this->send_to_message_broker(
                json_encode(
                    [
                        'id' => $feed->id,
                        'caption' => $feed->caption,
                    ]
                )
            );
        }
    }

    private function send_to_message_broker($message) {
        $sender = new Sender();
        $sender->send_message($message);
    }
}
