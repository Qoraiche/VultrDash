<?php

namespace vultrui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use vultrui\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class ManageUsers extends Controller
{


    public function __construct()
    {

        $this->middleware('auth');

        $this->middleware('role:super-admin')->except('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $usersList = User::all();

        return view('dash.users')->with( compact('usersList') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permissionsList = Permission::all();

        return view( 'modals.create-user', compact('permissionsList') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'firstname' => 'nullable|string|max:39',
            'lastname' => 'nullable|string|max:39',
            'country' => 'nullable|string|max:90',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
                'email' => $request->email,
                'firstname' => strtolower( $request->firstname ),
                'lastname' => strtolower( $request->lastname ),
                'country' => strtolower($request->country),
                'password' => Hash::make($request->password),
        ]);

        if ( $request->role == 'super-admin' )
        {

            $user->assignRole( 'super-admin' );
            
        } elseif ( is_array($request->permissions) && $request->role == 'assign-permission' ) {


            $user->givePermissionTo( array_keys( $request->permissions ) );

        } else {

            return redirect()->route('users.create');
        }

        // activity()->log( __( 'Creating new user' ) );
        // 
        return redirect()->route('users.index')->with('status', 'User created');

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

        $user = User::findOrFail($id);
        
        /*if ( !$user->hasPermissionTo('manage users') && $user->is( Auth::user() ) ) {

            return redirect('/settings');
            
        }*/

        $permissionsList = Permission::all();;

        return view( 'modals.edit-user', compact( 'permissionsList', 'user' ) );

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
        $user = User::findOrFail( $id );

        if ( !Auth::user()->hasRole( 'super-admin' ) && !Auth::user()->is( $user ) ) {
            
            return redirect()->back()->with('warning', 'Permission required'); 
        }

        $request->edit_account = $request->edit_account === 'true' ? true : false;



        if ( $request->pass_email ){

            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'password' => 'nullable|string|min:6|confirmed'
            ]);

            $user->email = strtolower($request->email);
            $user->password = Hash::make($request->password);

            $user->save();

            return redirect()->back()->with('passemail_status', 'Updated');

        }

        $validatedData = $request->validate([
                'firstname' => 'nullable|string|max:39',
                'lastname' => 'nullable|string|max:39',
                'country' => 'nullable|string|max:90',
        ]);

        $user->firstname = strtolower($request->firstname);
        $user->lastname = strtolower($request->lastname);
        $user->country = $request->country;

        $user->save();


        if ( !$request->edit_account ) {

            if ( $request->role == 'super-admin' )

            {

                $user->assignRole( 'super-admin' );
                    
            } elseif ( is_array($request->permissions) && $request->role == 'assign-permission' ) {

                if ( $user->hasRole( 'super-admin' ) ){

                    $user->removeRole( 'super-admin' );
                    
                }

                    $user->syncPermissions( array_keys( $request->permissions ) );

                }

            else {

                return redirect()->back()->with('warning', 'You must assign at least one permission/role');
            }

        }



        return redirect()->back()->with('status', 'Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

         $authUser = Auth::user();

         $targetedUser = User::findOrFail($id);

         /*$isSuperAdmin = ( $authUser->hasRole('super-admin') )

                            ? true : false;*/

         /*$isUserManager = ( $authUser->hasPermissionTo('manage users') )

                            ? true : false;*/

         $user = User::findOrFail($id);

        
        if ( $targetedUser->id === $authUser->id ) {

           return redirect()->route('users.index')->with('warning', 'You cannot manage yourself');

        }

         $user->delete();

         return redirect()->route('users.index')->with('status', 'User ID <strong>'. $id .'</strong>: user deleted');

        /*

        return redirect()->route('users.index')->with('error', 'There are no valid users selected for deletion.');*/


    }
}
