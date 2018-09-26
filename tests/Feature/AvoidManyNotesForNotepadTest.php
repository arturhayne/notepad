<?php


namespace Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Appointments;

class AvoidManyNotesForNotepadTest extends TestCase
{

    public function it_should_not_allow_many_notes_per_notepad(){
        //DB::beginTransaction();
        $payload = '{"title":"artur", "content":"teste", "notepadId":"df4cfbe0-3bd9-4aeb-b3ab-b33491379302"}';
        $result = $this->call('POST', 'api/notes/create', $payload)->content();
        $this->expectException(\InvalidArgumentException::class);
        //DB::rollback();
    }
}