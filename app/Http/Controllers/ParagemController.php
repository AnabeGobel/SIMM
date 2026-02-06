<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paragem;

class ParagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validacao do registo
        $request->validate([
            'nome' => 'required|string|max:100',
            'bairro' => 'required|string|max:100',
        ]);

        Paragem::create([
            'nome' => $request->nome,
            'bairro' => $request->bairro,
        ]);

        return redirect()->back()->with('success', 'Paragem cadastrada com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
