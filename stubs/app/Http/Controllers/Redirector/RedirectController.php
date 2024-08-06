<?php

namespace App\Http\Controllers\Redirector;

use App\Http\Requests\Redirector\RedirectRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mr1970\LaravelRedirector\Models\Redirect;

class RedirectController
{
    public function index(): View
    {
        $redirects = Redirect::all();
        return view('redirector.index', compact('redirects'));
    }

    public function create(): View
    {
        return view('redirector.create');
    }

    public function store(RedirectRequest $request): RedirectResponse
    {
        Redirect::create($request->validated());
        return to_route('redirects.index')
            ->with('success', __('Redirect created successfully.'));
    }

    public function edit(Redirect $redirect): View
    {
        return view('redirector.edit', compact('redirect'));
    }

    public function update(RedirectRequest $request, Redirect $redirect): RedirectResponse
    {
        $redirect->update($request->validated());
        return to_route('redirects.index')
            ->with('success', __('Redirect updated successfully.'));
    }

    public function destroy(Redirect $redirect): RedirectResponse
    {
        $redirect->delete();
        return back()->with('success', __('Redirect deleted successfully.'));
    }
}
