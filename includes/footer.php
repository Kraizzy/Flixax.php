<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
</head>
<style>
    
/* Footer Styling  */


/* Footer container */
.footer {
  background-color: #212121;
  color: #FFFFFF;
  height: 539px;
  width: 100%;
  margin: 0 auto;
  font-family: sans-serif;
  margin-top: 5rem;
}

/* Main footer content using CSS Grid */
.footer-content {
  display: grid;
  gap: 15px;
  margin: 0 auto;
  margin-bottom: 60px;
  grid-template-columns: repeat(5, 1fr); /* Five equal columns */
  align-items: start; /* Align items to the top */
  /* max-width: 90rem; */
  height: 250px;
  width: 91%;
  padding: 60px 10px;
}

/* Logo and social media section */
.logo-social {
  display: flex;
  flex-direction: column;
  align-items: left; /* Center logo and social icons */
}

.logo-social img {
  width: 8rem; /* Adjust as needed */
  height: 2reme;
}

.social-icons {
  display: flex;
  gap: 15px;
  margin-top: 10px;
}

.social-icons a {
  color: #FFFFFF;
  font-size: 1.2em;
  text-decoration: none;
}

/* Catalog, Services, About sections */
.catalog, .services, .about {
  text-align: left; 
}

.catalog h3, .services h3, .about h3 {
  font-weight: 500;
  margin-bottom: 30px;
  font-family: "Inter", sans-serif;
  margin-top: 0;
  font-size: 14px;
}

.catalog ul, .services ul, .about ul {
  list-style: none;
  padding: 0;
}

.catalog li, .services li, .about li {
  margin-bottom: 8px;
}

.catalog a, .services a, .about a {
  color: #fff;
  font-size: 16px;
  font-family: "Inter", sans-serif;
  font-weight: 400;
  font-style: normal;
  line-height: 140%;
  text-decoration: none;
}

/* Call-to-action button section */
.cta-button {
  display: flex;
  justify-content: right; /* Center the button horizontally */
  
}

.cta-button button {
  background-color: #FF69B4;
  color: #FFFFFF;
  font-family: "Inter", sans-serif;
  font-size: 14px;
  border: none;
  font-style: normal;
  font-weight: 500;
  line-height: 140%;
  padding: 10px 20px;
  border-radius: 20px;
  cursor: pointer;
}

/* Bottom footer section using Flexbox */
.footer-bottom {
  margin-top: 60px;
  display: flex;
  margin: 0 auto;
  padding: 0 2.5rem;
  font-family: "Inter", sans-serif;
  justify-content: space-between; /* Space between contact and copyright */
  align-items: center;
  /* max-width: 1440px; */
  width: 91%;
  font-size: 0.8em;
  color: #CCCCCC;
}

.footer-icon{
  width: 115px;
  display: flex;
  gap: 10px;
}
.footer-icon-con{
  display: flex;
  gap: 9.625rem;
}
.div-icons{
  display: flex;
  border: 2px solid white;
  margin: 0 auto;
  border-radius: 50%;
  height: 50px;
  width: 50px;
}
.div-icons svg {
  padding: 1rem;
  height: 16px;
  width: 16px;
  display: flex;
  margin: 0 auto;
}
.contact p {
  margin: 5px 0;
  color: #fff;
  font-family: "Inter", sans-serif;
  font-size: 14.14px;
  font-style: normal;
  font-weight: 400;
  line-height: 140%;
  opacity: 0.75;
}
.copyright{
  text-align: right;
  height: 2.25rem;
  width: 9rem;
  color: #FFFFFF;
  font-family: Inter;
  font-size: 0.75rem;
  font-style: normal;
  font-weight: 400;
  line-height: 140%;
  opacity: 0.25;
}

