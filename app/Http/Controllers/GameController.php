<?php

namespace App\Http\Controllers;

use App\Models\Console;
use App\Models\ConsoleOwner;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function index()
    {
        $owners = ConsoleOwner::all();
        $consoles = Console::with('owner')->get();
        $genres = Genre::all();

        $groupedConsoles = $consoles->groupBy('owner_id');

        $games = Game::with(['console', 'genre'])->paginate(12);

        return view('app', [
            'games' => $games,
            'owners' => $owners,
            'groupedConsoles' => $groupedConsoles,
            'genres' => $genres,
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Game Store Request: ' . collect($request->all()));
        Log::info('Files: ', $request->file());

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'console_id' => 'required|exists:consoles,id',
                'genre_id' => 'required|exists:genres,id',
                'notes' => 'nullable|string|max:255',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'additional-cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed: ' . $validator->errors());
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $game = Game::create([
                'title' => $request->title,
                'console_id' => $request->console_id,
                'genre_id' => $request->genre_id,
                'notes' => $request->notes,
                'is_psn' => $request->is_psn,
            ]);

            if ($request->hasFile('cover')) {
                try {
                    $image = $request->file('cover');
                    $imagePath = $image->store( 'public');

                    $imageRecord = Image::create([
                        'file_path' => $imagePath,
                        'file_name' => $game-> title . $image->extension(),
                        'mime_type' => $image->getMimeType(),
                        'size' => $image->getSize(),
                        'width' => $image->getWidth(),
                        'height' => $image->getHeight()
                    ]);

                    $game->cover_id = $imageRecord->id;
                    $game->save();
                } catch (\Exception $e) {
                    Log::error('Error creating cover: ' . $e->getMessage());
                    return response()->json([ 'error', 'There was an error creating the cover. Please try again.'], 422);
                }
            }

            if ($request->hasFile('additional-cover')) {
                try {
                    $additionalCover = $request->file('additional-cover');
                    $additionalCoverPath = $additionalCover->store( 'public');

                    $additionalCoverRecord = Image::create([
                        'file_path' => $additionalCoverPath,
                        'file_name' => $game->title.'-additional'.$additionalCover->extension(),
                        'mime_type' => $additionalCover->getMimeType(),
                        'size' => $additionalCover->getSize(),
                        'width' => $additionalCover->getWidth(),
                        'height' => $additionalCover->getHeight()
                    ]);

                    $game->additional_cover_id = $additionalCoverRecord->id;
                    $game->save();
                } catch (\Exception $e) {
                    Log::error('Error creating additional cover: ' . $e->getMessage());
                    return response()->json([ 'error', 'There was an error creating the additional cover. Please try again.'], 422);
                }
            }

            Log::info('Game created successfully!');
            return response()->json(['success', 'Game created successfully!', 'game' => $game], 201);
        } catch (\Exception $e) {
            Log::error('Error creating game: ' . $e->getMessage());
            return response()->json([
                'error' => 'There was an error creating the game. Please try again.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        if ($game) {
            $game->title = $request->title;
            $game->console_id = $request->console_id;
            $game->genre_id = $request->genre_id;
            $game->notes = $request->notes;

            $game->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function destroy($id)
    {
        $game = Game::find($id);
        if ($game) {
            $game->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
