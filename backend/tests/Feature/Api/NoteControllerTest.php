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
    //generate comment for all tests

    /**
     * Display a listing of the resource.
     * @test
     * @group api
     * @return void
     */
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

    /**
     * Store a newly created resource in storage.
     * @test
     * @group api
     * @return void
     */
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

    /**
     * Update the specified resource in storage.
     * @test
     * @group api
     * @return void
     */
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

    /**
     * Remove the specified resource from storage.
     * @test
     * @group api
     * @return void
     */
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

    /**
     * Display the specified resource.
     * @test
     * @group api
     * @return void
     */

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

    /**
     * Display the specified resource.
     * @test
     * @group api
     * @return void
     */
    public function test_search_note(): void
    {
        Note::factory()->count(5)->create();

        $note = Note::factory()->create();

        $this->get(route('api.v1.notes.searchPaginate', $note->title))
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
}
