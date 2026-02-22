<?php

function UserCard($users)
{
    echo "<div class='flex justify-start flex-wrap items-center gap-[10%]'>";
    foreach ($users as $user) {
        echo "
                <div class='bg-white w-full sm:max-w-[30%] rounded-lg shadow-md p-4 mb-4'>
                    <div class='flex items-center justify-between mb-2'>
                        <h2 class='text-xl font-semibold'>" . (htmlspecialchars($user['username']) ?? '') . "</h2>
                    </div>
                    <div class='flex flex-col items-start justify-between mb-2'>
                        <p class='mb-2'><span class='font-medium'>Email</span>: " . (htmlspecialchars($user['email']) ?? '') . "</p>
                        <p class='mb-2'><span class='font-medium'>Created at</span>: " . (htmlspecialchars($user['created_at']) ?? '') . "</p>
                    </div>
                    <div class='mt-4 flex space-x-2 relative'>
                        <span class='inline-block px-2 py-1 text-xs font-semibold rounded-full bg-indigo-500 text-white absolute bottom-0 right-0'>" . ($user['is_admin'] == 1 ? 'Admin' : 'User') . "</span>
                    </div>
                </div>";
    }
    echo "</div>";
}
