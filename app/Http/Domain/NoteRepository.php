<?php

namespace App\Http\Domain;
use App\Note;

interface NoteRepository
{
    public function nextId();
    public function create($id,$title,$content);
    public function find($id);
    public function delete(Note $note);
    public function list();
}