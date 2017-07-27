<!DOCTYPE html>
<html>
    <head>
        <title>tMorph Macros</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel = "stylesheet" type = "text/css" href = "css/styles.css">
    </head>
    <body>
    <div class="container">
        <h1>Legion tMorph Macro Creator</h1>
        <hr>
        <p>This website allows users a quick and easy way to create a tMorph macro for a characters armory. To create your macro, simply paste in the armory URL you wish to use below.</p>
        <p style = "color:red;">Note: If the macro fails to load, check your format, realm and character name and try again.</p>
        <div class="row">
            <div class="col-md-12">
                <h2>Paste Armory URL  <span>(Format: https://worldofwarcraft.com/en-gb/character/realm/character)</span></h2>
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control input-lg" id = "url" placeholder="URL Here" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button" onclick = "createMacro()">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div class = "row">
            <div id = "main">
                <h3 id = "char-info">Showing results for Zelax-Sylvanas (Frost Mage)</h3>
                <br>
                <div id = "macro">

                </div>
                <button class="clipboard" data-clipboard-target="#macro">
                        Copy to clipboard
                </button>
            </div>
        </div>
        <div id = "footer">
            &copy; Luke Taylor 2017
        </div>
    </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src = "js/clipboard.min.js"></script>
        <script type = "text/javascript">

            $(document).ready(function(){
                new Clipboard('.clipboard');
            });

            var inventorySlotIDs = [];
            inventorySlotIDs['back'] = 15;
            inventorySlotIDs['chest'] = 5;
            inventorySlotIDs['feet'] = 8;
            inventorySlotIDs['finger1'] = 11;
            inventorySlotIDs['finger2'] = 12;
            inventorySlotIDs['hands'] = 10;
            inventorySlotIDs['head'] = 1;
            inventorySlotIDs['legs'] = 7;
            inventorySlotIDs['mainHand'] = 16;
            inventorySlotIDs['neck'] = 2;
            inventorySlotIDs['shirt'] = 4;
            inventorySlotIDs['shoulder'] = 3;
            inventorySlotIDs['tabard'] = 19;
            inventorySlotIDs['waist'] = 6;
            inventorySlotIDs['wrist'] = 9;

            function createMacro(){

                $("#macro").empty();
                $("#char-info").empty();

                var url = $("#url").val();
                // example armory link https://worldofwarcraft.com/en-gb/character/sylvanas/zelax
                // example api call https://eu.api.battle.net/wow/character/Sylvanas/Zelax?fields=items&locale=en_GB&apikey=uq9sd8xpaeesyhbm6cx9mve2qn54436e
                var arr = url.split('/');
                var region = arr[3];
                var server = arr[5];
                var character = arr[6];

                if (region == "en-us"){
                    var api_url = "https://us.api.battle.net/wow/character/" + server + "/" + character + "?fields=items&locale=en_US&apikey=uq9sd8xpaeesyhbm6cx9mve2qn54436e";
                }else{
                    var api_url = "https://eu.api.battle.net/wow/character/" + server + "/" + character + "?fields=items&locale=en_GB&apikey=uq9sd8xpaeesyhbm6cx9mve2qn54436e";
                }
                $.get(api_url, function(data){
                    /*Display character info*/
                    $("#char-info").append("Showing results for " + data.name + "-" + data.realm);

                  /*  /!*Add the race and gender to the macro*!/
                    $("#macro").append("<p>.gender " + data.gender + "</p>");
                    $("#macro").append("<p>.race " + data.race + "</p>");*/

                    /*Loop through each gear piece equipped and add to macro*/
                    $.each(data.items, function(index, item){
                        /*Check if the item is an actual gear piece*/
                        if (index != "averageItemLevel" && index != "averageItemLevelEquipped"){
                            /*Check the item is a piece which can have an appearance (not a trinket)*/
                            if (inventorySlotIDs[index] != null){
                                /*Check the item is transmogged by the user*/
                                if (item.appearance.itemId != null){
                                    $("#macro").append("<p>.item " + inventorySlotIDs[index] + " " + item.appearance.itemId + "</p>");
                                }else{
                                    $("#macro").append("<p>.item " + inventorySlotIDs[index] + " " + item.id + "</p>");
                                }

                                if (inventorySlotIDs[index] == null){
                                    console.log(item);
                                }
                            }
                        }
                    });
                });

                $("#main").show();

            }

            document.querySelector('#url').addEventListener('keypress', function (e) {
                var key = e.which || e.keyCode;
                if (key === 13) { // 13 is enter
                    createMacro();
                }
            });
        </script>
    </body>
</html>
