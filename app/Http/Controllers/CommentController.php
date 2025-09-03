<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Lead;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Список комментариев к заявке
    public function index($leadId)
    {
        $lead     = Lead::findOrFail($leadId);
        $comments = $lead->comments; // предполагается, что в Lead есть relation comments()
        return response()->json($comments, 200);
    }

    // Создать комментарий к заявке
    public function store(Request $request, $leadId)
    {
        $lead = Lead::findOrFail($leadId);

        $comment = $lead->comments()->create([
            'body'    => $request->input('body'),
            'user_id' => $request->user()->id, // текущий автор, если через Sanctum
        ]);

        return response()->json($comment, 201);
    }

    // Удалить комментарий
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(null, 204);
    }
}
