<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $add = Book::all();
     
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
            'book_name' => 'required|min:1|string|unique:books',
            'author' => 'required|min:1|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
          ]);

          $boking = new Book();
          
          $boking->book_name=$request->input('book_name');
          $boking->author=$request->input('author');
        //  $boking->cover_image=$request->input('cover_image');
          $boking->save();
        //   return Response("Book Added To Book Table");

          if(!$request->hasFile('cover_image')) {
            return response()->json(['Book Added To Book Table'], 400);
        }
     
        $allowedfileExtension=['jpg','png'];
        $files = $request->file('cover_image'); 
        $errors = [];
     
        foreach ($files as $file) {      
     
            $extension = $file->getClientOriginalExtension();
     
            $check = in_array($extension,$allowedfileExtension);
     
            if($check) {
                foreach($request->cover_image as $mediaFiles) {
     
                    $path = $mediaFiles->store('public/images');
                    $name = $mediaFiles->getClientOriginalName();
          
                   
                    $save = new Book();
                    $save->path = $path;
                    $save->save();
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
     
            return response()->json(['file_uploaded'], 200);
     
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
            $book = Book::find($id);
                if (is_null($book)) {
                return $this->sendError('Product not found.');
                }
                return response()->json([
                "success" => true,
                "message" => "Product retrieved successfully.",
                "data" => $book
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'book_name' => 'required|min:1|string',
            'author' => 'required|min:1|string',
            //'email' => 'required|email',
          ]);
       
        $add=Book::where('id',$id)->first();
        
            $add->book_name=$request->input('book_name');
            $add->author=$request->input('author');
           // $add->email=$request->input('email');
           
            if($add->save())
            {
                return Response("Book Updates successfully.");
            }
            else{
                return Response("Unable To Update Book");
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $add = Book::where('id',$id)->first();
        if($add!='')
        {
            if($add->delete())
            {
               
                return response()->json(['Book Remove From Book Table'], 200);
                
            }
            else{
                return Response("Unable To Remove Book");
            }
        }
        else{
            return response()->json(['Data Not Available In Book Table'], 400);

            
        }
    }
}
