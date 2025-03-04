<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Account & Security Settings</h2>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Account Credentials</h3>
                        
                        <div class="space-y-4">
                            <!-- Username Section -->
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">Username</p>
                                    <p class="text-sm text-gray-600">Used for login</p>
                                </div>
                                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                                    Change Username
                                </button>
                            </div>

                            <!-- Email Section -->
                            <div class="flex justify-between items-center pt-4 border-t">
                                <div>
                                    <p class="font-medium">Email Address</p>
                                    <p class="text-sm text-gray-600">You can use either your old or new email to login</p>
                                </div>
                                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                                    Change Email
                                </button>
                            </div>

                            <!-- Password Section -->
                            <div class="flex justify-between items-center pt-4 border-t">
                                <div>
                                    <p class="font-medium">Password</p>
                                    <p class="text-sm text-gray-600">Secure your account with a strong password</p>
                                </div>
                                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2FA Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Two Factor Authentication</h3>
                            <p class="text-sm text-gray-600 mb-4">Add an extra layer of security to your account</p>
                        </div>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm">
                            Activate 2FA
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
