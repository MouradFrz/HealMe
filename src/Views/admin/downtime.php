<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downtime management</title>
    <link rel="stylesheet" href="/styles/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="flex">
    <?php require __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="flex flex-col w-[80%]">
        <?php require __DIR__ . '/../components/admin_navbar.php'; ?>
        <section class="pt-4 px-6 w-full">
            <h1 class="text-4xl font-bold">Downtime management</h1>
            <p>Creating a downtime makes clients unable to make an appointment in the specified period.</p>
            <?php if (inSession('success')) { ?>
                <p class="font-semibold p-4 bg-green-400 my-2 rounded-md"><?= sessionVar('success') ?></p>
            <?php } ?>
            <div class="flex flex-col">
                <a href="/admin/create-downtime" class="bg-green-600 rounded-md p-4 ml-auto text-white font-bold">New downtime</a>
                <table class="w-full text-left mt-5">
                    <thead>
                        <th>Start date</th>
                        <th>End time</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <?php foreach (sessionVar("downtimes") as $dt) { ?>
                            <tr>
                                <td><?= $dt["startdate"] ?></td>
                                <td><?= $dt["enddate"] ?></td>
                                <td class="<?= $dt["status"] ?>"><?= $dt["status"] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

</body>

</html>