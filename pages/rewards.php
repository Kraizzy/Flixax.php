<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    <script>
// Function to start the rotation animation
function startRotation() {
    const coin1 = document.querySelector('.coin-background');
    const coin2 = document.querySelector('.coin-background2');
    if (coin1) coin1.classList.add('rotate');
    if (coin2) coin2.classList.add('rotate');
}

// Function to stop the rotation animation
function stopRotation() {
    const coin1 = document.querySelector('.coin-background');
    const coin2 = document.querySelector('.coin-background2');
    if (coin1) coin1.classList.remove('rotate');
    if (coin2) coin2.classList.remove('rotate');
}

// Start animation when the page loads
window.addEventListener('load', startRotation);

// Stop animation when the page is hidden and resume when visible
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        stopRotation();
    } else {
        startRotation();
    }
});

// Stop animation when the user leaves the page
window.addEventListener('beforeunload', stopRotation);
</script>
<script>
// Function to start the blinking animation
function startBlinking() {
    const stars = document.querySelectorAll('.rewardStars1, .rewardStars2, .rewardStars3, .rewardStars5, .rewardStars6, .rewardStars7');
    stars.forEach(star => star.classList.add('blink'));
}

function stopBlinking() {
    const stars = document.querySelectorAll('.rewardStars1, .rewardStars2, .rewardStars3, .rewardStars5, .rewardStars6, .rewardStars7');
    stars.forEach(star => star.classList.remove('blink'));
}

// Start animation when the page loads
window.addEventListener('load', startBlinking);

// Stop animation when the page is hidden and resume when visible
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        stopBlinking();
    } else {
        startBlinking();
    }
});

// Stop animation when the user leaves the page
window.addEventListener('beforeunload', stopBlinking);
</script>
<script>
// Track the current task user is doing
let currentTask = null;

// Called on button click
function openTaskLink(taskName, url) {
  currentTask = taskName;
  localStorage.setItem("lastOpenedTask", taskName);
  localStorage.setItem("taskPending", "true");
  window.open(url, "_blank");
}

document.addEventListener("visibilitychange", () => {
  if (document.visibilityState === "visible") {
    const taskName = localStorage.getItem("lastOpenedTask");
    const isPending = localStorage.getItem("taskPending");

    if (taskName && isPending === "true" && !localStorage.getItem(`taskDone_${taskName}`)) {
      // Mark task as completed
      localStorage.setItem(`taskDone_${taskName}`, "true");
      localStorage.setItem("taskPending", "false");

      // Add bonus (increment logic)
      let bonus = parseInt(localStorage.getItem("bonus-value") || "0", 10);
      bonus += 200;
      localStorage.setItem("bonus-value", bonus);

      // Update the bonus display
      const bonusDisplay = document.getElementById("bonus-value");
      if (bonusDisplay) {
        bonusDisplay.innerText = bonus;
      }

      // Hide the completed task div
      const completedDiv = document.querySelector(`[data-task="${taskName}"]`);
      if (completedDiv) {
        completedDiv.style.display = "none";
      }

      // Reset currentTask
      currentTask = null;

      // Check if all tasks are now done
      checkAllTasksCompleted();
    }
  }
});

window.addEventListener("DOMContentLoaded", () => {
  const tasks = document.querySelectorAll(".reward-content[data-task]");
  let allDone = true;

  tasks.forEach(task => {
    const taskName = task.getAttribute("data-task");
    if (localStorage.getItem(`taskDone_${taskName}`)) {
      task.style.display = "none";
    } else {
      allDone = false;
    }
  });

  // Show stored bonus
  const storedBonus = parseInt(localStorage.getItem("bonus-value") || "0", 10);
  const bonusDisplay = document.getElementById("bonus-value");
  if (bonusDisplay) {
    bonusDisplay.innerText = storedBonus;
  }

  // Show "come back tomorrow" if all tasks already done
  if (allDone) {
    showAllDoneMessage();
  }
});

function checkAllTasksCompleted() {
  const tasks = document.querySelectorAll(".reward-content[data-task]");
  const allDone = [...tasks].every(task => {
    const taskName = task.getAttribute("data-task");
    return localStorage.getItem(`taskDone_${taskName}`);
  });

  if (allDone) {
    showAllDoneMessage();
  }
}

