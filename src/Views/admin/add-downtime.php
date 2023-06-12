<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create downtime</title>
    <link rel="stylesheet" href="/styles/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="flex">
    <?php require __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="flex flex-col w-[80%]">
        <?php require __DIR__ . '/../components/admin_navbar.php'; ?>
        <section class="pt-4 px-6 w-full">
            <h1 class="text-4xl font-bold">Create a downtime</h1>
            <p>Creating a downtime makes clients unable to make an appointment in the specified period.</p>
            <?php if (inSession('success')) { ?>
                <p class="font-semibold p-4 bg-green-400 my-2 rounded-md"><?= sessionVar('success') ?></p>
            <?php } ?>
            <?php if (inSession('error')) { ?>
                <p class="font-semibold p-4 bg-red-500 my-2 rounded-md"><?= sessionVar('error') ?></p>
            <?php } ?>
            <div class="flex flex-col">
                <form action="/admin/create-downtime" class="flex flex-col w-[50%]" method="POST">
                    <label for="">Start date</label>
                    <input type="date" name="startdate" id="startdate" class="p-2 text-md">
                    <label for="">End date</label>
                    <input type="date" name="enddate" id="enddate" class="p-2 text-md">
                    <button class="bg-green-600 mt-4 rounded-md p-4 text-white font-bold">Create</button>
                </form>
            </div>

        </section>
    </main>
    <script>
        var today = new Date()
        var tomorrow = new Date(today)
        tomorrow.setDate(tomorrow.getDate() + 1)

        var formattedDate = tomorrow.toISOString().split('T')[0]
        const startdate = document.getElementById("startdate")
        const enddate = document.getElementById("enddate")
        startdate.min = formattedDate
        enddate.min = formattedDate
        startdate.addEventListener("change", ({
            target: {
                value
            }
        }) => {
            enddate.value = ""
            enddate.min = value
        })
    </script>
</body>

</html>