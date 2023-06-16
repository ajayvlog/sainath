<div class="headerpanel">
    <a href="#" class="showmenu" id="menues"></a>

    <div class="headerright">
        <div class="dropdown notification">
            <div style="float:left;">
                <span style="color:#FFF;">
                    &nbsp;&nbsp;<button class="btn btn-default" onclick="changecompany()"> Change </button> &nbsp;&nbsp;
                </span>
            </div>

            <a class="dropdown-toggle" data-target="#">SAINATH</a>

            <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="http://themetrace.com/page.html">
                <span class="iconsweets-globe iconsweets-white"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="nav-header"><img src="../img/ts.png" width="250" /></li>
                <li>
                    <a href="#">
                        <strong>For any technical queries related to <br /> your Trinity product, please contact us<br />

                            Call:<br />
                            +91-9770131555<br />
                            +91-9575997890<br />
                            <br />
                            Email:<br />
                            admin@trinitysolutions.pw<br />
                            info@trinitysolutions.pw

                        </strong><br />

                    </a>
                </li>

                <li class="viewmore"><a href="http://trinitysolutions.in/" target="">www.trinitysolutions.in</a></li>
            </ul>
        </div>
        <!--dropdown-->


        <div class="dropdown userinfo">

            <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="">Hi,<?php echo $obj->getvalfield("user", "username", "userid = '$loginid'"); ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">

                <li><a href="logout.php"><span class="icon-off"></span> Sign Out</a></li>
            </ul>
        </div>
        <!--dropdown-->

    </div>
    <!--headerright-->

</div>
<!--headerpanel-->
<div class="breadcrumbwidget">
    <ul class="skins">

        <li class="fixed"><a href="#" class="skin-layout fixed"></a></li>
        <li class="wide"><a href="#" class="skin-layout wide"></a></li>
    </ul>
    <!--skins-->
    <ul class="breadcrumb">
        <li><a href="">Home</a> <span class="divider">/</span></li>
        <li class="active"><?php echo $module; ?></li>
    </ul>
</div>
<!--breadcrumbwidget-->
<div class="pagetitle">
    <h1 style="width:100%;">
        <div style="float:left; width:50%;"> <?php echo $submodule; ?> </div>
        <?php
        if ($pagename == "purchaseentry.php") {
        ?>
            <div style="float:right; width:50%; text-align:right;"> Total Purchase : <a id="tot_purchase"> </a> &nbsp; </div>
        <?php } ?>

        <?php
        if ($pagename == "saleentry.php") {
        ?>
            <div style="float:right; width:50%; text-align:right;"> Total Sale : <a id="tot_sale"> </a> &nbsp; </div>
        <?php } ?>
    </h1>
</div>
<!--pagetitle-->


<!-- Modal -->