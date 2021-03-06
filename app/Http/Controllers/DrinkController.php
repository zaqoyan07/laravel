<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drink;
use Illuminate\Support\Facades\Auth;

class DrinkController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
             if (Auth::user()->role != "admin") {
                abort("404");
             }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drinks = Drink::all()->toarray();
        return view('admin/drinks/index',[ 'drinks' => $drinks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/drinks/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
            'size' => $request->input('size'),
            'price' => $request->input('price'),
        ];
         if(Drink::insert($data)){
            return redirect()->route('drinks');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drinks = Drink::find($id)->toarray();
        return view('admin/drinks/edit',['drinks' => $drinks]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $id = $request->input('id');
        $data = [
            'title' => $request->input('title'),
            'image' => $request->input('image'),
            'description' => $request->input('description'),
            'size' => $request->input('size'),
            'price' => $request->input('price'),
        ];
        Drink::find($id)->update($data);
        return redirect()->route('drinks');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Drink::destroy($id);
        return redirect()->route('drinks');
    }
}
