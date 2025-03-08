<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre = Genre::create([
            'name' => $request->name,
        ]);

        return redirect()->route('/')->with('success', 'Genre created successfully!');
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
