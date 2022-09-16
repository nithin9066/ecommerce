@extends('layouts.app')
@section('content')
@include('includes.lodder')
<div class="lg:h-screen">
    <div class="grid grid-cols-12 h-full">
        <div class="col-span-3 hidden lg:block bg-indigo-600 h-full">
            <h1 class="text-4xl font-extrabold uppercase p-5 text-gray-200">My Account</h1>
            <ul class="text-lg text-white uppercase">
                <li class="ml-5"><button class="list w-full flex items-center gap-2 rounded-l-full pl-2 py-2"><iconify-icon icon="ri:account-circle-fill" width="20.25"></iconify-icon><span>Profile</span></button></li>
                <li class="ml-5"><button class="list w-full flex items-center gap-2 rounded-l-full pl-2 py-2"><iconify-icon icon="fa:shopping-bag" width="20.25"></iconify-icon> <span>My Orders</span></button></li>
                <li class="ml-5"><button class="list w-full flex items-center gap-2 rounded-l-full pl-2 py-2"><iconify-icon icon="bi:calendar-heart-fill" width="20.25"></iconify-icon> <span>My Wishlist</span></button></li>
                <li class="ml-5"><button class="list w-full flex items-center gap-2 rounded-l-full pl-2 py-2"><iconify-icon icon="fa6-solid:address-card"></iconify-icon> <span>Manage Address</span></button></li>
            </ul>
        </div>
        <div class="lg:col-span-9 col-span-12 bg-indigo-50">
            <h2 class="px-5 lg:text-4xl text-2xl bg-white font-extrabold uppercase py-5 lg:pt-4 lg:pb-2 shadow-sm shadow-indigo-400">User Information</h2>
            <div class="lg:my-5 my-2 flex gap-4 flex-wrap justify-around lg:p-1 p-5">
                <div class="lg:w-1/2 w-full bg-white rounded-lg shadow-lg shadow-indigo-200">
                    <h2 class="text-lg font-bold bg-indigo-200 uppercase rounded-t-lg p-2 text-center text-indigo-500">Update Profile</h2>
                    <form id="profile" class="space-y-4 p-5">
                        @csrf
                        <div class="flex flex-col">
                            <label for="name" class="font-medium">Full Name:</label>
                            <input class="rounded-md border border-indigo-100" id="name" type="text" name="name" value='{{\Auth::user()->name}}' placeholder="Enter Full Name">
                        </div>
                        <div class="flex flex-col">
                            <label for="gender" class="font-medium py-2">Gender:</label>
                            <div id="gender" class="flex gap-5">
                                <div>
                                    <input @if(Auth::check() && Auth::user()->gender && Auth::user()->gender == "male") @checked(true)  @endif class="rounded-md border border-indigo-100" id="male" type="radio" value="male" name="gender">
                                    <label for="male" class="text-gray-500">Male</label>
                                </div>
                                <div>
                                    <input @if(Auth::check() && Auth::user()->gender && Auth::user()->gender == "female") @checked(true)  @endif class="rounded-md border border-indigo-100" id="Female" type="radio" value="female" name="gender">
                                    <label for="Female" class="text-gray-500">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label for="email" class="font-medium">Email Id:</label>
                            <input class="rounded-md border border-indigo-100" id="email" type="email" name="email" value='{{\Auth::user()->email}}' placeholder="Enter Email Id">
                        </div>
                        <div class="flex flex-col">
                            <label for="phone" class="font-medium">Contact Number:</label>
                            <input class="rounded-md border border-indigo-100" id="phone" type="tel" name="phone" value='{{\Auth::user()->phone}}' placeholder="Enter Contact number">
                        </div>
                        <button class="p-2 bg-indigo-600 font-medium rounded-md uppercase text-white">Update</button>
                    </form>
                </div>
                <div class="lg:w-auto h-full w-full bg-white rounded-lg shadow-lg shadow-indigo-200">
                    <h2 class="text-lg font-bold bg-indigo-200 uppercase rounded-t-lg p-2 text-center text-indigo-500">Change Password</h2>
                    <form id="changePassword" class="space-y-4 p-5">
                        @csrf
                        <div class="flex flex-col">
                            <label for="cpassword" class="font-medium">Current Password:</label>
                            <input class="rounded-md border border-indigo-100" id="cpassword" type="password" name="cpassword" placeholder="Enter Current Password">
                        </div>
                        <div class="flex flex-col">
                            <label for="npassword" class="font-medium">New Password:</label>
                            <input class="rounded-md border border-indigo-100" id="npassword" type="password" name="password" placeholder="Enter New Password">
                        </div>
                        <div class="flex flex-col">
                            <label for="rpassword" class="font-medium">Re-Enter Password:</label>
                            <input class="rounded-md border border-indigo-100" id="rpassword" type="password" name="password_confirmation" placeholder="Re-Enter Password">
                        </div>
                        <button class="p-2 bg-indigo-600 font-medium rounded-md uppercase text-white lg:w-full">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('bodyscript')
<script>
    $(".list").click(function(){
        $(".list").removeClass(["font-bold", "bg-white", "text-indigo-500"])
        $(this).addClass(["font-bold", "bg-white", "text-indigo-500"])
    })
    $("#profile").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'profile',
            data: $(this).serialize(),
            beforeSend: function(){
                $("#process").removeClass('hidden');
            },
            success: function(res)
            {
                $("#process").addClass('hidden');
                Toast.fire({
                icon: 'success',
                title: res.msg
                })
            },
            error: function(res)
            {
                $("#process").addClass('hidden');
                Toast.fire({
                icon: 'warning',
                title: res.responseJSON.errors.phone ? "Phone number linked to another account" : res.responseJSON.errors.email ? "Email linked to another account" : res.responseJSON.errors.name ? "Name Required" : "Something went wrong! Please try again."
                })
            }
        })
    })
    $("#changePassword").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'change-password',
            data: $(this).serialize(),
            beforeSend: function(){
                $("#process").removeClass('hidden');
            },
            success: function(res)
            {
                $("#process").addClass('hidden');
                Toast.fire({
                icon: 'success',
                title: res.msg
                })
            },
            error: function(res)
            {
                console.log(res.responseJSON)
                $("#process").addClass('hidden');
                Toast.fire({
                icon: 'warning',
                title: res.responseJSON.errors.cpassword ? res.responseJSON.errors.cpassword[0] : res.responseJSON.errors.password ? res.responseJSON.errors.password[0] : "Something went wrong! Please try again."
                })
            }
        })
    })
</script>
@endsection