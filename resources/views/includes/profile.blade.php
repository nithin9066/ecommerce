
<button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar" class="flex mx-3 text-sm bg-transparent rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" type="button">
    <span class="sr-only">Open user menu</span>
    <span class="iconify text-3xl" data-icon="carbon:user-avatar-filled"></span>
</button>

<!-- Dropdown menu -->
<div id="dropdownAvatar" class="hidden z-30 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 block" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(295px, 62px);">
    <div class="py-3 px-4 text-sm text-gray-900 dark:text-white">
      <div>{{Auth::user()->name}}</div>
      <div class="font-medium truncate">{{Auth::user()->email}}</div>
    </div>
    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownUserAvatarButton">
      <li>
        <a href="/profile" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile</a>
      </li>
    </ul>
    <div class="py-1">
        <form action="/logout" method="POST">
            @csrf
            <button class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</button>
        </form>
    </div>
</div>
