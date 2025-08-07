<?php
session_start();

// Strict require this file, not 'require_once'
require('config.php');

// Define registered account's access levels
define('USER_ACCESS_LEVEL', 1);
define('ADMIN_ACCESS_LEVEL', 2);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    return;
}
/** @var $conn */

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">


<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Website title -->
    <title>Cyber City</title>
    <script type="text/javascript">function doUnauthRedirect() {
            location.replace("http://10.177.200.71/index.html")
        }</script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Bootstrap CSS & Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/css/moduleList.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/css/leaderboard.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL; ?>assets/css/editAccount.css">
    <link rel="icon" type="image/png" href="<?= BASE_URL; ?>assets/img/CCLogo.png">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid nav-bar">

            <!--Start of Navigation Bar (left side)-->
            <a class="navbar-brand">Cyber City</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="<?= BASE_URL; ?>index.php" class="nav-link text-black"
                           style="padding-left: 2rem;">Home</a>
                    </li>
                    <?php if (isset($_SESSION['username']) && $_SESSION['access_level'] == ADMIN_ACCESS_LEVEL): ?>
                    <?php
                    // Fetch user information from the database
                    $userToLoad = $_SESSION['user_id'];
                    $query = "SELECT Score FROM Users WHERE ID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$userToLoad]);
                    $userInformation = $stmt->fetch();

                    $userScore = $userInformation['Score'];
                    ?>
                        <!--Admin panel section of navbar with links to admin settings for website-->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-black dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Panel
                            </a>
                            <ul class="dropdown-menu">
                                <a href="<?= BASE_URL; ?>pages/admin/userList.php" class="dropdown-item">Enabled User
                                    List</a>


                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/disabledUsers.php" class="dropdown-item">Disabled
                                        User List</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/contact page.php" class="dropdown-item">View
                                        Contact Requests</a>
                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/readContactRequests.php"
                                       class="dropdown-item">Read
                                        Contact Requests</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/challengeRegister.php" class="dropdown-item">Add
                                        New Modules & Challenges</a>
                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/resetGame.php" class="dropdown-item">Reset
                                        Game</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/contactpage.php" class="dropdown-item">View
                                        Contact
                                        Requests</a>
                                <li>
                                    <a href="<?= BASE_URL; ?>pages/admin/readContactRequests.php"
                                       class="dropdown-item">Read
                                        Contact Requests</a>
                                </li>

                            </ul>
                    <li class="nav-item">
                        <a href="<?= BASE_URL; ?>pages/leaderboard/leaderboard.php" class="nav-link text-black">Leaderboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://forms.gle/jgYrmMZesgtVhBZ39" class="nav-link text-black"
                           target="_blank">Feedback</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-black dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            project dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <a class="dropdown-item"
                               href="<?= BASE_URL; ?>pages/challenges/challengesList.php?projectID=1">2025
                                Project</a>
                            <li><a class="dropdown-item"
                                   href="<?= BASE_URL; ?>pages/challenges/challengesList.php?projectID=2">2026
                                    Project</a>
                            </li>
                        </li><hr class="dropdown-divider">
                        <li>
                            <a href="http://10.177.200.71/CyberCityDocs/welcome.html" class="nav-link text-black"
                            target="_blank">Tutorials</a>
                        </li>
                </ul>
                </li>

                <?php elseif (isset($_SESSION['username']) && $_SESSION['access_level'] == USER_ACCESS_LEVEL): ?>
                    <?php
                    // Fetch user information from the database
                    $userToLoad = $_SESSION['user_id'];
                    $query = "SELECT Score FROM Users WHERE ID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$userToLoad]);
                    $userInformation = $stmt->fetch();

                    $userScore = $userInformation['Score'];
                    ?>
                     <li class="nav-item">
                         <a href="<?= BASE_URL; ?>pages/leaderboard/leaderboard.php" class="nav-link text-black">Leaderboard</a>
                     </li>
                     <li class="nav-item">
                         <a href="https://forms.gle/jgYrmMZesgtVhBZ39" class="nav-link text-black"
                         target="_blank">Feedback</a>
                     </li>
                     <li class="nav-item dropdown">
                         <a class="nav-link text-black dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                             project dropdown
                         </a>
                         <ul class="dropdown-menu">
                             <a class="dropdown-item"
                                href="<?= BASE_URL; ?>pages/challenges/challengesList.php?projectID=1">2025
                                 Project</a>
                             <li><a class="dropdown-item"
                                    href="<?= BASE_URL; ?>pages/challenges/challengesList.php?projectID=2">2026
                                     Project</a>
                             </li>
                             </li><hr class="dropdown-divider">
                             <li>
                                 <a href="http://10.177.200.71/CyberCityDocs/welcome.html" class="nav-link text-black"
                                    target="_blank">Tutorials</a>
                             </li>
                         </ul>
                     </li>
                </ul>
            </div>


                    <!-- End of Navigation Bar (left side) -->

                <?php endif; ?>

                        <!-- Start of Navigation Bar (right side) -->
                        <ul class="navbar-nav ms-auto">
                            <button id="modeToggle" class="btn btn-outline-secondary mode-toggle-btn">
                                Switch to Dark Mode
                            </button>
                            <?php if (isset($_SESSION['username'])): ?>
                                <li class="nav-link dropdown">
                                    <a href="#" class="nav-link dropdown-toggle text-black" id="navbarDropdown"
                                       data-bs-toggle="dropdown"
                                       aria-expanded="false"><?= htmlspecialchars($_SESSION['username']); ?></a>

                                    <!-- Control the amount of support requests sent to the admin on the website section -->
                                    <!-- TODO: Seriously ?!? -->
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <!-- Direct link to 'Edit Account' page on user-level of access -->
                                        <li class="nav-link active">
                                            <a href="<?= BASE_URL; ?>pages/user/editAccount.php" class="dropdown-item">Edit
                                                Account</a>
                                        </li>

                                        <!-- Logged-in account's current score text (both admin & non-admin account) -->
                                        <li class="nav-link active">
                                            <a class="dropdown-item">Score: <?= htmlspecialchars($userScore); ?></a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Logged-out the current logged-in account -->
                                <li class="nav-link active">
                                    <a href="<?= BASE_URL; ?>pages/user/logout.php" class="nav-link"
                                       style="color: #000000;">Logout</a>
                                </li>

                                <!-- Non-admin account specific navigation bar elements -->
                                <?php if ($_SESSION['access_level'] == USER_ACCESS_LEVEL): ?>
                                    <!-- Direct link to 'Contact Us' page on non-admin account -->
                                    <li class="nav-link active">
                                        <!--                            <a href="-->
                                        <?php //= BASE_URL; ?><!--pages/contactUs/contact.php" class="nav-link text-white">Contact-->
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <!-- Neither non-admin access level nor admin access level -->
                            <?php else: ?>
                                <!-- Register new account / Logged back in current or old account -->
                                <ul class="navbar-nav ms-auto">

                                    <!-- Direct link to 'Register' page if users are currently just view through the website -->
                                    <li class="nav-link active">
                                        <a href="<?= BASE_URL; ?>pages/user/register.php" class="nav-link"
                                           style="color: indianred;">Register</a>
                                    </li>

                                    <!-- Direct link to 'Login' page if users are currently just view through the website -->
                                    <li class="nav-link active">
                                        <a href="<?= BASE_URL; ?>pages/user/login.php"
                                           class="nav-link text-black">Login</a>
                                    </li>
                                </ul>
                            <?php endif; ?>

                            <!-- End of Navigation Bar (right side) -->
                        </ul>

                        <!-- End of Navigation Bar class -->
            </div>
        </div>
        <!-- End Navigation Bar -->
    </nav>

    <!-- Best approach to comment out PHP mixed with HTML code that also have comment with it -->
    <?php /* ?>

    Flash confirm message to indicating users successfully logged-in/registered into the website
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="position-absolute top-15 end-0"><?= htmlspecialchars($_SESSION['flash_message']); ?></div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <?php // */ ?>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <?php $message = $_SESSION['flash_message']; ?>

        <!-- Flash message positioned on the top (?) when confirming the needed condition -->
        <div class="position-static"><?= $message; ?></div>

        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <!-- Boostrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <script>
        const modeToggleBtn = document.getElementById('modeToggle');
        const body = document.body;

        // Check the saved theme in localStorage and apply it
        const savedTheme = localStorage.getItem('theme');

        if (savedTheme) {
            if (savedTheme === 'bg-dark text-white') {

                modeToggleBtn.textContent = 'Switch to Light Mode';
                body.classList.add('bg-dark', 'text-white');
            } else {
                body.classList.add('bg-light', 'text-black');
                modeToggleBtn.textContent = 'Switch to Dark Mode';
            }
        }

        modeToggleBtn.addEventListener('click', function () {
            if (body.classList.contains('bg-light')) {
                // Switch to dark mode
                body.classList.replace('bg-light', 'bg-dark');
                body.classList.replace('text-black', 'text-white');
                modeToggleBtn.textContent = 'Switch to Light Mode'; // Update button text
                // Save the dark mode preference in localStorage
                localStorage.setItem('theme', 'bg-dark text-white');
            } else {
                // Switch to light mode
                body.classList.replace('bg-dark', 'bg-light');
                body.classList.replace('text-white', 'text-black');
                modeToggleBtn.textContent = 'Switch to Dark Mode'; // Update button text
                // Save the light mode preference in localStorage
                localStorage.setItem('theme', 'bg-light text-black');
            }
        });
    </script>


    <?php
    /**
     * sanitise input data to prevent XSS and other attacks
     *
     * @param string $data The data to sanitise
     * @return string The sanitised data
     */
    function sanitise_data($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    /**
     * Confirm if the user is authorised to access individual pages
     *
     * @param bool $unauthorisedUsers Allow unauthorised users
     * @param bool $users Allow regular users
     * @param bool $admin Allow administrators
     * @return bool True if user is authorised, false otherwise
     */
    function authorisedAccess($unauthorisedUsers, $users, $admin)
    {
        // Unauthenticated User
        if (!isset($_SESSION["username"])) {
            if (!$unauthorisedUsers) {
                $_SESSION['flash_message'] = "<div class='bg-danger'>Access Denied</div>";
                return false;
            }
        } else {
            // Regular User
            if ($_SESSION["access_level"] == USER_ACCESS_LEVEL && !$users) {
                $_SESSION['flash_message'] = "<div class='bg-danger'>Access Denied</div>";
                return false;
            }

            // Administrators
            if ($_SESSION["access_level"] == ADMIN_ACCESS_LEVEL && !$admin) {
                return false;
            }
        }

        // Otherwise, let them through
        return true;
    }

    ?>
    </body>

</html>
