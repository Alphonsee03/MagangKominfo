<x-header-admin>

    <div class="auth-main relative">
        <div class="auth-wrapper v1 flex items-center w-full h-full min-h-screen">
            <div class="auth-form flex items-center justify-center grow flex-col min-h-screen relative p-6 ">
                <div class="w-full max-w-[350px] relative">
                    <div class="auth-bg ">
                        <span class="absolute top-[-100px] right-[-100px] w-[300px] h-[300px] block rounded-full bg-theme-bg-1 animate-[floating_7s_infinite]"></span>
                        <span class="absolute top-[150px] right-[-150px] w-5 h-5 block rounded-full bg-primary-500 animate-[floating_9s_infinite]"></span>
                        <span class="absolute left-[-150px] bottom-[150px] w-5 h-5 block rounded-full bg-theme-bg-1 animate-[floating_7s_infinite]"></span>
                        <span class="absolute left-[-100px] bottom-[-100px] w-[300px] h-[300px] block rounded-full bg-theme-bg-2 animate-[floating_9s_infinite]"></span>
                    </div>
                    <div class="card sm:my-12  w-full shadow-none">

                        <div class="card-body !p-10">
                            <div class="text-center mb-8">
                                <a href="#"><img src="{{ asset('assets/images/logo-dark.svg') }}" alt="img" class="mx-auto auth-logo" /></a>
                            </div>
                            <h4 class="flex text-2xl mb-4 font-semibold bg-gradient-to-r from-teal-500 to-sky-600 bg-clip-text text-transparent justify-center items-center ">Register</h4>
                            <form action="{{ route('register.submit') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="mb-4">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                                </div>
                                <div class="mb-4">
                                    <label class="block mb-2 font-medium">Role</label>
                                    <div class="flex gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="role" value="kasir" class="form-radio" required>
                                            <span class="ml-2">Kasir</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="role" value="supplier" class="form-radio" required>
                                            <span class="ml-2">Supplier</span>
                                        </label>
                                    </div>
                                </div></label>
                                <div class="flex mt-1 justify-between items-center flex-wrap">
                                    <div class="form-check">
                                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" required />
                                        <label class="form-check-label text-muted" for="customCheckc1">I agree to all the Terms &amp; Condition</label>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-primary mx-auto shadow-2xl">Sign up</button>
                                </div>
                            </form>

                            <div class="flex justify-between items-end flex-wrap mt-4">
                                <h6 class="font-medium mb-0">Already have an Account?</h6>
                                <a href="{{ route('login') }}" class="text-primary-500">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-footer-admin />
    <x-script-admin />
</x-header-admin>