</style>
<body>
    
      <!-- Footer Section  -->
    </div>
    <footer class="footer">
      <!-- Main footer content -->
      <div class="footer-content">
        <!-- Logo and Social Media -->
        <div class="logo-social">
          <img onclick="window.location='<?= $baseUrl ?>/home'" src="assets/Artboard 2@3x.svg" alt="logo">
          <div class="social-icons"></div>
        </div>

        <!-- Catalog -->
        <div class="catalog">
          <h3>Catalog</h3>
          <ul>
            <li><a href="#">ESWT</a></li>
            <li><a href="#">HILT</a></li>
            <li><a href="#">Skin IQ</a></li>
            <li><a href="#">Rehab Simulators</a></li>
            <li><a href="#">EECP</a></li>
          </ul>
        </div>

        <!-- Services -->
        <div class="services">
          <h3>Services</h3>
          <ul>
            <li><a href="#">Leasing</a></li>
            <li><a href="#">Consultation</a></li>
          </ul>
        </div>

        <!-- About -->
        <div class="about">
          <h3>About</h3>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">News</a></li>
            <li><a href="#">Partners</a></li>
          </ul>
        </div>

        <!-- Call-to-Action Button -->
        <div class="cta-button">
          <button onclick="window.location.href='https:/www.google.com'">
            Get In Touch
          </button>
        </div>
      </div>
      <!-- Bottom section -->
      <div class="footer-bottom">
        <div class="footer-icon-con">
          <div class="footer-icon">
            <div class="div-icons">
              <a href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M14 0H2C0.897 0 0 0.897 0 2V14C0 15.103 0.897 16 2 16H8V10.5H6V8H8V6C8 5.20435 8.31607 4.44129 8.87868 3.87868C9.44129 3.31607 10.2044 3 11 3H13V5.5H12C11.448 5.5 11 5.448 11 6V8H13.5L12.5 10.5H11V16H14C15.103 16 16 15.103 16 14V2C16 0.897 15.103 0 14 0Z"
                    fill="white"
                  />
                </svg>
              </a>
            </div>
            <div class="div-icons">
              <a href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  viewBox="0 0 16 16"
                  fill="none"
                >
                  <path
                    d="M8 1.44578C10.1205 1.44578 10.4096 1.44578 11.2771 1.44578C12.0482 1.44578 12.4337 1.63855 12.7229 1.73494C13.1084 1.92771 13.3976 2.0241 13.6867 2.31325C13.9759 2.60241 14.1687 2.89157 14.2651 3.27711C14.3614 3.56627 14.4578 3.95181 14.5542 4.72289C14.5542 5.59036 14.5542 5.78313 14.5542 8C14.5542 10.2169 14.5542 10.4096 14.5542 11.2771C14.5542 12.0482 14.3614 12.4337 14.2651 12.7229C14.0723 13.1084 13.9759 13.3976 13.6867 13.6867C13.3976 13.9759 13.1084 14.1687 12.7229 14.2651C12.4337 14.3614 12.0482 14.4578 11.2771 14.5542C10.4096 14.5542 10.2169 14.5542 8 14.5542C5.78313 14.5542 5.59036 14.5542 4.72289 14.5542C3.95181 14.5542 3.56627 14.3614 3.27711 14.2651C2.89157 14.0723 2.60241 13.9759 2.31325 13.6867C2.0241 13.3976 1.83133 13.1084 1.73494 12.7229C1.63855 12.4337 1.54217 12.0482 1.44578 11.2771C1.44578 10.4096 1.44578 10.2169 1.44578 8C1.44578 5.78313 1.44578 5.59036 1.44578 4.72289C1.44578 3.95181 1.63855 3.56627 1.73494 3.27711C1.92771 2.89157 2.0241 2.60241 2.31325 2.31325C2.60241 2.0241 2.89157 1.83133 3.27711 1.73494C3.56627 1.63855 3.95181 1.54217 4.72289 1.44578C5.59036 1.44578 5.87952 1.44578 8 1.44578ZM8 0C5.78313 0 5.59036 0 4.72289 0C3.85542 0 3.27711 0.192772 2.79518 0.385543C2.31325 0.578314 1.83133 0.867471 1.3494 1.3494C0.867471 1.83133 0.674699 2.21687 0.385543 2.79518C0.192772 3.27711 0.0963856 3.85542 0 4.72289C0 5.59036 0 5.87952 0 8C0 10.2169 0 10.4096 0 11.2771C0 12.1446 0.192772 12.7229 0.385543 13.2048C0.578314 13.6867 0.867471 14.1687 1.3494 14.6506C1.83133 15.1325 2.21687 15.3253 2.79518 15.6145C3.27711 15.8072 3.85542 15.9036 4.72289 16C5.59036 16 5.87952 16 8 16C10.1205 16 10.4096 16 11.2771 16C12.1446 16 12.7229 15.8072 13.2048 15.6145C13.6867 15.4217 14.1687 15.1325 14.6506 14.6506C15.1325 14.1687 15.3253 13.7831 15.6145 13.2048C15.8072 12.7229 15.9036 12.1446 16 11.2771C16 10.4096 16 10.1205 16 8C16 5.87952 16 5.59036 16 4.72289C16 3.85542 15.8072 3.27711 15.6145 2.79518C15.4217 2.31325 15.1325 1.83133 14.6506 1.3494C14.1687 0.867471 13.7831 0.674699 13.2048 0.385543C12.7229 0.192772 12.1446 0.0963856 11.2771 0C10.4096 0 10.2169 0 8 0Z"
                    fill="white"
                  />
                  <path
                    d="M8 3.85542C5.68675 3.85542 3.85542 5.68675 3.85542 8C3.85542 10.3133 5.68675 12.1446 8 12.1446C10.3133 12.1446 12.1446 10.3133 12.1446 8C12.1446 5.68675 10.3133 3.85542 8 3.85542ZM8 10.6988C6.55422 10.6988 5.30121 9.54217 5.30121 8C5.30121 6.55422 6.45783 5.30121 8 5.30121C9.44578 5.30121 10.6988 6.45783 10.6988 8C10.6988 9.44578 9.44578 10.6988 8 10.6988Z"
                    fill="white"
                  />
                  <path
                    d="M12.241 4.72289C12.7733 4.72289 13.2048 4.29136 13.2048 3.75904C13.2048 3.22671 12.7733 2.79518 12.241 2.79518C11.7086 2.79518 11.2771 3.22671 11.2771 3.75904C11.2771 4.29136 11.7086 4.72289 12.241 4.72289Z"
                    fill="white"
                  />
                </svg>
              </a>
            </div>
          </div>
          <div class="contact">
            <p>+7 (411) 390-51-11</p>
            <p>info@novation-med.ru</p>
          </div>
        </div>
        <div class="copyright">
          <p>© 2021 - Novation Med All Rights Reserved</p>
        </div>
      </div>
    </footer>
</body>
</html>