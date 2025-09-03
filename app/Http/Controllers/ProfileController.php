<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * عرض صفحة تعديل البروفايل
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * تحديث بيانات البروفايل (الاسم / الإيميل)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null; // إعادة التحقق من الإيميل
            }

            $user->save();

            return Redirect::route('profile.edit')
                ->with('success', __('messages.profile_updated'));
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')
                ->with('error', __('messages.profile_update_failed'));
        }
    }

    /**
     * تحديث كلمة المرور
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('warning', __('messages.incorrect_password'));
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', __('messages.password_updated'));
    }

    /**
     * حذف الحساب
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();

            Auth::logout();
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')
                ->with('success', __('messages.account_deleted'));
        } catch (\Exception $e) {
            return back()->with('error', __('messages.account_delete_failed'));
        }
    }
}
