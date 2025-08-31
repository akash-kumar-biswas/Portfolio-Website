<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akash Biswas | Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div id="home">
        <div id="name-top-left">Akash Biswas</div>
        <div class="container">
            <nav>
            <i class="fa-solid fa-bars" id="menu-icon"></i>
            
            <ul id="navLinks">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#education">Education</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
                <i class="fa-solid fa-xmark" id="close-icon"></i>
            </ul>
            </nav>

            <div class="header-content">
                <div class="header-img">
                    <img src="Images/background_img.jpg" alt="Akash">
                </div>
                <div class="header-text">
                    <h1>Hi, I'm <span>A</span>kash Biswas</h1>
                    <p>I'm a 3rd-year Computer Science & Engineering (CSE) student at 
                    KUET with a deep passion for software development, web development and problem-solving.</p>
                </div>
            </div>
        </div>   
    </div>
    
    <!---------about---------->
    <div id="about">
        <div class="container">
            <div class="row">
                <div class="about-col-1">
                    <img src="Images/user.jpg">
                </div>
                <div class="about-col-2">
                    <h1 class="sub-title-about">About Me</h1>
                    <p class="about-description">I’m Akash Biswas, currently studying in Computer Science & Engineering (CSE) at Khulna University of Engineering & Technology (KUET). My journey in tech started with curiosity and grew into a deep passion for solving real world problems through logical thinking and creative solutions. I enjoy learning, building, and constantly improving and not just in programming, but as a person. While I love the challenge of development, I equally value communication, teamwork, and self-growth. Outside of coding, I enjoy watching movies, playing cricket, and exploring new places. I believe in staying consistent, being curious, and always moving forward-one step, one project, one experience at a time.</p>

                </div>
            </div>
        </div>
    </div>

    <!-- ---------education---------- -->
<div id="education">
    <div class="container">
        <div class="education-wrapper">
            <div class="education-list">
                <h1 class="sub-title">Education</h1>
                <div class="education-grid">
                    <div class="education-item">
                        <h3>Khulna University of Engineering and Technology (KUET)</h3>
                        <p><strong>B.Sc in Computer Science & Engineering (CSE)</strong></p>
                        <p>Jan 2023 - Jan 2027 | CGPA: 3.50 (from the 1st 4 semesters)</p>
                    </div>
                    <div class="education-item">
                        <h3>Govt. K.C. College, Jhenidah</h3>
                        <p><strong>Higher Secondary Certificate (HSC), Science</strong></p>
                        <p>2019 - 2021 | GPA: 5.00 (Out of 5.00)</p>
                    </div>
                    <div class="education-item">
                        <h3>Munuria M.L. School & College</h3>
                        <p><strong>Secondary School Certificate (SSC), Science</strong></p>
                        <p>2017 - 2019 | GPA: 5.00 (Out of 5.00)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once "config.php"; 

// Single DB connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if ($mysqli->connect_error) {
    die("DB error: " . $mysqli->connect_error);
}

// Escape function
function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Fetch categories for skills
$categories = $mysqli->query("SELECT DISTINCT category FROM skills ORDER BY category");

// Fetch projects
$projects = $mysqli->query("SELECT * FROM projects ORDER BY created_at DESC");
?>

<!-- ---------skills---------- -->
<div id="skills">
  <div class="container">
    <h1 class="sub-title">My Skills</h1>

    <div class="skills-grid">
      <?php while($cat = $categories->fetch_assoc()): ?>
        <div class="skill-box">
          <h3><?php echo e($cat['category']); ?></h3>
          <ul>
            <?php
            $skills = $mysqli->query(
              "SELECT name FROM skills WHERE category='" . $mysqli->real_escape_string($cat['category']) . "' ORDER BY name"
            );
            while($s = $skills->fetch_assoc()):
            ?>
              <li><?php echo e($s['name']); ?></li>
            <?php endwhile; ?>
          </ul>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<!-- ---------projects---------- -->
<div id="projects">
  <div class="container">
    <h1 class="sub-title">Projects</h1>
    <div class="projects-grid">

      <?php while($p = $projects->fetch_assoc()): ?>
        <div class="project-card">
          <img src="Images/<?php echo e($p['image_file']); ?>" alt="<?php echo e($p['title']); ?> Preview" class="project-img">
          <h3><?php echo e($p['title']); ?></h3>
          <p><?php echo e($p['description']); ?></p>
          <p><strong>Technologies:</strong> <?php echo e($p['technologies']); ?></p>
          <?php if(!empty($p['github_link'])): ?>
            <p><strong>GitHub:</strong>
              <a class="repo-link" href="<?php echo e($p['github_link']); ?>" target="_blank">View Repository</a>
            </p>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>

    </div>
  </div>
</div>

<!-- ---------Contact---------- -->
<div id="contact">
    <div class="container">
        <div class="row">
            <div class="contact-left">
                <h1 class="sub-title_contact">Contact Me</h1>
                <p><i class="fa-solid fa-paper-plane"></i>akash.biswas.cse@gmail.com</p>
                <p><i class="fa-solid fa-phone-volume"></i>+880 1722197936</p>
                <p><i class="fa-solid fa-location-pin"></i>Khulna, Bangladesh</p>
                <div class="social-icons">
                    <a href="https://www.linkedin.com/in/akash-biswas-84b824266/" title="Go to My Linkedin Profile"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="https://github.com/akash-kumar-biswas" title="Go to My Github Profile"><i class="fa-brands fa-github"></i></a>
                    <a href="https://www.facebook.com/akash.kumar.biswas.686916" title="Go to My Facebook Profile"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/akash.kumar.57?igsh=OG1pNThmeWl3MHF0" title="Go to My Instagram Profile"><i class="fa-brands fa-instagram"></i></a>
                </div>
                <a href="Images/My_CV.pdf" download class="btn"> Download CV </a>
            </div> 
            <div class="contact-right">
                <form name="submit-to-google-sheet" class="contact-form">
                    <input type="text" name="Name" placeholder="Your Name" required>
                    <input type="email" name="Email" placeholder="Your Email" required>
                    <textarea rows="5" name="Message" placeholder="Your Message" required></textarea>
                    
                    <button type="submit" class="btn2">Send Message</button>
                    
                    <!-- Move these inside the form, right after the button -->
                    <span class="form-message" style="display: none;">
                        <i class="fa-solid fa-check"></i>
                        Message sent successfully!
                    </span>
                    <span class="form-error" style="display: none;">
                        <i class="fa-solid fa-xmark"></i>
                        Error sending message. Please try again.
                    </span>
                </form> 
            </div>
        </div>
    </div>
</div>
<script src="script1.js"></script> 
<script src="script2.js"></script>
<script src="admin/switch-to-admin.js"></script>
</body>
</html>
