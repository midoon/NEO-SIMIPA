<div class="bg-gradient-to-r from-simipa-3  to-simipa-4 w-full">
    <div class="w-full flex justify-center items-center min-h-screen px-8">
        <div class="w-full md:max-w-sm rounded-xl bg-simipa-5 p-10 ">
            {{-- @if (session('error'))
                <div id="error-login" class=" text-red-700 bg-red-200 p-4 rounded mb-4 flex justify-between items-center">
                    {{ session('error') }}
                    <button class="btn-error-any p-3" onclick="closeErrorBtn('error-login')">&#10006</button>
                </div>
            @endif --}}
            <h1 class="text-center text-3xl font-bold text-simipa-3">Login Admin</h1>
            <form wire:submit.prevent="login" class="mt-10">

                <div class="mb-2">
                    <label for="username" class="font-bold text-simipa-3">Username</label>
                    <input type="username" name="username" id="username" placeholder="username"
                        class=" border-1 rounded-md px-2 w-full focus:outline-none py-1.5  mt-2 focus:border-simipa-1  focus:ring-simipa-1 focus:ring-2"
                        required wire:model="username">
                </div>
                <div class="mb-10">
                    <label for="password" class="font-bold text-simipa-3">Password</label>
                    <input type="password" name="password" id="password" placeholder="password"
                        class=" border-1 rounded-md px-2 w-full focus:outline-none py-1.5  mt-2 focus:border-simipa-1  focus:ring-simipa-1 focus:ring-2"
                        required wire:model="password">
                </div>
                <div class="w-full text-center">
                    <button type="submit"
                        class="font-bold px-16 py-2 bg-simipa-1 text-white rounded-full lg:px-10 hover:cursor-pointer hover:bg-simipa-3">Login
                    </button>
                </div>
            </form>
            <div class="mt-10">

                <h3
                    class=" text-simipa-2 text-center text-sm hover:underline hover:text-simipa-1 hover:text-shadow-simipa-1">
                    <a href="/teacher/login" wire:navigate>Login
                        sebagai
                        guru</a>
                </h3>
            </div>
        </div>
    </div>

</div>
