<?php 
    $backtrace = debug_backtrace();
    $parentFile = $backtrace[0]['file'] ?? null;
    $filename = basename($parentFile);

    if($filename == 'home.php') {
        $title = 'Home';
    } else if($filename =='profile.php') {
        $title = 'Your Profile';
    } else if($filename =='user_div.php') {
        $title = 'Dividends History';
    } else {
        $title = 'Shares History';
    }
?>

<nav>
    <i class="bx bx-menu"></i>
    <h4 style="color: var(--green);"><?php echo $title; ?></h4>
    <a href="#" class="profile"><img src="../<?php echo $profile_image ?>" alt="Profile" /></a>
</nav>