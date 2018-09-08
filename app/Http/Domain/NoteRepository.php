<?php

namespace App\Http\Domain;

interface NoteRepository
{
    public function nextId();
    public function create($id,$title,$content);
}