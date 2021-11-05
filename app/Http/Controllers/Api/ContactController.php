<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Admin;
use App\Mail\User;
use Illuminate\Http\Request;
use Throwable;

class ContactController extends Controller
{
    public function contact(ContactRequest $request)
    {
        if (!$request->title) {
            try {
                $mail_data = [
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'logo' => asset('/storage/images/initialize/logo.png'),
                ];

                Mail::to('truwork@truwork.cz')
                    ->send(new Admin($mail_data));

                Mail::to($mail_data['email'])
                    ->send(new User($mail_data));

            } catch (Throwable $e) {
                report($e);
                return response()->json(['message' => ' Je nám líto, ale odeslání formuláře se bohužel nezdařilo. Kontaktujte prosím správce webu, nebo to zkuste později.'], 500);
            }

        }
        return response()->json(['message' => 'Děkujeme za zprávu. Pokusíme se Vás co nejdříve kontaktovat :)']);
    }
}
