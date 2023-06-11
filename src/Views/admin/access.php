<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="/styles/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="flex">
    <?php require __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="flex flex-col w-[80%]">
        <?php require __DIR__ . '/../components/admin_navbar.php'; ?>
        <section class="pt-4 px-6 w-full">
            <h1 class="text-4xl font-bold">Access management</h1>
            <?php if (inSession('success')) { ?>
                <p class="font-semibold p-4 bg-green-400 my-2 rounded-md"><?= sessionVar('success') ?></p>
            <?php } ?>

            <div class="flex flex-col">
                <form action="/admin/generate-token" method="POST" class="ml-auto"><button class=" bg-green-600 rounded-md p-4 text-white font-bold">Generate new access token</button></form>
                <table class="text-left table-auto border-separate mt-4">
                    <tr class="py-5">
                        <th>Token</th>
                        <th>Generated at</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach (sessionVar('tokens') as $token) { ?>
                        <tr>
                            <td><?= $token["token"] ?></td>
                            <td><?= $token["generated_at"]->toDateTime()->format("Y-m-d H:i") ?></td>

                            <td>
                                <form action="/admin/delete-token" method="POST">
                                    <input type="hidden" name="id" value="<?= $token["_id"] ?>">
                                    <button class="text-red-600 underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </section>
    </main>

</body>

</html>