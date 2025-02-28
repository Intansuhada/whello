use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

public function update(Request $request)
{
    try {
        // Debug incoming request
        Log::info('Profile update request:', [
            'all' => $request->all(),
            'files' => $request->allFiles(),
            'user_id' => auth()->id()
        ]);

        // Validate request
        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nickname' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'department_id' => 'nullable|numeric',
            'job_title_id' => 'nullable|numeric',
        ]);

        Log::info('Validated data:', $validated);

        DB::beginTransaction();

        try {
            // Update Profile Basic Info
            $user = auth()->user();
            $profile = $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nickname' => $request->nickname,
                    'full_name' => $request->full_name,
                    'about' => $request->about,
                    'department_id' => $request->department_id,
                    'job_title_id' => $request->job_title_id,
                ]
            );

            // Handle Avatar Upload
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                
                // Create storage directory if not exists
                $storagePath = storage_path('app/public/avatars');
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                // Store new avatar
                $filename = time() . '_' . Str::slug($file->getClientOriginalName());
                $file->move($storagePath, $filename);

                // Delete old avatar
                if ($user->avatar_url) {
                    $oldPath = public_path($user->avatar_url);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                // Update user avatar_url
                $user->update([
                    'avatar_url' => 'storage/avatars/' . $filename
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbaharui',
                'data' => [
                    'profile' => $profile->fresh(),
                    'user' => $user->fresh()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }

    } catch (ValidationException $e) {
        Log::error('Validation failed:', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal: ' . implode(', ', array_flatten($e->errors())),
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Unexpected error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbaharui profile: ' . $e->getMessage()
        ], 500);
    }
}
