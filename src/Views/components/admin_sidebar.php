<aside class="w-[20%] h-[calc(100vh-84px)] pt-4 px-2 bg-slate-100 flex flex-col justify-between">
    <ul>
        <li class="sidebar-element"><a href="/admin/dashboard"><i class="bi bi-house-door"></i> Home</a></li>
        <li class="sidebar-element"><a href=""><i class="bi bi-clipboard2-pulse"></i> Appointments</a></li>
        <li class="sidebar-element"><a href="/admin/access-control"><i class="bi bi-shield-check"></i> Access management</a></li>
        <li class="sidebar-element"><a href=""><i class="bi bi-calendar-date"></i> Schedule management</a></li>
    </ul>
    <form action="/admin/logout" method="POST">
        <button class="mb-5 w-full bg-blue-400 py-2 rounded-full font-bold">Logout</button>
    </form>
</aside>