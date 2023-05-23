<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HealMe</title>
    <link rel="stylesheet" href="./styles/auth.css">
</head>

<body class="bg-slate-300">
    <nav class="py-4 flex justify-center border-b-blue-700/60 border-b-2 m-auto">
        <div class="flex gap-4">
            <img src="../images/logo.png" alt="logo" class="w-12 h-12">
            <div>
                <h1 class="font-bold text-3xl">HealMe</h1>
                <p class="text-xs max-w-[200px]">The place where you are priority.</p>
            </div>
        </div>
    </nav>
    <main class="flex">
        <div class="w-[40%] border-r-2 border-r-blue-700/60">
            <img src="./images/login.jpg" class="h-[calc(100vh-86px)] object-cover" alt="login image">
        </div>
        <div class="w-[60%] flex flex-col items-center justify-center">
            <h1 class="text-center text-3xl font-bold">Login</h1>
            <form action="check" method="POST" class="flex flex-col w-[50%]">
                <?php if (inSession('error')) { ?>
                    <p class="font-semibold text-red-600"><?= sessionVar('error') ?></p>
                <?php } ?>
                <label for="email">Email</label>
                <input type="text" id="email" name="email">
                <label for="password">Password</label>
                <input type="text" id="password" name="password">
                <button class="btn-default w-fit hover:bg-blue-400 transition-all ">Login</button>
            </form>
            <a href="/register" class="text-blue-700">I do not have an account yet.</a>
        </div>
    </main>
</body>

</html>