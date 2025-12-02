<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserProfileService;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $userProfileService;

    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }

    /**
     * Display users with multiple roles
     */
    public function index()
    {
        $usersWithMultipleRoles = $this->userProfileService->getUsersWithMultipleRoles();
        
        return view('data.profiles.index', compact('usersWithMultipleRoles'));
    }

    /**
     * Show tabbed profile view for a user
     */
    public function show($userId)
    {
        try {
            $profileData = $this->userProfileService->getUserProfiles($userId);
            
            return view('data.profiles.show', [
                'user' => $profileData['user'],
                'profiles' => $profileData['profiles'],
                'roles' => $profileData['roles'],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('data.profiles.index')
                ->with('error', 'User tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint to get profile data for AJAX requests
     */
    public function getProfileData($userId, $profileType)
    {
        try {
            $profileData = $this->userProfileService->getUserProfiles($userId);
            
            if (!isset($profileData['profiles'][$profileType])) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            $profile = $profileData['profiles'][$profileType];
            $user = $profileData['user'];

            return response()->json([
                'success' => true,
                'profile' => $profile,
                'user' => $user,
                'type' => $profileType
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
