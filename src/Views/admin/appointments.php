<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
    <link rel="stylesheet" href="../styles/appointments.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="flex">
    <?php require __DIR__ . '/../components/admin_sidebar.php'; ?>
    <main class="flex flex-col w-[80%]">
        <?php require __DIR__ . '/../components/admin_navbar.php'; ?>
        <section class="pt-4 px-6 w-full">
            <h1 class="text-4xl font-bold">Appointments</h1>
            <?php if (inSession('success')) { ?>
                <p class="font-semibold p-4 bg-green-400 my-2 rounded-md"><?= sessionVar('success') ?></p>
            <?php } ?>

            <div class="flex flex-col">
                <label for="">Select a date:</label>
                <input type="date" name="date">
            </div>
            <div>
                <div class="loader text-4xl text-center">
                    <p class="mt-5">I AM A LOADER</p>
                </div>
                <table class="w-full text-left mt-5">
                    <thead>
                        <th>Client name</th>
                        <th>Reservation date</th>
                        <th>Appointment time</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const dateInput = document.querySelector("input[type='date']")
        const section = document.querySelector("section")
        const tbody = document.querySelector("tbody")
        dateInput.valueAsDate = new Date();
        const updateTable = async (date) => {
            section.classList.add("show-loader");
            const {
                data
            } = await axios.get(`http://localhost:3000/admin/appointments-list?date=${date}`);
            section.classList.remove("show-loader");
            tbody.innerHTML = "";
            data.forEach(el => {
                const tr = document.createElement("tr")
                let td;
                for (const [att, value] of Object.entries(el)) {
                    td = document.createElement("td");
                    td.innerText = value;
                    if (value === "Passed") {
                        td.classList.add("passed")
                    }
                    if (value === "Upcoming") {
                        td.classList.add("upcoming")
                    }
                    tr.append(td)
                }
                tr.append(td)
                tbody.append(tr)
            });
        }
        updateTable(dateInput.value);
        dateInput.addEventListener("change", (ev) => {
            updateTable(dateInput.value)
        })
    </script>
</body>

</html>