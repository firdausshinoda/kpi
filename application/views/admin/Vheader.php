<html>
<header class="main-header">
    <a href="javascript:avoid();" class="logo">
        <span class="logo-mini"><b>KP</b></span>
        <span class="logo-lg"><b>Admin SIKePik</b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if (!empty($s_foto)): ?>
                            <img src="<?php echo base_url('assets/document/img/admin/'.$s_foto); ?>" class="user-image" alt="User Image">
                        <?php else: ?>
                            <img src="<?php echo base_url('assets/document/img/style/profile.jpg'); ?>" class="user-image" alt="User Image">
                        <?php endif; ?>
                        <span class="hidden-xs"><?php echo $s_nama; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?php echo base_url('assets/document/img/admin/'.$s_foto); ?>" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $s_nama." - ".$s_niy; ?>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url('Admin/Profil');?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url('Admin/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
</html>
