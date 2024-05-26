<?php

include('config.php');

   
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}



$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

$query = "SELECT m.code, m.name, m.description, em.id 
          FROM enrolled_modules em
          JOIN modules m ON em.module_id = m.id
          WHERE em.student_id = (SELECT id FROM users WHERE username = '$username')";
$result = $conn->query($query);
$enrolledModules = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Portal</title>
    <link rel="stylesheet" type="text/css" href="home.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#" data-target="home-section">Home</a></li>
                <li><a href="#" data-target="module-section">Modules</a></li>
                <li><a href="#" data-target="profile-section">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home-section">
            
            <div class="hero-section">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8ZWR1Y2F0aW9ufGVufDB8fDB8fHww" alt="Hero Image" class="hero-image">
                <div class="hero-text">
                    <h3>Explore Your Campus</h3>
                    <p>Discover events, news, and more!</p>
                </div>
            </div>
           
        </section>

        <section id="profile-section" class="hidden-section">
            <h3>My Profile</h3>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Campus: <?php echo $user['campus']; ?></p>
            <a href="edit_profile.php">Edit Profile</a>
        </section>

        <section id="module-section" class="hidden-section">
            <h3>My Modules</h3>
            <table>
                <thead>
                    <tr>
                        <th>Module Code</th>
                        <th>Module Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrolledModules as $module) { ?>
                        <tr>
                            <td><?php echo $module['code']; ?></td>
                            <td><?php echo $module['name']; ?></td>
                            <td>
    <a href="#" class="view-link" data-module-id="<?php echo $module['id']; ?>">View</a>
    <a href="#" class="deregister-link" data-module-id="<?php echo $module['id']; ?>" onclick="return confirm('Are you sure you want to deregister from this module?');">Deregister</a>
</td>

                        </tr>
                        <tr id="module-details-<?php echo $module['id']; ?>" class="module-details" style="display: none;">
                            <td colspan="3">
                                <p>Module Description: <?php echo $module['description']; ?></p>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="add_module.php">Add Module</a>
        </section>
    </main>

    <footer>
        &copy; 2024 Student Portal
    </footer>

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('nav ul li a');
    const sections = document.querySelectorAll('main section');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('data-target');

            sections.forEach(section => {
                if (section.id === targetId) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    });
});

    </script>

        <script>
    // JavaScript to handle deregister link clicks
    document.addEventListener("DOMContentLoaded", function() {
        var deregisterLinks = document.querySelectorAll('.deregister-link');
        deregisterLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var moduleId = link.getAttribute('data-module-id');
                if (confirm('Are you sure you want to deregister from this module?')) {
                    window.location.href = 'deregister_module.php?id=' + moduleId;
                }
            });
        });
    });
</script>

</body>
</html>
