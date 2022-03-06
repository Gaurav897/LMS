<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $add = Address::where('user_id',Auth::id())->get();
        $add = Rent::all();
     
        return response()->json([
            'message' => ' successfully ',
            'data' => $add
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'bookId' => 'required|min:1|string',
            
          ]);
        
          $rents = new Rent();
          $rents->u_id=Auth::id();
          $rents->bookId=$request->input('bookId');
         
          
          $rents->save();
          return response()->json([
            'message' => ' Book rented successfully ', 
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //
    }

    public function bookreturn(Request $request)
    {
        $this->validate($request,[
            'bookId' => 'required|min:1|string',
            
          ]);
        
          $rents = new Rent();
          $rents->u_id=Auth::id();
          $rents->bookId=$request->input('bookId');
        
          $rents->save();
          $temp=1;
          if($rents){
            DB::table('rents')
            ->where('bookId', $rents->bookId)
            ->update(['status' => $temp]);
            
          }
          return response()->json([
            'message' => ' Book return successfully ', 
            ], 201);
    }
}
