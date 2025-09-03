<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    // Список источников
    public function index()
    {
        $sources = Source::all();
        return response()->json($sources, 200);
    }

    // Создать источник
    public function store(Request $request)
    {
        $source = Source::create([
            'name' => $request->input('name')
        ]);

        return response()->json($source, 201);
    }

    // Обновить источник
    public function update(Request $request, $id)
    {
        $source = Source::findOrFail($id);
        $source->update([
            'name' => $request->input('name')
        ]);

        return response()->json($source, 200);
    }

    // Удалить источник
    public function destroy($id)
    {
        $source = Source::findOrFail($id);
        $source->delete();
        return response()->json(null, 204);
    }
}
