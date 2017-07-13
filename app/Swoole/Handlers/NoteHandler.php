<?php

namespace App\Swoole\Handlers;

use App\Note;

class NoteHandler extends BaseHandler
{
    public function __construct()
    {
        //
    }

    public function get($server, $data, $fd)
    {
        // cache room_id to swoole table
        app('swoole.table')->users->set($fd, [
            'room_id' => $data->note_id
        ]);
        // get note
        $note = Note::find($data->note_id);
        $noteResult = [
            'action' => 'getNote',
            'message' => $note->content
        ];
        // put user fd to note room
        $this->joinRoom($server, $data->note_id, $fd);
        // return note
        $server->push($fd, json_encode($noteResult));
        // sync online diffs
        $this->syncDiff($server, $fd, $data->note_id);
    }

    public function change($server, $data, $fd)
    {
        $result = [
            'action' => 'changeNote',
            'message' => $data->message
        ];
        $this->broadcast($server, $data->note_id, json_encode($result), $fd);
    }

    public function diff($server, $data, $fd)
    {
        // cache note diff to swoole table
        app('swoole.table')->diffs->set($data->note_id, [
            'id' => $fd,
            'content' => $data->message
        ]);
    }
}