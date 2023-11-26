

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        :root {
            --poppins: 'Poppins', sans-serif;
            --light: #F9F9F9;
            --blue: #3C91E6;
            --light-blue: #CFE8FF;
            --grey: #eee;
            --dark-grey: #AAAAAA;
            --dark: #342E37;
            --red: #DB504A;
            --yellow: #FFCE26;
            --light-yellow: #FFF2C6;
            --orange: #FD7238;
            --light-orange: #FFE0D3;
            --green: #30ee59;
            --light-green: #90e9a4;
        }

        html {
            overflow-x: hidden;
        }

        body {
            background: var(--grey);
            overflow-x: hidden;
            margin: 0;
        }

        body.dark {
            --light: #0C0C1E;
            --grey: #060714;
            --dark: #FBFBFB;
        }

        /* CONTENT */
        #content {
            position: relative;
            width: 100%;
            transition: .3s ease;
            margin-left: 0;
            margin-bottom: 0;
        }

        /* NAVBAR */
        #content nav {
            height: 56px;
            background: var(--light);
            padding: 0 24px;
            display: flex;
            align-items: center;
            font-family: var(--poppins);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
        }

        #content nav a {
            color: var(--dark);
            margin-right: 5px; /* Adjust the margin as needed */
        }

        #content nav .nav-link {
            font-size: 16px;
            transition: .3s ease;
        }

        #content nav .nav-link:hover {
            color: var(--blue);
        }

        #content .side-menu {
            display: flex;
            align-items: center; 
            margin-left: auto;
            margin-top: 10px;
        }

        #content .side-menu li {
            height: 48px;
            background: transparent;
            margin-right: 5px;
            margin-left: 5px;
            padding: 4px;
        }

        #content .side-menu li.active {
        position: relative;
        }

        #content .side-menu li.active::before {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            top: -40px;
            right: 0;
            background: var(--light);
            transform: scale(0);
            transition: transform 0.3s ease;
            z-index: -1;
        }

        #content .side-menu li.active:hover::before {
            transform: scale(1);
        }


        #content .side-menu li a {
            background: var(--light);
            display: flex;
            align-items: center;
            padding: 0 16px;
            border-radius: 48px;
            font-size: 16px;
            color: var(--dark);
            white-space: nowrap;
            overflow-x: hidden;
        }

        #content .side-menu.top li.active a {
            color: var(--blue);
        }

        #content .side-menu li a.logout {
            color: var(--red);
        }

        #content .side-menu.top li a:hover {
            color: var(--blue);
        }

        #content .side-menu li a .bx {
            display: flex;
            justify-content: center;
        }

        #content .logo{
            width: 40px;
            margin-right: 0.6rem;
            margin-top: 0.3rem;
            margin-left: 0.6rem;
        }

        #content .brand {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            color: var(--blue);
            top: 0;
            left: 0;
            background: var(--light);
            z-index: 1000;
            box-sizing: content-box;
        }

        #content nav .nav-link.active {
            color: var(--blue);
        }

        .notification-item {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #f9f9f9;
        }

        .notification-item p {
            margin: 0;
        }

        .notification-item.read {
            background-color: #f9f9f9;
        }

        .notification-item.unread {
            background-color: #e6f7ff;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <a href="homepage.php" class="brand">
                <img src="../image/lc.png" class="logo">
                <span class="text">Community Forum</span>
            </a>

            <ul class="side-menu top">
                <li>
                    <a href="forum.php" class="nav-link">
                        <i class='bx bxs-news'></i>&nbsp;
                        <span class="text">Forum Feed</span>
                    </a>
                </li>
                <li>
                    <a href="my-posts.php" class="nav-link">
                        <i class='bx bxs-note'></i>&nbsp;
                        <span class="text">My Post</span>
                    </a>
                </li>
                <li>
                    <a href="forum-post.php" class="nav-link">
                        <i class='bx bxs-pen'></i>&nbsp;
                        <span class="text">Create Post</span>
                    </a>
                </li>
                
                <li>
                    <a href="homepage.php" class="nav-link">
                        <i class='bx bxs-home'></i>&nbsp;
                        <span class="text">Homepage</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- NAVBAR -->
    </section>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const currentUrl = window.location.href;

        const navLinks = document.querySelectorAll("#content nav .nav-link");

        navLinks.forEach(link => {
            const linkUrl = link.getAttribute("href");

            // Check if the current URL matches the link's URL
            if (currentUrl.includes(linkUrl)) {
                link.classList.add("active");
            }

            link.addEventListener("click", function (event) {
                event.preventDefault();

                // Remove "active" class from all links
                navLinks.forEach(navLink => {
                    navLink.classList.remove("active");
                });

                // Add "active" class to the clicked link
                this.classList.add("active");

                // Get the href attribute of the clicked link
                const pageHref = this.getAttribute("href");

                // Redirect to the clicked page after a short delay
                setTimeout(() => {
                    window.location.href = pageHref;
                }, 100); // Adjust the delay as needed
            });
        });
    });
</script>

</body>
</html>
