<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    private const SUBJECTS = ['Question', 'Suggestion', 'Complaint'];

    public function create()
    {
        return view('feedback.create', ['subjects' => self::SUBJECTS]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email',
            'subject' => ['required', Rule::in(self::SUBJECTS)],
            'message' => 'required|string|min:10|max:1000',
        ]);
        $data['created_at'] = now()->toDateTimeString();

        $file = 'feedback/'.now()->format('Y-m-d_His').'_'.Str::uuid().'.json';
        Storage::put($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('feedback.create')->with('success', 'Your feedback has been saved.');
    }

    public function index()
    {
        // ponytail: reads every file per request, move to a DB if submissions grow large
        $items = collect(Storage::files('feedback'))
            ->sortDesc()
            ->map(fn ($file) => json_decode(Storage::get($file), true));

        return view('feedback.index', ['items' => $items]);
    }
}
