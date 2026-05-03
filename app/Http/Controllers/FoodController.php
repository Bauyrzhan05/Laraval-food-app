<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('foods.index', compact('foods'));
    }

    public function create()
    {
        return view('foods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($validated);

        return redirect('/foods')->with('success', __('app.messages.food_created'));
    }

    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($food->image) {
                Storage::disk('public')->delete($food->image);
            }

            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($validated);

        return redirect('/foods')->with('success', __('app.messages.food_updated'));
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);

        if ($food->image) {
            Storage::disk('public')->delete($food->image);
        }

        $food->delete();

        return redirect('/foods')->with('success', __('app.messages.food_deleted'));
    }
}