function showAllDoneMessage() {
  const doneMessage = document.querySelector(".all-done-message");
  if (doneMessage) {
    doneMessage.style.display = "flex";
  }
}
</script>



  <div class="section">
      <div class="bg">
        <div id="bonus-container" class="bonus-count">
          <h3>Your Bonus:</h3>
          <p id="bonus-value">0</p>
        </div>
        <div class="svgs">
          <img class="coin-background" src="assets/background-complete.svg" alt="coins">
          <img class="coin1" src="assets/Coins.svg" alt="coins" />
           <img class="coin-background2" src="assets/background-complete.svg" alt="coins">
          <img class="coin2" src="assets/Coins.svg" alt="src" />
          <img src="assets\star.svg" alt="stars" class="rewardStars1">
          <img src="assets\star.svg" alt="stars" class="rewardStars2">
          <img src="assets\star.svg" alt="stars" class="rewardStars3">
          <img src="assets\star.svg" alt="stars" class="rewardStars4">
          <img src="assets\star.svg" alt="stars" class="rewardStars5">
          <img src="assets\star.svg" alt="stars" class="rewardStars6">
          <img src="assets\star.svg" alt="stars" class="rewardStars7">
          <img src="assets\star.svg" alt="stars" class="rewardStars8">
        </div>
      </div>
      <div class="content-div">
        <div class="wrap-div">
          <div class="dailycheckin-div">
            <div class="div-title">
              <h3>Daily check-in</h3>
              <p>Earn rewards for checking in</p>
            </div>
            <div class="point-container">
              <div class="point-content" id="day1">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 1</p>
              </div>
              <div class="point-content" id="day2">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 2</p>
              </div>
              <div class="point-content" id="day3">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 3</p>
              </div>
              <div class="point-content" id="day4">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 4</p>
              </div>
              <div class="point-content" id="day5">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 5</p>
              </div>
              <div class="point-content" id="day6">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 6</p>
              </div>
              <div class="point-content" id="day7">
                <div class="points-div">
                  <div class="points">
                    <p>+25</p>
                    <img id="coin" src="assets\icons8_coins 1.svg" alt="coin">
                    <img src="assets\icons8_coins 1.svg" alt="coin">
                    <img id="coin2" src="assets\icons8_coins 2.svg" alt="coin">
                  </div>
                </div>
                <p>Day 7</p>
              </div>
            </div>
            <button id="claim-reward">Click To Get Reward</button>
          </div>
          <div class="beginnertask-div">
            <div class="div-title">
              <h3>Beginner Tasks</h3>
              <p>Do simple tasks and win bonuses</p>
            </div>
            <div class="reward-container">
              <div class="reward-content" data-task="facebook">
                <img src="assets\icons8_facebook 1.svg" alt="facebook_icon">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Follow us on Facebook</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button id="fbBtn" onclick="openTaskLink('facebook', 'https://www.facebook.com/digitaldreamsng')">Go</button>
                </div>
              </div>
              <div class="reward-content" data-task="youtube">
                <img src="assets\icons8_play_button 1.svg" alt="youtube_icon">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Follow us on YouTube</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button id="youtubeBtn" onclick="openTaskLink('youtube', 'https://www.youtube.com/@digitaldreamsictacademy1353')">Go</button>
                </div>
              </div>
              <div class="reward-content" data-task="tiktok">
                <img src="assets\icons8_tiktok 1.svg" alt="tiktok_icon">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Follow us on TikTok</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button id="tiktokBtn" onclick="openTaskLink('tiktok', 'https://www.youtube.com/@digitaldreamsictacademy1353')">Go</button>
                </div>
              </div>
              <div class="reward-content" data-task="instagram">
                <img src="assets\icons8_instagram 1.svg" alt="ig_icon">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Follow us on Instagram</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button id="instaBtn" onclick="openTaskLink('instagram', 'https://www.youtube.com/@digitaldreamsictacademy1353')">Go</button>
                </div>
              </div>
              <div class="reward-content" data-task="X">  
                <img src="assets\icons8_instagram 1.svg" alt="ig_icon">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Follow us on X</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button onclick="openTaskLink('X', 'https://x.com/digitaldreamsNG')">Go</button>
                </div>
              </div>
              <div class="reward-content" data-task="notification">
                <img src="assets\icons9_coins 1.svg" alt="coin" width="59" height="59">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Turn on notifications</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button onclick="openTaskLink('notification', 'https://x.com/digitaldreamsNG')">Go</button>
                </div>
              </div>
              <div class="reward-content all-done-message" style="display: none;">
  <div class="typodiv">
    <div class="content-typo">
      <h3>All Tasks Completed!</h3>
      <p>🎉 Come back tomorrow for another reward.</p>
    </div>
  </div>
