<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <title>WCs</title>
    <script type="text/javascript" src="https://api.mapy.cz/loader.js"></script>
    <script type="text/javascript">
        Loader.load(null, {
            suggest: true
        });
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</head>

<body id="advanced-markers">


    <?php

    $wholeCount = 0;
    $row = 1;


    if (($handle = fopen("data.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            if ($num == 4) {
                $wholeCount++;
            }
        }
        fclose($handle);
    }

    ?>



    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">NajdiZachod.cz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse flex-row-reverse" id="mynavbar">
                <form class="d-flex" role="search">
                    <input class="form-control me-2 mt-2 mb-2" type="text" id="searchBar" placeholder="Hledej" aria-label="Search">
                    <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
                </form>
            </div>
        </div>
    </nav>


    <div id="m" class="own_height">
        <div id="bottom_wrapper">
            <div class="container p-2">
                <form action="addZachod.php" method="post">
                    <div>
                        <h6 class="text-light">Přidejte záchod, pokud ještě nebyl oběven.</h6>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <input required type="text" name="jmeno" class="form-control" id="inputName" placeholder="Název">
                        <input type="text" name="cena" class="form-control" id="inputPrice" placeholder="Cena/Kód">
                        <!--
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                Typ
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item">Kč</a></li>
                                <li><a class="dropdown-item">Kód</a></li>
                            </ul>
                        </div>
                        -->
                        <p class="form-control" readonly id="inputCoordinatesDisplay">Souřadnice: (Pohněte bodem na mapě)</p>
                        <input required type="text" name="coords" style="display: none;" class="form-control" id="inputCoordinates" placeholder="Cena">

                        <button type="button" class="btn btn-secondary" onclick="OnCancelRegisterZachod(this)">Zavřít</button>
                        <input type="submit" class="btn btn-primary" value="Uložit záchod">

                    </div>
                </form>

            </div>

        </div>

    </div>

    <div class="container">
        <br>
        <div class="row">

            <h3>Již registrováno
                <?php echo ($wholeCount) ?>
                záchodů!</h3>


            <br>
            <div class="d-flex p-2 align-items-baseline">
                <p>Chybí ti tu záchod? &ensp;</p>
                <button type="button" class="btn btn-outline-primary" onclick="OnRegisterZachod(this)" data-toggle="modal" data-target="#exampleModal">Registrovat nový záchod</button>
            </div>


        </div>




        <div class="table-responsive">
            <br>
            <table id="zachodov" class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Jméno</th>
                        <th scope="col">Zadarmo?</th>
                        <th scope="col">Souřadnice</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    // Výpis WC


                    $row = 1;
                    if (($handle = fopen("data.csv", "r")) !== FALSE) {

                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                            $num = count($data);

                            if ($row == 1) {
                                $string = '';
                            } else {
                                $string = ",";
                            }

                            $row++;

                            // Name, Bool, S,E
                            if ($num == 4) {
                                $string = $string . '"' . $data[0] . '":' . '"' . $data[2] . '\"N,' . $data[3] . '\"E"';

                                $freestatus = "";

                                if ($data[1] == '0') {
                                    $freestatus = 'Zdarma';
                                } else {
                                    $freestatus = $data[1];
                                }



                                echo ('
                                        <tr>
                                            <th>' . $data[0] . '</th>
                                            <td>' . $freestatus . '</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary" onclick="OpenByButton(this)">' . $data[2] . '"N,' . $data[3] . '"E' . '</button>
                                            </td>
                                        </tr>
                                ');
                            }


                            // ','.$data[0].': '.'"'.$data[2].'\"N,'.$data[3].'\"N'
                        }

                        fclose($handle);
                    }


                    ?>
                </tbody>
            </table>

        </div>
    </div>









    <script>
        var obrazek = "drop-redWC.png";

        var m = new SMap(JAK.gel("m"));
        m.addControl(new SMap.Control.Sync()); /* Aby mapa reagovala na změnu velikosti průhledu */
        m.addDefaultLayer(SMap.DEF_BASE).enable(); /* Turistický podklad */
        var mouse = new SMap.Control.Mouse(SMap.MOUSE_PAN | SMap.MOUSE_WHEEL | SMap.MOUSE_ZOOM); /* Ovládání myší */
        m.addControl(mouse);



        // Suggest list search
        // naseptavac
        let inputEl = document.querySelector("#searchBar");
        let suggest = new SMap.Suggest(inputEl, {
            provider: new SMap.SuggestProvider({
                updateParams: params => {
                    /*
                tato fce se vola pred kazdym zavolanim naseptavace,
                params je objekt, staci prepsat/pridat klic a ten se prida
                do url
            */
                    let c = m.getCenter().toWGS84();
                    params.lon = c[0].toFixed(5);
                    params.lat = c[1].toFixed(5);
                    params.zoom = m.getZoom();

                    // nepovolime kategorie, ale takto bychom mohli
                    //params.enableCategories = 1;

                    // priorita jazyku, oddelene carkou
                    params.lang = "cs,en";
                }
            })
        });


        suggest.addListener("suggest", suggestData => {

            // vyber polozky z naseptavace
            setTimeout(function() {
                var res = JSON.stringify(suggestData, null, 4)

                var longtitude = JSON.parse(res).data.longitude;
                var latitude = JSON.parse(res).data.latitude;

                var cord = new SMap.Coords(longtitude, latitude);

                m.setCenterZoom(cord, 15);



            }, 0);

        });


        var data = {

            <?php


            $row = 1;
            if (($handle = fopen("data.csv", "r")) !== FALSE) {

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                    $num = count($data);

                    if ($row == 1) {
                        $string = '';
                    } else {
                        $string = ",";
                    }

                    $row++;

                    // Name, Bool, S,E
                    if ($num == 4) {
                        $string = $string . '"' . $data[0] . '":' . '"' . $data[2] . '\"N,' . $data[3] . '\"E"';
                        echo ($string);
                    }


                    // ','.$data[0].': '.'"'.$data[2].'\"N,'.$data[3].'\"N'
                }

                fclose($handle);
            }

            ?>

        };

        var znacky = [];
        var souradnice = [];

        for (var name in data) {

            /* Vyrobit značky */
            var c = SMap.Coords.fromWGS84(data[name]); /* Souřadnice značky, z textového formátu souřadnic */

            var options = {
                url: obrazek,
                title: name,
                anchor: {
                    left: 10,
                    bottom: 1
                } /* Ukotvení značky za bod uprostřed dole */
            }

            var znacka = new SMap.Marker(c, name, options);
            souradnice.push(c);
            znacky.push(znacka);
        }


        /* Křivoklát ukotvíme za střed značky, přestože neznáme její velikost */
        var options = {
            anchor: {
                left: 0.5,
                top: 0.5
            }
        }

        var vrstva = new SMap.Layer.Marker(); /* Vrstva se značkami */
        m.addLayer(vrstva); /* Přidat ji do mapy */
        vrstva.enable(); /* A povolit */
        for (var i = 0; i < znacky.length; i++) {
            vrstva.addMarker(znacky[i]);
        }

        var cz = m.computeCenterZoom(souradnice); /* Spočítat pozici mapy tak, aby značky byly vidět */
        m.setCenterZoom(cz[0], cz[1]);




        // Button Press!
        function OpenByButton(element) {

            if (isPridavani)
                OnCancelRegisterZachod();

            var btnCords = SMap.Coords.fromWGS84(element.innerText);
            m.setCenterZoom(btnCords, 16);

            document.getElementById("m").scrollIntoView();

        }


        // Markers clicc
        m.getSignals().addListener(this, "marker-click", function(e) {

            if (isPridavani)
                OnCancelRegisterZachod();

            // vybrany marker
            var marker = e.target;
            var id = marker.getId();
            // zobrazime jeho jmeno - parovani vybraneho markeru pomoci jeho id a nasich vstupnich dat

            var tbl = document.getElementById('zachodov');

            for (let row of tbl.rows) {
                for (let cell of row.cells) {
                    let val = cell.innerText; // your code below
                    if (val == id) {
                        cell.scrollIntoView();
                        cell.parentNode.animate([{
                            outline: "#4CAF50 solid 5px"
                        }, {
                            outline: "#4CAF50 solid 0px"
                        }], {
                            duration: 2000,
                            iterations: 1
                        })

                        var btnCords = SMap.Coords.fromWGS84(cell.parentNode.children[2].innerText);
                        m.setCenterZoom(btnCords, 16);

                    }
                }
            }




        });






        // Map stress
        /*
                function click(e, elm) {
                        var coords = SMap.Coords.fromEvent(e.data.event, m);
                        alert("Kliknuto na " + coords.toWGS84(2).reverse().join(" "));
                }
                m.getSignals().addListener(window, "map-click", click); 


        */


        isPridavani = false;

        var tempDropMark;

        function OnRegisterZachod(element) {
            if (isPridavani != false)
                return;

            isPridavani = true
            var registerPanel = document.getElementById("bottom_wrapper");
            registerPanel.style.zIndex = 3;

            registerPanel.style.display = "block";

            tempDropMark = new SMap.Marker(m.getCenter());
            tempDropMark.setURL("drop-blueWC.png");
            console.log(tempDropMark);
            tempDropMark.decorate(SMap.Marker.Feature.Draggable);
            vrstva.addMarker(tempDropMark);

        }

        function OnCancelRegisterZachod(element) {
            if (isPridavani != true)
                return;

            isPridavani = false
            var registerPanel = document.getElementById("bottom_wrapper");
            registerPanel.style.zIndex = 0;
            registerPanel.style.display = "none";

            vrstva.removeMarker(tempDropMark);

        }


        function start(e) {
            /* Začátek tažení */
            var node = e.target.getContainer();
            node[SMap.LAYER_MARKER].style.cursor = "help";
        }

        function stop(e) {
            var node = e.target.getContainer();
            node[SMap.LAYER_MARKER].style.cursor = "";
            var coords = e.target.getCoords();
            document.getElementById("inputCoordinatesDisplay").innerText = "Souřadnice: " + coords.toWGS84(2).reverse().join(" ");
            document.getElementById("inputCoordinates").value = coords.toWGS84(2).reverse().join(", ").replace('"N', "").replace('"E', "");

        }

        var signals = m.getSignals();
        signals.addListener(window, "marker-drag-stop", stop);
        signals.addListener(window, "marker-drag-start", start);
    </script>
</body>

</html>