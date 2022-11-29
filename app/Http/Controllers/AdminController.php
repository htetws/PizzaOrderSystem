<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //admin list
    public function adminList()
    {
        $admins = User::when(request('search'), function ($query) {
            $query
                ->orWhere('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('gender', 'like', '%' . request('search') . '%')
                ->orWhere('address', 'like', '%' . request('search') . '%')
                ->orWhere('phone', 'like', '%' . request('search') . '%');
        })->where('role', 'admin')->paginate(4);

        return view('admin.profile.adminList', compact('admins'));
    }

    //user list
    public function userList()
    {
        $users = User::when(request('search'), function ($query) {
            $query
                ->orWhere('name', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%')
                ->orWhere('gender', 'like', '%' . request('search') . '%')
                ->orWhere('address', 'like', '%' . request('search') . '%')
                ->orWhere('phone', 'like', '%' . request('search') . '%');
        })->where('role', 'user')->paginate(4);
        return view('admin.profile.userList', compact('users'));
    }

    //user role ajax
    public function userRoleAjax(Request $request)
    {
        User::where('id', $request->user_id)->update(['role' => $request->role]);
        return response()->json(200);
    }

    //user delete
    public function userDelete(Request $request)
    {
        User::where('id', $request->userid)->delete();

        OrderList::where('user_id', $request->userid)->delete();

        Order::where('user_id', $request->userid)->delete();

        return back()->with('change_role', 'this account deleted successfully.');
    }

    //user edit page
    public function userEditPage($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.profile.useredit', compact('user'));
    }

    //user edit
    public function userEdit(Request $request)
    {
        $this->profileValidation($request);
        $query = $this->profileQuery($request);

        $dbImage = User::select('image')->where('id', $request->id)->first();
        $dbImage = $dbImage->image;

        if ($request->hasFile('image')) {

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $imgName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $imgName);
            $query['image'] = $imgName;
        }

        User::where('id', $request->userid)->update($query);

        return redirect()->route('user#list')->with('update_success', 'profile updated successfully.');
    }

    //admin ajax role change
    public function adminRoleAjax(Request $request)
    {
        logger($request->all());
        User::where('id', $request->admin_id)->update(['role' => $request->role]);
        return response()->json(200);
    }

    //admin delete
    public function adminDelete(Request $request)
    {
        User::where('id', $request->id)->delete();
        return redirect()->route('admin#list')->with('product_delete', 'account removed successfully.');
    }

    //role changing
    public function roleChange(Request $request)
    {
        User::where('id', $request->id)->update([
            'role' => $request->role
        ]);
        return redirect()->route('admin#list')->with('change_role', 'changed role successfully.');
    }

    // change password admin
    public function passwordChangePage()
    {
        return view('admin.profile.change_pwd');
    }

    function passwordChange(Request $request)
    {
        $this->pwdValidation($request); // fun callback

        $old_password = Auth::user()->password;

        if (Hash::check($request->oldpwd, $old_password)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newpwd)
            ]);
            return back()->with('pwd_changed', 'Password changed successfully.');
        }

        return redirect()->route('password#change')->with('pwd_error', 'The old password is not match ! try again.');
    }

    //Admin Profile detail page
    public function adminProfile()
    {
        return view('admin.profile.detail');
    }

    public function adminProfileUpdatePage()
    {
        return view('admin.profile.update');
    }
    public function adminProfileUpdate(Request $request)
    {
        $this->profileValidation($request);
        $query = $this->profileQuery($request);

        $dbImage = User::select('image')->where('id', Auth::user()->id)->first();
        $dbImage = $dbImage->image;

        if ($request->hasFile('image')) {

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $imgName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $imgName);
            $query['image'] = $imgName;
        }

        User::where('id', Auth::user()->id)->update($query);

        return redirect()->route('admin#profile')->with('update_success', 'profile updated successfully.');
    }

    //private functions
    private function pwdValidation($request)
    {
        Validator::validate($request->all(), [
            'oldpwd' => 'required|min:8',
            'newpwd' => 'required|min:8',
            'confirmpwd' => 'required|min:8|same:newpwd'
        ]);
    }
    private function profileValidation($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ])->validate();
    }
    private function profileQuery($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender
        ];
    }
}
