<?php

namespace App\Helpers;

use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Helper
{
    static function getLoggedInUserDetails(){
        $user = [];
        $user['user_id'] = Auth::user()->id;
        return $user;
    }

    static function commonConnections($userData, $friendId)
    {
        $userConnections = [];
        $friendConnections = [];
        $commonConnections = [];

        $userConnectionsAsARequester = Request::where('requester_id', $userData['user_id'])
        ->where('request_status', Constants::ACCEPTED)
        ->pluck('requested_to_id')
        ->toArray();

        $userConnectionsByARequester = Request::where('requested_to_id', $userData['user_id'])
        ->where('request_status', Constants::ACCEPTED)
        ->pluck('requester_id')
        ->toArray();

        $userConnections = array_merge( $userConnectionsAsARequester , $userConnectionsByARequester );

        $friendConnectionsAsARequester = Request::where('requester_id', $friendId)
        ->where('request_status', Constants::ACCEPTED)
        ->pluck('requested_to_id')
        ->toArray();

        $friendConnectionsByARequester = Request::where('requested_to_id', $friendId)
        ->where('request_status', Constants::ACCEPTED)
        ->pluck('requester_id')
        ->toArray();

        $friendConnections = array_merge( $friendConnectionsAsARequester , $friendConnectionsByARequester );

        foreach($userConnections as $uc)
        {
            foreach($friendConnections as $fc)
            {
                if($uc == $fc)
                {
                    $getCommonConnectionUserDetails = User::getCommonConnectionUserDetails($fc);
                    array_push($commonConnections, $getCommonConnectionUserDetails);
                }
            }
        }

        return $commonConnections;
    }

    static function getUserData($data)
    {
        return User::select('id', 'name', 'email')
            ->whereIn('id', $data)
            ->get()
            ->toArray();
    }
}
