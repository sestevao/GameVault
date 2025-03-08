<?php

namespace App\Http\Controllers;

use App\Models\ConsoleOwner;
use Illuminate\Http\Request;

class ConsoleOwnerController
{
    public function index()
    {
        $owners = ConsoleOwner::all();
        return view('console_owners.index', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        ConsoleOwner::create($request->all());

        return redirect()->route('console_owners.index');
    }

    public function show($id)
    {
        $owner = ConsoleOwner::findOrFail($id);
        return view('console_owners.show', compact('owner'));
    }

    public function edit($id)
    {
        $owner = ConsoleOwner::findOrFail($id);
        return view('console_owners.edit', compact('owner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        $owner = ConsoleOwner::findOrFail($id);
        $owner->update($request->all());

        return redirect()->route('console_owners.index');
    }

    public function destroy($id)
    {
        $owner = ConsoleOwner::findOrFail($id);
        $owner->delete();

        return redirect()->route('console_owners.index');
    }
}
