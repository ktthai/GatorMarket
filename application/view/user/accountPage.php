<div class="container">
    <div class="center_box">
    <h2>User Profile</h2>
    <?php 
        echo '<h3>' . $_SESSION['user']->getName() . '</h3>';
	echo '<div class="gray_box">';
	echo '<h3>' . 'User ID: ' . $_SESSION['user']->getID() . '</h3>';
	echo '<h3>' . 'Email: ' . $_SESSION['user']->getEmail() . '</h3>';
	echo '</div>';
    ?> 
    </div>
</div>

