<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Services\CommentService;

class CommentController extends Controller
{


    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function addComment(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        try {
            $comment = $this->commentService->addCommentToPost($id, $validated);
    
            return response()->json([
                'status' => true,
                'message' => 'Comment added successfully.',
                'data' => $comment
            ], 201); // ✅ تم الإنشاء بنجاح
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found.',
            ], 404); // ✅ لم يتم العثور على البوست
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error.',
                'errors' => $e->errors(),
            ], 422); // ✅ خطأ في التحقق
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error.',
                'error' => $e->getMessage()
            ], 500); // ✅ خطأ داخلي
        }
    }
    
}
