<?php

namespace App\Http\Controllers;

use App\Models\Console;
use Illuminate\Http\Request;

class ConsoleController
{

    // Display consoles by owner
    public function index()
    {
        $consoles = Console::with('owner')->get();
        return view('consoles.index', compact('consoles'));
    }

    // Store a new console
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string',
            'owner_id' => 'required|exists:console_owners,id',
        ]);

        Console::create($request->all());

        return redirect()->route('consoles.index');
    }

    // Show a specific console
    public function show($id)
    {
        $console = Console::findOrFail($id);
        return view('consoles.show', compact('console'));
    }

    // Edit an existing console
    public function edit($id)
    {
        $console = Console::findOrFail($id);
        $owners = ConsoleOwner::all();
        return view('consoles.edit', compact('console', 'owners'));
    }

    // Update a console
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string',
            'owner_id' => 'required|exists:console_owners,id',
        ]);

        $console = Console::findOrFail($id);
        $console->update($request->all());

        return redirect()->route('consoles.index');
    }

    // Delete a console
    public function destroy($id)
    {
        $console = Console::findOrFail($id);
        $console->delete();

        return redirect()->route('consoles.index');
    }
}
