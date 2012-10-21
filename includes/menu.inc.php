<!--top navigation for all pages-->
<?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
<ul id="navbar">
    <li class="nav"><a href="index.php" <?php if ($currentPage == 'index.php'){echo 'class="current"';} ?>>Main</a></li> 
    <li class="nav"><a href="poster_gallery"<?php if ($currentPage == 'poster_gallery.php'){echo 'class="current"';} ?>>Gallery</a></li>
    <li class="nav"><a href="#"<?php if ($currentPage == 'links.php'){echo 'id="current"';} ?>>Processes</a>
        <div class="dropdown">
        <ul>
            <li class="secondary"><a href="thumbnailer.php">Thumbnailer</a></li> 
            <li class="secondary"><a href="posterize.php">Posterizer</a></li>
            <li class="secondary"><a href="halftone.php">Halftoner</a></li>
            <li class="secondary"><a href="interlace.php">Interlacer</a></li>
            <li class="secondary"><a href="duotone.php">Duotoner</a></li>
            <li class="secondary"><a href="random.php">Randomizer</a></li>
            <li class="secondary"><a href="mouseclick.php">Mouse Picture</a></li>
        </ul>
        </div>
</ul>