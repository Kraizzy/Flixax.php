// assets/js/authUI.js
import { auth, provider, signInWithPopup, signOut, onAuthStateChanged } from './firebase.js';

export function setupAuthUI(options = {}) {
  const {
    avatar,
    initial,
    defaultIcon,
    loginBtn,
    logoutBtn,
    userNameEl,
    userIdEl,
    userPhotoEl
  } = options;

  function getUserInitials(displayName, email) {
    if (displayName && displayName.trim()) {
      const names = displayName.trim().split(" ");
      return (names[0][0] + names[names.length - 1][0]).toUpperCase();
    } else if (email) {
      return email[0].toUpperCase();
    }
    return "U";
  }

  function shortenUid(uid) {
    return uid ? uid.substring(0, 6) + "..." : "unknown";
  }

  function updateUI(user) {
    // Avatar Image (with fallback logic)
    if (avatar && user.photoURL) {
      const img = new Image();
      img.onload = () => {
        avatar.src = img.src;
        avatar.style.display = "block";
        if (initial) initial.style.display = "none";
        if (defaultIcon) defaultIcon.style.display = "none";
      };
      img.onerror = () => {
        avatar.style.display = "none";
        if (initial) {
          initial.textContent = getUserInitials(user.displayName, user.email);
          initial.style.display = "flex";
        }
        if (defaultIcon) defaultIcon.style.display = "none";
      };
      img.src = user.photoURL;
    } else if (initial) {
      initial.textContent = getUserInitials(user.displayName, user.email);
      initial.style.display = "flex";
      if (avatar) avatar.style.display = "none";
      if (defaultIcon) defaultIcon.style.display = "none";
    }

    // Login/logout button text
    if (loginBtn) loginBtn.textContent = "Logout";
    if (logoutBtn) logoutBtn.style.display = "block";

    // User info section
    if (userNameEl) userNameEl.textContent = `Welcome ${user.displayName || "User"}`;
    if (userIdEl) userIdEl.textContent = `ID ${shortenUid(user.uid)}`;
    if (userPhotoEl) {
      userPhotoEl.onerror = () => {
        userPhotoEl.src = "assets/avatar-default-svgrepo-com.svg";
      };
      userPhotoEl.src = user.photoURL || "assets/avatar-default-svgrepo-com.svg";
    }
  }

  function resetUI() {
    if (avatar) avatar.style.display = "none";
    if (initial) initial.style.display = "none";
    if (defaultIcon) defaultIcon.style.display = "block";

    if (loginBtn) loginBtn.textContent = "Login";
    if (logoutBtn) logoutBtn.style.display = "none";

    if (userNameEl) userNameEl.textContent = "Welcome Guest";
    if (userIdEl) userIdEl.textContent = "ID --";
    if (userPhotoEl) userPhotoEl.src = "assets/avatar-default-svgrepo-com.svg";
  }

  // Watch auth state once per page
  onAuthStateChanged(auth, (user) => {
    if (user) {
      updateUI(user);
    } else {
      resetUI();
    }
  });

  // Toggle login/logout
  if (loginBtn) {
    loginBtn.addEventListener("click", async () => {
      const user = auth.currentUser;
      if (user) {
        await signOut(auth);
      } else {
        try {
          await signInWithPopup(auth, provider);
        } catch (e) {
          console.error("Login error", e);
        }
      }
    });
  }

  if (logoutBtn) {
    logoutBtn.addEventListener("click", async () => {
      try {
        await signOut(auth);
      } catch (e) {
        console.error("Logout error", e);
      }
    });
  }
}
