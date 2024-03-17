<?php

namespace App\Http\Controllers;

use App\Models\FBill;
use Illuminate\Http\Request;

/**
 * Class FBillController
 * @package App\Http\Controllers
 */
class FBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fBills = FBill::paginate();

        return view('f-bill.index', compact('fBills'))
            ->with('i', (request()->input('page', 1) - 1) * $fBills->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fBill = new FBill();
        return view('f-bill.create', compact('fBill'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FBill::$rules);

        $fBill = FBill::create($request->all());

        return redirect()->route('f-bills.index')
            ->with('success', 'FBill created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fBill = FBill::find($id);

        return view('f-bill.show', compact('fBill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fBill = FBill::find($id);

        return view('f-bill.edit', compact('fBill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FBill $fBill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FBill $fBill)
    {
        request()->validate(FBill::$rules);

        $fBill->update($request->all());

        return redirect()->route('f-bills.index')
            ->with('success', 'FBill updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $fBill = FBill::find($id)->delete();

        return redirect()->route('f-bills.index')
            ->with('success', 'FBill deleted successfully');
    }
}
