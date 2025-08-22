<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Liste des messages pour l'admin
    public function inbox()
    {
        $user = Auth::user();
        $messages = Message::where('receiver_id', $user->id)->latest()->get();
        return view('messages.inbox', compact('messages'));
    }

    // Formulaire pour envoyer un message
    public function create()
    {
        $admins = User::where('role', 'admin')->get();
        return view('messages.create', compact('admins'));
    }

    // Envoi du message
  public function store(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'body' => 'required|string',
        'receiver_id' => 'required|exists:users,id',
    ]);

    Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'subject' => $request->subject,
        'body' => $request->body,
    ]);

    return redirect()->back()->with('success', 'Message envoyé avec succès ✅');
}


    // Afficher un message
    public function show(Message $message)
    {
        if(Auth::id() == $message->receiver_id) {
            $message->update(['read' => true]);
        }
        return view('messages.show', compact('message'));
    }
    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())->latest()->get();
        return view('messages.sent', compact('messages'));
    }
    

    // Formulaire pour répondre
public function reply(Message $message)
{
    // L'admin peut répondre à tout message reçu
    if(Auth::user()->role !== 'admin') {
        abort(403);
    }

    return view('messages.reply', compact('message'));
}

// Envoi de la réponse
public function sendReply(Request $request, Message $message)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'body' => 'required|string',  // <-- correspond à la colonne DB
    ]);

    Message::create([
        'sender_id' => Auth::id(),              // Admin
        'receiver_id' => $message->sender_id,   // Technicien
        'subject' => 'Re: ' . $request->subject,
        'body' => $request->body,               // <-- utiliser 'body'
        'read' => false,
    ]);

    return redirect()->route('messages.inbox')->with('success', 'Réponse envoyée avec succès ✅');
}



}

