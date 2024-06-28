<nav class="navbar navbar-expand-lg my-auto">
    <div class="container-fluid d-flex flex-column gap-5 align-items-end">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
            aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item me-2">
                    <a class="nav-link text-white fs-6" href=""><i
                            class="fa-solid fa-arrow-left fs-2 position-relative hype-text-shadow"></i> Exit</a>
                </li>
                <!-- Notifiche -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle text-white fs-6" href="#" id="notificationsDropdown"
                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        data-bs-auto-close="false">
                        <i class="fa-solid fa-bell fs-3 position-relative hype-text-shadow"> <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-active-primary-color  small fs-6">
                                5
                            </span></i> Notifications
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                        <a class="dropdown-item" href="#">New notification</a>
                        <a class="dropdown-item" href="#">Notification 1</a>
                        <a class="dropdown-item" href="#">Notification 2</a>
                        <a class="dropdown-item" href="#">Notification 3</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Show all notifications</a>
                    </div>
                </li>

                <!-- Messaggi -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle text-white fs-6" href="#" id="messagesDropdown"
                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        data-bs-auto-close="false">
                        <i class="fa-solid fa-envelope fs-3 position-relative hype-text-shadow"><span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-active-primary-color  small fs-6">
                                2
                            </span></i> Messages
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                        <a class="dropdown-item" href="#">New messages</a>
                        <a class="dropdown-item" href="#">message 1</a>
                        <a class="dropdown-item" href="#">message 2</a>
                        <a class="dropdown-item" href="#">message 3</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Show all messages</a>
                    </div>
                </li>
            </ul>

            <!-- Link Profilo -->
            <ul class="navbar-nav me-2">
                <li class="nav-item">
                    <a class="nav-link text-white fs-6" href="#"><i
                            class="fa-solid fa-user fs-3 position-relative hype-text-shadow"></i> Profile</a>
                </li>
                <!-- Pulsante Logout -->
                <li class="nav-item"> <a class="nav-link text-white fs-6 " href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();"><i
                            class="fas fa-sign-out-alt fs-3 position-relative hype-text-shadow"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
