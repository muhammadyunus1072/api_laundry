<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['list'] = User::with('role')->get();
        $data['role'] = auth()->user()->role_id;
        // $data['outlet'] = 
        return json_encode($data);
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
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'role_id' => 'required|numeric'
        ]);

        if($validate->fails()){
            $data['validate'] = false;
            $data['error'] = $validate->errors();
        }else{
            $data['validate'] = true;
            $data['password'] = fake()->bothify('??##??##');
            $user = new User();

            // $user->nama = $request->nama;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->password = bcrypt($data['password']);
            if($user->save()){
                $data['list'] = User::with('role')->find($user->id);
                $data['status'] = true;
            }
            else{
                $data['status'] = false;
            }          
        }
        
        return json_encode($data);
        // return response()->json(fake()->bothify('??##??##'));
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
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
        ]);

        if($validate->fails()){
            $data['validate'] = false;
            $data['error'] = $validate->errors();
        }else{
            $data['validate'] = true;

            $user = User::find($id);
            if(!$request->role_id){
                $user->name = $request->name;
    
                if($user->save()){
                    $data['status'] = true; 
                    $data['list'] = User::find($user->id);
                }
            }else{
                $user->name = $request->name;
                $user->role_id = $request->role_id;
    
                if($user->save()){
                    $data['status'] = true; 
                    $data['list'] = User::find($user->id);
                }
                // $user->nama = $request->nama;
            }
        }
        // $data['nama'] = $request->nama;
        // $data['tlp'] = $request->tlp;
        // $data['alamat'] = $request->alamat;
        // $data['jenis_kelamin'] = $request->jenis_kelamin;
        // $data['id_role'] = $request->id_role;
        // $data['id_outlet'] = $request->id_outlet;
        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user->delete()){
            $data['status'] = true;
        }else{
            $data['status'] = false;
        }

        return json_encode($data);
    }

    public function search(Request $request){
        // if($request)
        // $data['query'] = $request->param;
        $data['list'] = User::with('role')
                            ->whereRelation('role', 'role', 'like', '%'.$request->param.'%')
                            ->orwhere('name', 'like', '%'.$request->param.'%')
                            ->orwhere('email', 'like', '%'.$request->param.'%')
                            ->get();
        // $data['list'] = "coba";
        // $data['param'] = $request->param;
        return json_encode($data);
    }
}
