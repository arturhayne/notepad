<?php

namespace Notepad\Infrastructure\Projection;

use Notepad\Domain\Event\NoteCreated;


class NoteCreatedProjection implements Projection{

   // private $client;

    //public function __construct(Client $clinet){
   //     $this->client=$client;
   // }

   public function listenTO(){
       return NoteCreated::class;
   }

   public function project($event){
       
   }

}