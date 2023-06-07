<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticate</title>
    <link rel="stylesheet" href="./styles/auth.css">
</head>

<body class="bg-slate-300">

    <form action="/admin/check" method="POST" class="flex justify-center items-center flex-col" style="margin-top:150px ;">
        <?php if (inSession('error')) { ?>
            <p class="font-semibold text-red-600"><?= sessionVar('error') ?></p>
        <?php } ?>
        <label for="">Enter authentication token:</label>
        <input type="text" name="token">
        <button class="btn-default w-fit hover:bg-blue-400 transition-all ">Submit</button>
    </form>
</body>

</html>