</div>

            </div>
          </div>
          <div class="watchads-div">
            <div class="div-title">
              <h3>Watch Ads, Win big</h3>
              <p>Do simple tasks and win bonuses</p>
            </div>
            <div class="watchads-container">
              <div class="reward-content">
                <img src="assets\icons9_coins 1.svg" alt="coin" width="59" height="59">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Turn on notifications</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button>Get</button>
                </div>
              </div>
              <div class="reward-content">
                <img src="assets\icons9_coins 1.svg" alt="coin" width="59" height="59">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Turn on notifications</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button>Get</button>
                </div>
              </div>
              <div class="reward-content">
                <img src="assets\icons9_coins 1.svg" alt="coin" width="59" height="59">
                <div class="typodiv">
                  <div class="content-typo">
                    <h3>Turn on notifications</h3>
                    <p>+200 Bonus</p>
                  </div>
                  <button>Get</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button onclick="localStorage.clear(); location.reload();">Reset Progress</button>


            <script>document.addEventListener("DOMContentLoaded", function () {
    const bonusValue = document.getElementById("bonus-value");
    const bonusContainer = document.getElementById("bonus-container");
    const days = document.querySelectorAll(".point-content");
    const claimButton = document.getElementById("claim-reward");

    let currentDayIndex = parseInt(localStorage.getItem("claimedDayIndex")) || 0;
    let bonusTotal = parseInt(localStorage.getItem("bonus-value")) || 0;
    const lastClaimTimestamp = parseInt(localStorage.getItem("lastClaimTimestamp")) || 0;

    bonusValue.innerText = bonusTotal;

    // Disable if already claimed today
    const now = Date.now();
    const oneDay = 24 * 60 * 60 * 1000;

    if (now - lastClaimTimestamp < oneDay) {
        claimButton.disabled = true;
        claimButton.innerText = "Come Back Tomorrow";
    }

    // Style already claimed days
    for (let i = 0; i < currentDayIndex; i++) {
        const day = days[i];
        const pointsDiv = day.querySelector(".points-div");
        const staticCoin = day.querySelector("img:not(#coin):not(#coin2)");
        const replacementCoin = day.querySelector("#coin2");
        if (pointsDiv) {
            pointsDiv.style.background = "linear-gradient(131deg, #FFBE00 3.18%, #FF55FD 53.67%, #7FBBFF 98.69%)";
            pointsDiv.classList.add("claimed");
        }
        if (staticCoin) staticCoin.style.opacity = "0";
        if (replacementCoin) replacementCoin.style.opacity = "1";
    }

    claimButton.addEventListener("click", () => {
        if (claimButton.disabled) return;

        if (currentDayIndex >= days.length) {
            alert("You've claimed all 7 rewards!");
            return;
        }

        const day = days[currentDayIndex];
        const dayValue = parseInt(day.querySelector("p").innerText.replace("+", ""), 10) || 0;
        const animatedCoin = day.querySelector("#coin");
        const staticCoin = day.querySelector("img:not(#coin):not(#coin2)");
        const replacementCoin = day.querySelector("#coin2");
        const pointsDiv = day.querySelector(".points-div");

        const coinRect = staticCoin.getBoundingClientRect();
        const bonusRect = bonusContainer.getBoundingClientRect();

        animatedCoin.style.position = "fixed";
        animatedCoin.style.left = `${coinRect.left}px`;
        animatedCoin.style.top = `${coinRect.top}px`;
        animatedCoin.style.zIndex = "999";
        animatedCoin.style.opacity = "1";
        animatedCoin.style.pointerEvents = "none";
        animatedCoin.style.transition = "transform 1s ease-in-out, opacity 0.5s ease-in-out";

        const deltaX = bonusRect.left - coinRect.left + bonusRect.width / 2 - animatedCoin.width / 2;
        const deltaY = bonusRect.top - coinRect.top + bonusRect.height / 2 - animatedCoin.height / 2;

        setTimeout(() => {
            animatedCoin.style.transform = `translate(${deltaX}px, ${deltaY}px) rotate(1080deg)`;
        }, 50);

        setTimeout(() => {
            bonusTotal += dayValue;
            bonusValue.innerText = bonusTotal;
            animatedCoin.style.opacity = "0";
            staticCoin.style.opacity = "0";
            replacementCoin.style.opacity = "1";
            pointsDiv.style.background = "linear-gradient(131deg, #FFBE00 3.18%, #FF55FD 53.67%, #7FBBFF 98.69%)";
            pointsDiv.classList.add("claimed");

            // Save progress
            currentDayIndex++;
            localStorage.setItem("claimedDayIndex", currentDayIndex);
            localStorage.setItem("bonus-value", bonusTotal);
            localStorage.setItem("lastClaimTimestamp", Date.now());

            // Disable button
            claimButton.disabled = true;
            claimButton.innerText = "Come Back Tomorrow";
        }, 1000);
    });
});

</script>


      
  </body>
</html>