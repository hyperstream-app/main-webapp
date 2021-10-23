<?php
require 'assets/includes/functions.php';
isAuthenticated();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Item Barcode</title>
    <link rel="stylesheet" href="assets/css/barcode.css">
</head>

<body>
    <div class="wrapper">
        <section id="container" class="container">
            <h2 style="text-align: center;">Scan item barcode</h2>
            <div class="controls">
                <fieldset class="input-group">
                    <center><b>Settings</b></center>
                </fieldset>
                <fieldset class="reader-config-group">
                    <label>
                        <span>Permission</span>
                        <select name="decoder_readers">
                            <option selected="selected" disabled>Options</option>
                            <option value="ean">Scan Barcode</option>
                        </select>
                    </label>
                    <label style="display: none;">
                        <span>Resolution (long side)</span>
                        <select name="input-stream_constraints">
                            <option value="320x240">320px</option>
                            <option selected="selected" value="640x480">640px</option>
                            <option value="800x600">800px</option>
                            <option value="1280x720">1280px</option>
                            <option value="1600x960">1600px</option>
                            <option value="1920x1080">1920px</option>
                        </select>
                    </label>
                    <label style="display: none;">
                        <span>Patch-Size</span>
                        <select name="locator_patch-size">
                            <option value="x-small">x-small</option>
                            <option value="small">small</option>
                            <option selected="selected" value="medium">medium</option>
                            <option value="large">large</option>
                            <option value="x-large">x-large</option>
                        </select>
                    </label>
                    <label style="display: none;">
                        <span>Half-Sample</span>
                        <input type="checkbox" checked="checked" name="locator_half-sample" />
                    </label>
                    <label style="display: none;">
                        <span>Workers</span>
                        <select name="numOfWorkers">
                            <option value="0">0</option>
                            <option selected="selected" value="1">1</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="8">8</option>
                        </select>
                    </label>
                    <label><br><br>
                        <span>Camera</span>
                        <select name="input-stream_constraints" id="deviceSelection">
                        </select>
                    </label>
                    <label style="display: none">
                        <span>Zoom</span>
                        <select name="settings_zoom"></select>
                    </label>
                    <label style="display: none">
                        <span>Torch</span>
                        <input type="checkbox" name="settings_torch" />
                    </label>
                </fieldset>
            </div>
            <div id="result_strip">
                <ul class="thumbnails"></ul>
            </div>
            <div id="interactive" class="viewport" style="width: 100%;"></div>
        </section>

        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/webrtc-adapter.js"></script>
        <script type=" text/javascript" src="assets/js/quagga.min.js">
        </script>
        <script type="text/javascript" src="assets/js/barcode-scanner.js">
        </script>

    </div>
</body>

</html>