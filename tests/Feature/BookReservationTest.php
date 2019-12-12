<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_be_add_to_library(){

        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => "My first book",
            'author' => "oussama"
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /**
     * @test
     */
    public function a_titel_is_required(){

        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Oussama'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_author_is_required(){

        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'New Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated(){

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => "My first book",
            'author' => "oussama"
        ]);
        $book = Book::first();
        $response = $this->patch('/books/'.$book->id, [
           'title' => 'New Title',
           'author' => 'New author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
    }
}
