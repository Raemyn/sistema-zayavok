<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadStoreRequest;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    // Создать заявку (POST /api/leads)
    public function store(LeadStoreRequest $request)
    {
        $lead = Lead::create($request->validated());
        return response()->json($lead, 201);
    }

    // Список всех заявок с фильтром, поиском и пагинацией (GET /api/leads)
    public function index(Request $request)
    {
        $query = Lead::query();

        // Фильтр по статусу
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Фильтр по источнику
        if ($request->has('source_id')) {
            $query->where('source_id', $request->source_id);
        }

        // Поиск по name, email, phone
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        // Пагинация
        $perPage = $request->get('per_page', 10);
        $leads   = $query->paginate($perPage);

        return response()->json($leads, 200);
    }

    // Показ одной заявки (GET /api/leads/{id})
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return response()->json($lead, 200);
    }

    // Обновить заявку (PUT /api/leads/{id})
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'sometimes|required|string|max:255',
            'message'   => 'sometimes|required|string',
            'email'     => 'sometimes|nullable|email',
            'phone'     => 'sometimes|nullable|string|max:50',
            'status'    => ['sometimes', Rule::in(['new', 'in_progress', 'done', 'rejected'])],
            'source_id' => 'sometimes|nullable|exists:sources,id',
        ]);

        // Объединяем текущие значения и новые данные
        $data = array_merge($lead->only(['email', 'phone']), $validated);

        // Проверка: хотя бы один контакт есть
        if (empty($data['email']) && empty($data['phone'])) {
            return response()->json([
                'message' => 'Нужно указать email или телефон',
                'errors'  => [
                    'email' => ['Нужно указать email или телефон'],
                    'phone' => ['Нужно указать email или телефон'],
                ],
            ], 422);
        }

        // Обновляем только переданные поля
        $lead->update($validated);

        return response()->json($lead, 200);
    }

    // Удалить заявку (soft delete) (DELETE /api/leads/{id})
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return response()->json(null, 204);
    }
}
