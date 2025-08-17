<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendContactMessage;
use Illuminate\Validate\ValidationException;

class ContactMessageController extends Controller
{
    public function send(ContactMessageRequest $request){

        $success = true;
        try{
            Mail::to('info@vzero.eu')->send(new SendContactMessage($request));
        }
        catch (\Illuminate\Validation\ValidationException $exception){
            $success = $exception->getMessage();
        }
        if($success == 'true'){
            return response()->json(['text' => __('messages.respuesta_email')]);
        }
        else{
            return response()->json(['text' => $success]);
        }

    }
}
