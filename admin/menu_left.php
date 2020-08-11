<ul class="nav">
    <li <?php if ($p == "home.php") { ?> class="active" <?php } ?>>
        <a href="index.php">
            <i class="pe-7s-graph"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li <?php if ($p == "setting.php") { ?> class="active" <?php } ?>>
        <a href="index.php?p=setting">
            <i class="fa fa-cog" style="color:#fff;"></i>
            <p> Settings</p>
        </a>
    </li>
</ul>