<?php

use App\Middlewares\Auth;

?>

<nav class="bg-gray-800/50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="size-8" />
                </div>
                <div class="hidden md:block">
                    <?php if (!Auth::user()) : ?>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="/" <?= getURI() === '/' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Home</a>
                            <a href="/about" <?= getURI() === '/about' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/about' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">About</a>
                        </div>
                    <?php elseif (Auth::isAdmin()) : ?>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="/admin" <?= getURI() === '/admin' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/admin' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Admin</a>
                            <a href="/notes" <?= getURI() === '/notes' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/notes' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Notes</a>
                            <a href="/users" <?= getURI() === '/users' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/users' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Users</a>
                        </div>
                    <?php else : ?>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="/dashboard" <?= getURI() === '/dashboard' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/dashboard' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Dashboard</a>
                            <a href="/notes" <?= getURI() === '/notes' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/notes' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Notes</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <?php if (!Auth::user()) : ?>
                        <a href="/login" class="rounded-md text-gray-300 hover:bg-white/5 hover:text-white px-3 py-2 text-sm font-medium">Login</a>
                        <a href="/register" class="rounded-md text-gray-300 hover:bg-white/5 hover:text-white px-3 py-2 text-sm font-medium">Register</a>
                    <?php else : ?>
                        <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                                <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="relative ml-3 flex gap-x-3">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full outline -outline-offset-1 outline-white/10" />
                            <a href="/profile" <?= getURI() === '/profile' ? 'aria-current="page"' : '' ?> class="rounded-md <?= getURI() === '/profile' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?> px-3 py-2 text-sm font-medium">Profile</a>
                            <a href="#" class="rounded-md text-gray-300 hover:bg-white/5 hover:text-white px-3 py-2 text-sm font-medium" id="user-menu-item-1">Settings</a>
                            <form action="/logout" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="rounded-md text-gray-300 hover:bg-white/5 hover:text-white px-3 py-2 text-sm font-medium" id="user-menu-item-2">Sign out</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <el-disclosure id="mobile-menu" hidden class="block md:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <!-- Current: "bg-gray-950/50 text-white", Default: "text-gray-300 hover:bg-white/5 hover:text-white" -->
            <a href="#" aria-current="page" class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Projects</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Reports</a>
        </div>
        <div class="border-t border-white/10 pt-4 pb-3">
            <div class="flex items-center px-5">
                <div class="shrink-0">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full outline -outline-offset-1 outline-white/10" />
                </div>
                <div class="ml-3">
                    <div class="text-base/5 font-medium text-white">Tom Cook</div>
                    <div class="text-sm font-medium text-gray-400">tom@example.com</div>
                </div>
                <button type="button" class="relative ml-auto shrink-0 rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">View notifications</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                        <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Your profile</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Settings</a>
                <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Sign out</a>
            </div>
        </div>
    </el-disclosure>
</nav>