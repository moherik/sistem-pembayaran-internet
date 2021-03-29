<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\PostMessageRequest;
use App\Models\Conversation;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TicketController extends Controller
{

    public function create(CreateTicketRequest $request)
    {
        $data = $request->validated();

        try {
            $ticket = Ticket::create([
                'user_id' => Auth::user()->id,
                'title' => $data['title'],
            ]);
            $conversation = Conversation::create([
                'ticket_id' => $ticket->id,
                'body' => $data['body'],
                'type' => 'TO'
            ]);
            return response()->json([
                'code' => 200,
                'status' => 'SUCCESS',
                'message' => 'Berhasil membuat tiket'
            ], 200);
        } catch (HttpException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }

    public function me()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->orderBy('created_at', 'ASC')->get();
        return response()->json($tickets, 200);
    }

    public function detail($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->where('user_id', Auth::user()->id)->first();
        return response()->json([
            'id' => $ticket->id,
            'title' => $ticket->title,
            'created_at' => $ticket->created_at,
            'creator' => $ticket->user->name,
            'conversations' => $ticket->conversations
        ], 200);
    }

    public function send(PostMessageRequest $request, $ticketId)
    {
        try {
            $ticket = Ticket::where('id', $ticketId)->where('user_id', Auth::user()->id)->firstOrFail();
            Conversation::create([
                'ticket_id' => $ticket->id,
                'body' => $request->body,
                'type' => 'TO'
            ]);
            return response()->json([
                'code' => 200,
                'status' => 'SUCCESS',
                'message' => 'Berhasil mengirim pesan'
            ], 200);
        } catch (HttpException $e) {
            return response()->json([
                'code' => $e->getCode(),
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }
}
