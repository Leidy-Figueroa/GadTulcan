<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use Illuminate\Http\Request;

/**
 * Class DetalleController
 * @package App\Http\Controllers
 */
class DetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detalles = Detalle::paginate();

        return view('detalle.index', compact('detalles'))
            ->with('i', (request()->input('page', 1) - 1) * $detalles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $detalle = new Detalle();
        return view('detalle.create', compact('detalle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Detalle::$rules);

        $detalle = Detalle::create($request->all());

        return redirect()->route('detalles.index')
            ->with('success', 'Detalle created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalle = Detalle::find($id);

        return view('detalle.show', compact('detalle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detalle = Detalle::find($id);

        return view('detalle.edit', compact('detalle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Detalle $detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detalle $detalle)
    {
        request()->validate(Detalle::$rules);

        $detalle->update($request->all());

        return redirect()->route('detalles.index')
            ->with('success', 'Detalle updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $detalle = Detalle::find($id)->delete();

        return redirect()->route('detalles.index')
            ->with('success', 'Detalle deleted successfully');
    }
}
