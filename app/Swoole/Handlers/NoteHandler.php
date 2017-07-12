<?php

namespace App\Swoole\Handlers;

use App\Note;

class NoteHandler extends BaseHandler
{
    public function __construct()
    {
        //
    }

    public function getNote($server, $data, $fd)
    {
        // cache room_id to swoole table
        app('swoole.table')->users->set($fd, [
            'room_id' => $data->note_id
        ]);
        $note = Note::find($data->note_id);
        $result = [
            'action' => 'getNote',
            'message' => $note->content
        ];
        $this->joinRoom($server, $data->note_id, $fd);

        $server->push($fd, json_encode($result));
    }

    public function changeNote($server, $data, $fd)
    {
        $data = [
            'action' => 'changeNote',
            'message' => $data->message
        ];
        $this->broadcast($server, json_encode($data), $fd);
    }
}