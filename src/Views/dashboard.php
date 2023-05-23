<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard|Healme</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>

<body>
    <div class="container">
        <nav class="border-b-[1px] border-blue-700">
            <div class="flex justify-between">
                <div class="py-4 flex gap-4">
                    <img src="../images/logo.png" alt="logo" class="w-12 h-12">
                    <div>
                        <h1 class="font-bold text-3xl">HealMe</h1>
                        <p class="text-xs max-w-[200px]">The place where you are priority.</p>
                    </div>
                </div>
                <div>

                </div>
                <div class="flex items-center gap-4">
                    <img src="./images/user_placeholder.webp" class="w-12 rounded-full" alt="user image">
                    <div>
                        <p class="font-bold text-xl leading-5"><?= sessionVar("userData")["fullname"] ?></p>
                        <p class="text-gray-400 leading-5"><?= sessionVar("userData")["email"] ?></p>
                    </div>
                    <form action="logout" method="POST">
                        <button class="border-[1px] border-white/80 py-2 px-5 rounded-md bg-red-500 font-bold text-white/80">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</body>

</html>