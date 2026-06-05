<?php

namespace Modules\Account\Http\Requests\User\Avatar;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FormRequest;
use Modules\Account\Models\User;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'file'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'file'      => 'berkas'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            'profile_avatar' => $this->handleUploadedFile()
        ];
    }

    /**
     * Handle uploaded file
     */
    public function handleUploadedFile()
    {
        $user = User::find(auth()->user()->id);

        // Delete the existing profile avatar if it exists
        if ($existingAvatar = $user->getMeta('profile_avatar')) {
            Storage::delete($existingAvatar);
        }

        // Check if a file is uploaded
        if ($file = $this->file('file')) {
            // Store the file and get the filename
            $filename = $file->store('users/' . $user->id, 'public');

            // Update user's profile avatar metadata
            $user->setMeta('profile_avatar', $filename);

            // Return the filename
            return $filename;
        }

        // Handle case when no file is uploaded (optional)
        return null;
    }
}
