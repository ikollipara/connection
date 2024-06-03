<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFrequentlyAskedQuestionRequest;
use App\Http\Requests\UpdateFrequentlyAskedQuestionRequest;
use App\Models\FrequentlyAskedQuestion;
use Illuminate\Http\Request;

class FrequentlyAskedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("frequently-asked-questions.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("frequently-asked-questions.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFrequentlyAskedQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFrequentlyAskedQuestionRequest $request)
    {
        $validated = $request->validated();
        $validated["content"] ??= "";
        $validated["user_id"] = auth()->id();
        $question = FrequentlyAskedQuestion::create($validated);

        return redirect()
            ->route("faq.show", compact("question"))
            ->with(
                "success",
                __(
                    "Your question has been submitted. We will get back to you soon.",
                ),
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FrequentlyAskedQuestion  $question
     * @return \Illuminate\Http\Response
     */
    public function show(FrequentlyAskedQuestion $question)
    {
        return view("frequently-asked-questions.show", compact("question"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(FrequentlyAskedQuestion $frequentlyAskedQuestion)
    {
        return view("frequently-asked-questions.edit", [
            "question" => $frequentlyAskedQuestion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFrequentlyAskedQuestionRequest  $request
     * @param  \App\Models\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateFrequentlyAskedQuestionRequest $request,
        FrequentlyAskedQuestion $frequentlyAskedQuestion
    ) {
        $safe = $request->safe();
        $frequentlyAskedQuestion->update($safe);

        return redirect()
            ->route(
                "frequently-asked-questions.show",
                $frequentlyAskedQuestion->id,
            )
            ->with(
                "success",
                __("The question has been updated successfully."),
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrequentlyAskedQuestion $frequentlyAskedQuestion)
    {
        if ($frequentlyAskedQuestion->is_answered) {
            return redirect()
                ->route(
                    "frequently-asked-questions.show",
                    $frequentlyAskedQuestion->id,
                )
                ->with(
                    "error",
                    __("You cannot delete a question that has been answered."),
                );
        }
        $frequentlyAskedQuestion->delete();
        return redirect()
            ->route("frequently-asked-questions.index")
            ->with(
                "success",
                __("The question has been deleted successfully."),
            );
    }
}
