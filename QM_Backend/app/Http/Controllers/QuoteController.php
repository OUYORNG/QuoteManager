<?php
namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class QuoteController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', only: ['SaveQuote', 'getFavoriteQuotes', 'DeleteQuoteByID']),
        ];
    }

    public function getRandomQuote()
    {
        try {
            $response = Http::withoutVerifying()->get('https://api.quotable.io/random');

            if ($response->successful()) {
                return response()->json([
                    'content' => $response['content'],
                    'author' => $response['authorSlug']
                ]);
            }

            return response()->json([
                'error' => 'Failed to fetch quote',
                'message' => $response->body(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function SaveQuote(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $validated = $request->validate([
                'content' => 'required|string',
                'author' => 'required|string|max:255',
            ]);

            $quote = Quote::create([
                'user_id' => Auth::id(),
                'content' => $validated['content'],
                'author' => $validated['author'],
            ]);

            return response()->json([
                'message' => 'Quote created successfully',
                'quote' => $quote
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

    }

    public function DeleteQuoteByID($id)
    {
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['message' => 'Quote not found'], 404);
        }
        if ($quote->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $quote->delete();

        return response()->json(['message' => 'Quote deleted successfully'], 200);
    }

    public function getFavoriteQuotes(Request $request)
    {
        $quotes = Quote::where('user_id', Auth::id())->paginate($request->query('per_page', 10)); ;
        return response()->json([
            'message' => 'Quotes retrieved successfully',
            'quotes' => $quotes
        ], 200);
    }
}