<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <!-- User content  -->
    <div class="user-container">
      <div class="login-div">
        <div class="user-info">
          <div class="head-info">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="80"
              height="80"
              viewBox="0 0 80 80"
              fill="none"
            >
              <circle
                cx="40"
                cy="40"
                r="39.3"
                fill="#FA528C"
                stroke="black"
                stroke-width="1.4"
              />
            </svg>
            <div class="user-id">
              <h4>Visitor 32479019</h4>
              <p class="ID">
                ID 32479019
                <span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="23"
                    viewBox="0 0 24 23"
                    fill="none"
                  >
                    <path
                      d="M19.4663 2.06689C20.4977 2.06689 21.333 2.90223 21.333 3.93356V16.0669C21.333 16.5821 20.9149 17.0002 20.3997 17.0002C19.8845 17.0002 19.4663 16.5821 19.4663 16.0669V3.93356H7.33301C6.81781 3.93356 6.39967 3.51543 6.39967 3.00023C6.39967 2.48503 6.81781 2.06689 7.33301 2.06689H19.4663ZM15.733 5.80023C16.7643 5.80023 17.5997 6.63556 17.5997 7.66689V18.8669C17.5997 19.8982 16.7643 20.7336 15.733 20.7336H4.53301C3.50167 20.7336 2.66634 19.8982 2.66634 18.8669V7.66689C2.66634 6.63556 3.50167 5.80023 4.53301 5.80023H15.733ZM15.733 7.66689H4.53301V18.8669H15.733V7.66689Z"
                      fill="white"
                      fill-opacity="0.5"
                    />
                  </svg>
                </span>
              </p>
            </div>
          </div>
          <button>Log In</button>
        </div>
        <div class="subscribe">
          <div class="sub-descr">
            <h4>Subscribe</h4>
            <p>Unlock more episodes</p>
          </div>
          <button onclick="window.open('https://www.youtube.com/@digitaldreamsictacademy1353', '_blank')">Subscribe Now</button>
        </div>
      </div>
      <div class="mywallet-div">
        <div class="head-div">
          <div class="head-title">
            <div class="ht">
              <h4>My Wallet</h4>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="29"
                height="29"
                viewBox="0 0 29 29"
                fill="none"
              >
                <path
                  d="M8.09245 2.14196C8.31969 2.14859 8.53544 2.24338 8.69401 2.40629L20.069 13.7813C20.233 13.9454 20.3252 14.1679 20.3252 14.3999C20.3252 14.632 20.233 14.8545 20.069 15.0186L8.69401 26.3936C8.61339 26.4776 8.51681 26.5446 8.40995 26.5908C8.30309 26.637 8.18809 26.6614 8.07168 26.6626C7.95527 26.6637 7.83979 26.6417 7.73201 26.5977C7.62424 26.5537 7.52632 26.4886 7.444 26.4063C7.36168 26.324 7.29662 26.2261 7.25262 26.1183C7.20861 26.0105 7.18656 25.895 7.18774 25.7786C7.18892 25.6622 7.21332 25.5472 7.25951 25.4403C7.30569 25.3335 7.37274 25.2369 7.45671 25.1563L18.2131 14.3999L7.45671 3.64359C7.33048 3.52065 7.2443 3.36247 7.20945 3.18974C7.17461 3.01701 7.19272 2.83779 7.26142 2.67552C7.33011 2.51326 7.4462 2.37551 7.59448 2.28031C7.74275 2.18511 7.91632 2.13689 8.09245 2.14196Z"
                  fill="white"
                  fill-opacity="0.5"
                />
              </svg>
            </div>
          </div>
          <div class="coins-count">
            <div class="coin">
              <h3><span>0</span> Coins</h3>
              <h3><span>0</span> Coins</h3>
            </div>
            <button>Top Up</button>
          </div>
        </div>
        <div class="wallet-body">
          <div class="wallet-items">
               <p>Rewards</p>
               <span class="reward_daily">
                 Reward from daily task
               </span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="29"
              height="29"
              viewBox="0 0 29 29"
              fill="none"
            >
              <path
                d="M8.09245 2.14245C8.31969 2.14908 8.53544 2.24387 8.69401 2.40678L20.069 13.7818C20.233 13.9459 20.3252 14.1684 20.3252 14.4004C20.3252 14.6325 20.233 14.855 20.069 15.0191L8.69401 26.3941C8.61339 26.4781 8.51681 26.5451 8.40995 26.5913C8.30309 26.6375 8.18809 26.6619 8.07168 26.663C7.95527 26.6642 7.83979 26.6422 7.73201 26.5982C7.62424 26.5542 7.52632 26.4891 7.444 26.4068C7.36168 26.3245 7.29662 26.2266 7.25262 26.1188C7.20861 26.011 7.18656 25.8955 7.18774 25.7791C7.18892 25.6627 7.21332 25.5477 7.25951 25.4408C7.30569 25.334 7.37274 25.2374 7.45671 25.1568L18.2131 14.4004L7.45671 3.64408C7.33048 3.52114 7.2443 3.36295 7.20945 3.19023C7.17461 3.0175 7.19272 2.83827 7.26142 2.67601C7.33011 2.51374 7.4462 2.376 7.59448 2.2808C7.74275 2.1856 7.91632 2.13738 8.09245 2.14245Z"
                fill="white"
                fill-opacity="0.5"
              />
            </svg>
          </div>
          <div class="wallet-items">
            <p>Feedback</p>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="29"
              height="29"
              viewBox="0 0 29 29"
              fill="none"
            >
              <path
                d="M8.09245 2.14245C8.31969 2.14908 8.53544 2.24387 8.69401 2.40678L20.069 13.7818C20.233 13.9459 20.3252 14.1684 20.3252 14.4004C20.3252 14.6325 20.233 14.855 20.069 15.0191L8.69401 26.3941C8.61339 26.4781 8.51681 26.5451 8.40995 26.5913C8.30309 26.6375 8.18809 26.6619 8.07168 26.663C7.95527 26.6642 7.83979 26.6422 7.73201 26.5982C7.62424 26.5542 7.52632 26.4891 7.444 26.4068C7.36168 26.3245 7.29662 26.2266 7.25262 26.1188C7.20861 26.011 7.18656 25.8955 7.18774 25.7791C7.18892 25.6627 7.21332 25.5477 7.25951 25.4408C7.30569 25.334 7.37274 25.2374 7.45671 25.1568L18.2131 14.4004L7.45671 3.64408C7.33048 3.52114 7.2443 3.36295 7.20945 3.19023C7.17461 3.0175 7.19272 2.83827 7.26142 2.67601C7.33011 2.51374 7.4462 2.376 7.59448 2.2808C7.74275 2.1856 7.91632 2.13738 8.09245 2.14245Z"
                fill="white"
                fill-opacity="0.5"
              />
            </svg>
          </div>
          <div class="wallet-items">
            <p>Language</p>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="29"
              height="29"
              viewBox="0 0 29 29"
              fill="none"
            >
              <path
                d="M8.09245 2.14245C8.31969 2.14908 8.53544 2.24387 8.69401 2.40678L20.069 13.7818C20.233 13.9459 20.3252 14.1684 20.3252 14.4004C20.3252 14.6325 20.233 14.855 20.069 15.0191L8.69401 26.3941C8.61339 26.4781 8.51681 26.5451 8.40995 26.5913C8.30309 26.6375 8.18809 26.6619 8.07168 26.663C7.95527 26.6642 7.83979 26.6422 7.73201 26.5982C7.62424 26.5542 7.52632 26.4891 7.444 26.4068C7.36168 26.3245 7.29662 26.2266 7.25262 26.1188C7.20861 26.011 7.18656 25.8955 7.18774 25.7791C7.18892 25.6627 7.21332 25.5477 7.25951 25.4408C7.30569 25.334 7.37274 25.2374 7.45671 25.1568L18.2131 14.4004L7.45671 3.64408C7.33048 3.52114 7.2443 3.36295 7.20945 3.19023C7.17461 3.0175 7.19272 2.83827 7.26142 2.67601C7.33011 2.51374 7.4462 2.376 7.59448 2.2808C7.74275 2.1856 7.91632 2.13738 8.09245 2.14245Z"
                fill="white"
                fill-opacity="0.5"
              />
            </svg>
          </div>
          <div class="wallet-items">
            <p>Settings</p>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="29"
              height="29"
              viewBox="0 0 29 29"
              fill="none"
            >
              <path
                d="M8.09245 2.14245C8.31969 2.14908 8.53544 2.24387 8.69401 2.40678L20.069 13.7818C20.233 13.9459 20.3252 14.1684 20.3252 14.4004C20.3252 14.6325 20.233 14.855 20.069 15.0191L8.69401 26.3941C8.61339 26.4781 8.51681 26.5451 8.40995 26.5913C8.30309 26.6375 8.18809 26.6619 8.07168 26.663C7.95527 26.6642 7.83979 26.6422 7.73201 26.5982C7.62424 26.5542 7.52632 26.4891 7.444 26.4068C7.36168 26.3245 7.29662 26.2266 7.25262 26.1188C7.20861 26.011 7.18656 25.8955 7.18774 25.7791C7.18892 25.6627 7.21332 25.5477 7.25951 25.4408C7.30569 25.334 7.37274 25.2374 7.45671 25.1568L18.2131 14.4004L7.45671 3.64408C7.33048 3.52114 7.2443 3.36295 7.20945 3.19023C7.17461 3.0175 7.19272 2.83827 7.26142 2.67601C7.33011 2.51374 7.4462 2.376 7.59448 2.2808C7.74275 2.1856 7.91632 2.13738 8.09245 2.14245Z"
                fill="white"
                fill-opacity="0.5"
              />
            </svg>
          </div>
        </div>
      </div>
    </div>
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
