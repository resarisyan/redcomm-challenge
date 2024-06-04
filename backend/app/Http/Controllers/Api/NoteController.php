<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Http\Responses\PrettyJsonResponse;
use App\Models\Note;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(NoteRequest $request): JsonResponse
    {
        try {
            $notes = Note::where('title', 'like', "%$request->search%")
                ->orWhere('desc', 'like', "%$request->search%")
                ->orderBy('created_at', 'desc')
                ->paginate($request->per_page ?? 10);

            if ($notes->isEmpty()) {
                return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.note_not_found')], 404);
            }

            $notes->first_page_url = $notes->url(1);
            $notes->last_page_url = $notes->url($notes->lastPage());
        } catch (Exception $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.internal_server_error')], 500);
        }

        return new PrettyJsonResponse(['success' => true, 'message' => Lang::get('messages.get_note_api_success'), 'data' => $notes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NoteStoreRequest $request
     * @return JsonResponse
     */
    public function store(NoteStoreRequest $request): JsonResponse
    {
        try {
            $note = Note::create($request->validated());
        } catch (Exception $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.internal_server_error')], 500);
        }
        return new PrettyJsonResponse(['success' => true, 'message' => Lang::get('messages.create_note_api_success'), 'data' => $note], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NoteUpdateRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(NoteUpdateRequest $request, $id): JsonResponse
    {
        try {
            $note = Note::findOrFail($id);
            $note->update([
                'title' => $request->validated()['title'] ?? $note->title,
                'desc' => $request->validated()['desc'] ?? $note->desc,
            ]);
        } catch (ModelNotFoundException $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.note_not_found')], 404);
        } catch (Exception $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.internal_server_error')], 500);
        }
        Cache::put("notes_show_{$id}", $note, 60);
        return new PrettyJsonResponse(['success' => true, 'message' => Lang::get('messages.update_note_api_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $note = Note::findOrFail($id);
            $note->delete();
        } catch (ModelNotFoundException $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.note_not_found')], 404);
        } catch (Exception $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.internal_server_error')], 500);
        }
        Cache::forget("notes_show_{$id}");
        return new PrettyJsonResponse(['success' => true, 'message' => Lang::get('messages.delete_note_api_success')]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $cacheKey = "notes_show_{$id}";
        try {
            $note = Cache::remember($cacheKey, 60, function () use ($id) {
                return Note::findOrFail($id);
            });
        } catch (ModelNotFoundException $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.note_not_found')], 404);
        } catch (Exception $e) {
            return new PrettyJsonResponse(['success' => false, 'message' => Lang::get('messages.internal_server_error')], 500);
        }
        return new PrettyJsonResponse(['success' => true, 'message' => Lang::get('messages.get_note_api_success'), 'data' => $note]);
    }
}
