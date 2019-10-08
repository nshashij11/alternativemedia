<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Categories;
use Validator;
use Exception;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user() == ''){
           return redirect('gallery');
        }else{
            if(Auth::user()->email == 'admin_user@test.com'){
                return view('admin_home');
            }
        }        
    }

    public function category_list()
    {
        if(Auth::user() != "" && Auth::user()->email == 'admin_user@test.com'){
            $categories = Categories::all();
            return view('category_list', ['categories' => $categories]);
        }else{
            throw New Exception("Access Denied! Unauthorized Access 404!");
        }
    }

    public function category_add()
    {
       if(Auth::user() != "" && Auth::user()->email == 'admin_user@test.com'){
            return view('category_add');
        }else{
            throw New Exception("Access Denied! Unauthorized Access 404!");
        }
    }

    public function category_save(Request $request)
    {
        $response =[];
        try{
            $validator = Validator::make($request->all(),[             
                'category_name' => 'required|string|max:255',               
                'category_status' => 'required|integer',               
            ]);
            if($validator->fails()) throw new Exception($validator->errors());

            $category = new Categories;
            $category->category_name = $request->category_name;   
            $category->category_status = $request->category_status;  
            $result = $category->save();
            

            if($result){              
                $response['status'] = true;
                $response['message']='Category Added Successfully!';

            }else{
                $response['status'] = false;
                $response['message'] = 'Error Occurred!';
            }

        }
        catch (\Exception $e){
            $this->exceptionLog($e);
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        // return json_encode($response);      
        return redirect('category_list');
    }

     public function category_edit(Request $request)
    {
        if(Auth::user() != "" && Auth::user()->email == 'admin_user@test.com'){
            $validator = Validator::make($request->all(),[             
                'id' => 'required',               
            ]);
            if($validator->fails()) throw new Exception($validator->errors());

            $category = Categories::find($request->id);
            if($category){              
                return view('category_edit', ['category' => $category]);
            }else{
                return redirect('category_list');
            }
        }else{
            throw New Exception("Access Denied! Unauthorized Access 404!");
        }
    }

     public function category_update(Request $request)
    {
        $response =[];
        try{
            $validator = Validator::make($request->all(),[             
                'category_name' => 'required|string|max:255',               
                'category_status' => 'required|integer',               
            ]);
            if($validator->fails()) throw new Exception($validator->errors());
            $category = Categories::find($request->id);
            $category->category_name = $request->category_name;   
            $category->category_status = $request->category_status;  
            $result = $category->save();
            
            if($result){              
                $response['status'] = true;
                $response['message']='Category Updated Successfully!';

            }else{
                $response['status'] = false;
                $response['message'] = 'Error Occurred!';
            }

        }
        catch (\Exception $e){
            $this->exceptionLog($e);
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        // return json_encode($response);      
        return redirect('category_list');
    }

    public function category_delete(Request $request){
        if(Auth::user() != "" && Auth::user()->email == 'admin_user@test.com'){
             $validator = Validator::make($request->all(),[             
                'id' => 'required',               
            ]);
            if($validator->fails()) throw new Exception($validator->errors());

            $category = Categories::find($request->id);
            if($category){                  
                $category->delete();        
            }
            return redirect('category_list');
        }else{
            throw New Exception("Access Denied! Unauthorized Access 404!");
        }
    }

    public function gallery()
    {
        $categories = Categories::all();
        return view('gallery', ['categories' => $categories]);
    }

    public function flicker(){
        return view('flicker');
    }

    /**
    * Function To See the Exceptional Log
    */
    public function exceptionLog($e){
        Log::error("Exception Error Occurred.");
        Log::error('Error message : '.$e->getMessage());
        Log::error("Line No :" .$e->getLine());
        Log::error("File : " .$e->getFile());
    }

}
