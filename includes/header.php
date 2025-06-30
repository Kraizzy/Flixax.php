<!-- includes/header.php -->
<?php
session_start();
?>
<?php
// Get the base URL dynamically (useful if site is in a subfolder)
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

function fetchGenres()
{
  $url = 'http://linkskool.net/api/v3/public/movies/genres';
  $response = @file_get_contents($url);

  if ($response === false) {
    return []; // Return empty array on failure
  }

  $data = json_decode($response, true);
  return isset($data['data']) && is_array($data['data']) ? $data['data'] : [];
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Flixax</title>
  <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
</head>

<body>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navLinks = document.querySelectorAll('.nav-link');
      const pageName = window.location.pathname.split('/').pop() || 'home'; // fallback to 'home' on root

      navLinks.forEach(link => {
        const href = link.getAttribute('href');
        const linkPage = href.split('/').pop();

        if (linkPage === pageName) {
          link.classList.add('active');
        } else {
          link.classList.remove('active');
        }
      });
    });
  </script>

  <div class="nav-div">
    <nav class="nav-bar">
      <div class="navbar-content">
        <div class="logo-linkitem">
          <div class="nav-logo">
            <img onclick="window.location='<?= $baseUrl ?>/home'" src="assets/Artboard 2@3x.svg" alt="logo">

            <!-- <button class="hamburger" aria-label="Toggle menu"> -->
            <!-- simple 3-bar icon -->
            <!-- <span></span><span></span><span></span>
                        </button> -->
          </div>
          <ul class="nav-ulink">
            <li><a href="<?= $baseUrl ?>/home" class="nav-link"> Home </a></li>
            <li><a href="<?= $baseUrl ?>/watch" class="nav-link"> For You </a></li>
            <li><a href="<?= $baseUrl ?>/my-list" class="nav-link"> My List </a></li>
            <li><a href="<?= $baseUrl ?>/rewards" class="nav-link"> Rewards </a></li>
          </ul>
        </div>
        <!-- right list-item -->
        <div class="right-part">
          <div class="search-div">
            <form action="<?= $baseUrl ?>/search" method="GET">
              <svg
                class="search-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="21"
                height="20"
                viewBox="0 0 21 20"
                fill="none">
                <path
                  d="M9.04167 2.5C5.71481 2.5 3 5.21482 3 8.54167C3 11.8685 5.71481 14.5833 9.04167 14.5833C10.4055 14.5833 11.662 14.1221 12.6753 13.3545L16.5775 17.2559C16.6543 17.3358 16.7462 17.3997 16.848 17.4437C16.9498 17.4877 17.0593 17.5109 17.1702 17.512C17.281 17.5132 17.391 17.4922 17.4937 17.4502C17.5963 17.4083 17.6896 17.3464 17.768 17.268C17.8464 17.1896 17.9083 17.0963 17.9502 16.9937C17.9922 16.891 18.0132 16.781 18.012 16.6702C18.0109 16.5593 17.9877 16.4498 17.9437 16.348C17.8997 16.2462 17.8358 16.1543 17.7559 16.0775L13.8545 12.1753C14.6221 11.162 15.0833 9.90548 15.0833 8.54167C15.0833 5.21482 12.3685 2.5 9.04167 2.5ZM9.04167 4.16667C11.4678 4.16667 13.4167 6.11555 13.4167 8.54167C13.4167 9.70655 12.9642 10.7586 12.2285 11.5405C12.1569 11.5924 12.094 11.6553 12.0422 11.7269C11.26 12.4635 10.2074 12.9167 9.04167 12.9167C6.61555 12.9167 4.66667 10.9678 4.66667 8.54167C4.66667 6.11555 6.61555 4.16667 9.04167 4.16667Z"
                  fill="white"
                  fill-opacity="0.7" />
              </svg>
              <input
                type="text"
                placeholder="Browser by Minister"
                class="search-box"
                required
                name="query" />
            </form>

            <div class="filter-div">
              <ul class="filter-ul">
                <li class="filter-link">
                  <svg
                    class="filter-icon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="24"
                    viewBox="0 0 25 24"
                    fill="none">
                    <path
                      d="M4.75 3C4.0682 3 3.5 3.5682 3.5 4.25V5.79492C3.5 6.94325 4.02774 8.02942 4.92969 8.74023L10 12.7354V20.25C10.0001 20.3877 10.0381 20.5228 10.1098 20.6404C10.1816 20.7579 10.2843 20.8535 10.4067 20.9165C10.5292 20.9796 10.6667 21.0077 10.804 20.9978C10.9414 20.9879 11.0734 20.9403 11.1855 20.8604L14.6855 18.3604C14.7828 18.291 14.862 18.1994 14.9167 18.0933C14.9714 17.9871 15 17.8694 15 17.75V12.7344L20.0703 8.74023C20.9723 8.02942 21.5 6.94325 21.5 5.79492V4.25C21.5 3.5682 20.9318 3 20.25 3H4.75ZM5 4.5H20V5.79492C20 6.4846 19.6846 7.13434 19.1426 7.56152L14.1436 11.5H10.8564L5.85742 7.56152C5.31537 7.13434 5 6.4846 5 5.79492V4.5ZM11.5 13H13.5V17.3643L11.5 18.793V13Z"
                      fill="white" />
                  </svg>
                </li>
              </ul>
              <!-- dropdownmenu -->
              <ul class="dropdown-menu">
                <?php
                $genres = fetchGenres();
                if (empty($genres)) {
                  echo '<li><a href="#" class="dropdown-links">Error loading genres</a></li>';
                } else {
                  foreach ($genres as $genre) {
                    $genreId = htmlspecialchars($genre['id'], ENT_QUOTES, 'UTF-8');
                    $genreName = htmlspecialchars($genre['name'], ENT_QUOTES, 'UTF-8');
                    echo "<li><a href=\"filter?genre_id=$genreId\" class=\"dropdown-links\">$genreName</a></li>";
                  }
                }
                ?>
              </ul>
            </div>
          </div>
          <div class="gift-filter-user">
            <div onclick="window.location.href='<?= $baseUrl ?>/rewards'" class="gift-div">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="41"
                height="40"
                viewBox="0 0 41 40"
                fill="none">
                <path
                  d="M4.66666 14.1665V34.1665C4.66666 35.0873 5.41249 35.8332 6.33332 35.8332H31.3333V14.1665H4.66666Z"
                  fill="#CF1928" />
                <path
                  d="M31.3333 14.1665V35.8332H35.5C36.4208 35.8332 37.1667 35.0873 37.1667 34.1665V14.1665H31.3333Z"
                  fill="#B31523" />
                <path
                  d="M33 14.1665V9.1665H3.83333C3.37333 9.1665 3 9.53984 3 9.99984V13.3332C3 13.7932 3.37333 14.1665 3.83333 14.1665H33Z"
                  fill="#EB6773" />
                <path
                  d="M33 9.1665V14.1665H38C38.46 14.1665 38.8333 13.7932 38.8333 13.3332V9.99984C38.8333 9.53984 38.46 9.1665 38 9.1665H33Z"
                  fill="#D9414F" />
                <path
                  d="M20.5 9.1665H16.3333V35.8332H20.5V9.1665Z"
                  fill="#EDBE00" />
                <path
                  d="M21.3333 9.16688H14.6667L11.5775 6.07771C11.2517 5.75188 11.2517 5.22438 11.5775 4.89938L13.7325 2.74438C14.0583 2.41854 14.5858 2.41854 14.9108 2.74438L21.3333 9.16688Z"
                  fill="#E3A600" />
                <path
                  d="M18.8333 9.16688H25.5L28.5892 6.07771C28.915 5.75188 28.915 5.22438 28.5892 4.89938L26.4342 2.74438C26.1083 2.41854 25.5808 2.41854 25.2558 2.74438L18.8333 9.16688Z"
                  fill="#EDBE00" />
              </svg>
            </div>
            <!-- User button -->
            <div class="user-div">
              <div class="user-icon-border">
                <div class="user-avatar-wrapper user-trigger">
                  <img id="user-avatar" src="" alt="Avatar" style="display: none;" width="20" height="20" />
                  <div id="user-initial" class="user-initial-circle" style="display: none;" width="20" height="20"></div>
                  <img src="assets/icons8_male_user 2.svg" alt="Avatar" id="user-default-icon" class="user-default-icon" style="display: block;" />
                </div>
                <div class="user-dropdown-icon"><img src="assets/dropdown-svgrepo-com.svg" alt="" width="23" height="23"></div>
              </div>
              <a href="<?= $baseUrl ?>/user" id="userLink" style="font-size: 1.3rem; background: white; display:flex" class="nav-link user-trigger"></a>

              <ul class="user-ul">
                <li>
                  <div class="uListmenu"><img src="assets/account_circle_25dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt="."><button onclick="window.location.href='<?= $baseUrl ?>/user'" id="user-profile" class="user-email" style="font-weight: 500;"></button></div>
                </li>
                <li class="user-li">
                  <div class="uListmenu" onclick="window.location.href='<?= $baseUrl ?>/user'"><img src="assets/user_attributes_25dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt=".">
                    <button class="user-email">Profile</button>
                  </div>
                </li>
                <li>
                  <div class='uListmenu'><img src="assets/login_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg" alt="."><button id="auth-action" class="user-email" style="padding-right: 20px;">Log In</button></div>
                </li>
              </ul>
            </div>
          </div>
    </nav>
  </div>
  <script type="module">
    import {
      auth,
      provider,
      signInWithPopup,
      signOut,
      onAuthStateChanged
    } from './assets/js/firebase.js';

    window.addEventListener("DOMContentLoaded", () => {
      const avatar = document.getElementById("user-avatar");
      const initial = document.getElementById("user-initial");
      const defaultIcon = document.getElementById("user-default-icon");
      const profileBtn = document.getElementById("user-profile");
      const authBtn = document.getElementById("auth-action");

      function getUserInitials(displayName, email) {
        if (displayName && displayName.trim()) {
          const names = displayName.trim().split(" ");
          return (names[0][0] + names[names.length - 1][0]).toUpperCase();
        } else if (email) {
          return email[0].toUpperCase();
        }
        return "U";
      }

      onAuthStateChanged(auth, (user) => {
        if (user) {
          // ✅ Show avatar or initials
          if (user.photoURL && avatar) {
            avatar.src = user.photoURL;
            avatar.alt = user.displayName || "assets/avatar-default-svgrepo-com.svg";
            avatar.style.display = "block";
            if (initial) initial.style.display = "none";
            if (defaultIcon) defaultIcon.style.display = "none";
          } else {
            if (initial) {
              initial.textContent = getUserInitials(user.displayName, user.email);
              initial.style.display = "flex";
            }
            if (avatar) avatar.style.display = "none";
            if (defaultIcon) defaultIcon.style.display = "none";
          }

          // ✅ Update profile and auth buttons
          if (profileBtn) {
            profileBtn.textContent = user.email || "Profile";
            profileBtn.onclick = () => window.location.href = '<?= $baseUrl ?>/user';
          }

          if (authBtn) {
            authBtn.textContent = "Logout";
            authBtn.onclick = async () => {
              try {
                await signOut(auth);
              } catch (e) {
                console.error("Logout error", e);
              }
            };
          }

        } else {
          // ❌ User is NOT signed in
          if (avatar) avatar.style.display = "none";
          if (initial) initial.style.display = "none";
          if (defaultIcon) defaultIcon.style.display = "block";

          if (profileBtn) {
            profileBtn.textContent = "User";
            profileBtn.onclick = () => window.location.href = '<?= $baseUrl ?>/user';
          }

          if (authBtn) {
            authBtn.textContent = "Login";
            authBtn.onclick = async () => {
              try {
                await signInWithPopup(auth, provider);
              } catch (e) {
                console.error("Login error", e);
              }
            };
          }
        }
      });
    });
  </script>

  <script>
    // wait until the DOM is fully parsed
    window.addEventListener("DOMContentLoaded", () => {
      const filterDiv = document.querySelector(".filter-div");
      const dropdown = document.querySelector(".dropdown-menu");

      filterDiv.addEventListener("click", (e) => {
        e.stopPropagation();
        filterDiv.classList.toggle("open");
      });

      // closes it
      document.addEventListener("click", () => {
        filterDiv.classList.remove("open");
      });
      // Hambuger
      const nav = document.querySelector(".nav-bar");
      const toggle = nav.querySelector(".hamburger");

      toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        nav.classList.toggle("open");
      });

      // close menu when clicking outside
      document.addEventListener("click", () => {
        nav.classList.remove("open");
      });

    });
  </script>
</body>

</html>