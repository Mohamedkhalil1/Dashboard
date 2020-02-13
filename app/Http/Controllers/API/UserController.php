<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Image;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return User::latest()->paginate(5);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
                                    'name'     => 'required|string|max:255',
                                    'email'    => 'required|string|max:255|unique:users',
                                    'password' => 'required|string|min:6'
        ]);
        $avatar ="profile.png";
        return User::create([
                                'name' => $request->name,
                                'email' => $request->email,
                                'type' => $request->type,
                                'bio' => $request->bio,
                                'avatar' => $avatar,
                                'password' =>Hash::make($request->password),
            ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request){
         //
         $user = auth('api')->user();
        
         $this->validate($request,[
             'name'     => 'required|string|max:255',
             'email'    => 'required|string|max:255|unique:users,email,'.$user->id,
             'password' => 'sometimes|required|min:6'
             ]);
         
    
        if(!empty($request->password))
        {
            $request->merge([
                'password' =>Hash::make($request->password)
            ]);
            $params = $request->except([
                'avatar'
            ]);
        }
        else
        {
            $params = $request->except([
                'avatar' , 'password'
            ]);
        }

      $user->update($params);
      return $user;
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
        //
        $user = User::findOrFail($id);
        $this->validate($request,[
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|max:255|unique:users,email,'.$user->id,
            ]);
        $avatar ="profile.png";
        if($request->password === null)
        {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'bio' => $request->bio,
                'avatar' => $avatar
            ]);
        }
         else
         {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'bio' => $request->bio,
                'password' =>Hash::make($request->password),
                'avatar' => $avatar
            ]);
         }

        return $user;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function search(Request $request)
    {
        
        if($search = $request->get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('type','LIKE',"%$search%");
            })->paginate(5);    
        }
       return $users;
    }
}
