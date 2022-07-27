<?php

    require './fnc.php';
    if(file_exists("./config.ini")) {
        $conf = parse_ini_file("config.ini");
        echo('<html style="background-color:'.$conf["bgcolor"].';">');
        $romdirectory = $conf["rom_dir"];
        if(is_dir($romdirectory)) {
            $gamedata = buildRomList($romdirectory);
        } else {
            mkdir($romdirectory);
            $gamedata = buildRomList($romdirectory);
        }
        echo("\r\n<div style='width:". 640*$conf["scale"] ."px;height:". 480*$conf["scale"] ."px;max-width:100%;margin:auto auto;'>");
    } else {
        echo('<html style="background-color:#333333;">');
        $romdirectory = './roms/';
        $gamedata = buildRomList($romdirectory);
        echo("\r\n<div style='width:640px;height:480px;max-width:100%;margin:auto auto;'>");
    }
    $romlist = scandir($romdirectory);
    for($i=0; $i<count($romlist)-2; $i++) {
        $romlistfin[$i] = $romlist[$i + 2];
    }

    
    
?>


    <div id='game'></div>
</div>

<script type='text/javascript'>
    <?php if (isset($_GET['games'])) {
            $gid = $_GET['games'];
        } else {
            $gid = 0;
        }
    ?>
    EJS_player = '#game';
    EJS_core = <?php echo("'".$gamedata[$gid]["Console"]."'"); ?>;
    EJS_gameUrl = <?php echo('"./roms/'.$romlistfin[$gid].'"'); ?>;
    <?php if($gamedata[$gid]["Console"] == "psx") {
        echo("EJS_biosUrl = './bios/psx.bin';\r\n");
    }
    ?>
    <?php if($conf["netplay"] == "true") {
        echo("EJS_gameID = ".$gid.";\r\n");    
    }
    if($conf["beta"] == "true") {
        echo("EJS_BETA = true; \r\n");
    }
    ?>
    EJS_pathtodata = 'data/';
    
</script>

<script src='data/loader.js'></script>