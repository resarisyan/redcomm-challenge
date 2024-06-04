<?php

namespace Tests\Feature\Api;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_all_notes(): void
    {
        Note::factory()->count(5)->create();

        $this->get(route('api.v1.notes.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'desc',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active',
                        ],
                    ],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ]);
    }

    public function test_get_all_notes_with_parameters(): void
    {
        Note::factory()->count(5)->create();
        $this->get(route('api.v1.notes.index', ['per_page' => 2, 'page' => 2]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'desc',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active',
                        ],
                    ],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ]);
    }

    public function test_search_notes(): void
    {
        $note = Note::factory()->create();

        $this->get(route('api.v1.notes.index', ['search' => $note->title]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'desc',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active',
                        ],
                    ],
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ]);
    }

    public function test_search_notes_not_found(): void
    {
        $this->get(route('api.v1.notes.index', ['search' => 'not found']))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }


    public function test_store_note(): void
    {
        $note = Note::factory()->make()->toArray();

        $this->post(route('api.v1.notes.store'), $note)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'title',
                    'desc',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_store_note_validation(): void
    {
        $this->post(route('api.v1.notes.store'), [])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => [
                    'title',
                    'desc',
                ],
            ]);
    }

    public function test_update_note(): void
    {
        $note = Note::factory()->create();
        $data = Note::factory()->make()->toArray();
        $this->put(route('api.v1.notes.update', $note->id), $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function test_update_note_not_found(): void
    {
        $data = Note::factory()->make()->toArray();
        $this->put(route('api.v1.notes.update', 1000), $data)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function test_update_note_validation(): void
    {
        $note = Note::factory()->create();
        $this->put(route('api.v1.notes.update', $note->id), ['title' => 1, 'desc' => 1])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => [
                    'title',
                    'desc',
                ],
            ]);
    }

    public function test_delete_note(): void
    {
        $note = Note::factory()->create();

        $this->delete(route('api.v1.notes.destroy', $note->id))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function test_delete_note_not_found(): void
    {
        $this->delete(route('api.v1.notes.destroy', 1000))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }

    public function test_show_note(): void
    {
        $note = Note::factory()->create();

        $this->get(route('api.v1.notes.show', $note->id))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'title',
                    'desc',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_show_note_not_found(): void
    {
        $this->get(route('api.v1.notes.show', 1000))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'success',
                'message',
            ]);
    }
}
