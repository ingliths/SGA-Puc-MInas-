<?php

namespace App\Http\Controllers;

use App\Domain\Ticket;
use App\Domain\TicketEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    function tickets(): JsonResponse
    {
        try {
            $tickets = Ticket::all();

            $tickets = $tickets->map(function ($item){
                $item->entries = $item->entries()->latest()->get();
                return $item;
            });

            return $this->sendResponse($tickets->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function ticketStore(Request $request): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "pedido_id" => "required",
                "client" => "required",
                "description" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
            (new Ticket())->save($request->all());
            return $this->sendResponse(Ticket::query()->latest()->first()->toArray(), 'Ticket criada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function ticketShow(string $id): JsonResponse
    {
        try {
            $model = Ticket::query()->findOrFail($id);
            $model->entries = $model->entries()->get();
            return $this->sendResponse($model->toArray());
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

    function ticketEntryStore(Request $request, string $id): JsonResponse
    {
        try {
            $errors = Validator::make($request->all(), [
                "text" => "required",
            ]);

            if ($errors->fails()) {
                return $this->sendBadRequest('Dados Inválidos', $errors->errors()->all());
            }
                $ticket  = new TicketEntry();
                $ticket->fill($request->all());
                $ticket->ticket_id = $id;
                $ticket->user = auth()->user()->id;
                $ticket->save();
            return $this->sendResponse(TicketEntry::query()->latest()->first()->toArray(), 'Ticket Entry criada');
        } catch (\Exception $ex) {
            return $this->sendError('Error', $ex);
        }
    }

}
