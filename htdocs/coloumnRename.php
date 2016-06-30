<html>
    <head>

        <?php
        $db_name = '';
        setcookie('db_name', $db_name, time() + (86400 * 7));
        ?>
    </head>
    <body>
        <p>Databases</p>
        <select name="sele" id="sele">
            <?php
            $con2 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
            $z = "select datname from pg_database where datistemplate is false";
            $zr = $r = pg_query($con2, $z);
            $dbA = array();
            $arr_res1 = pg_fetch_all($r);
            $arr_len1 = count($arr_res1);
//echo $arr_res1;
//List of databases
            for ($x = 0; $x < $arr_len1; $x++) {
                echo '<option value=$arr_res1[$x]["datname"]>';
                echo $arr_res1[$x]["datname"];
                echo '</option>';
            }
//$_SESSION["dbname"] = $arr_res1[0]['datname'];
// $db_name = $_SESSION["dbname"];
            ?>
        </select>

        <p>Tables</p>
        <select name="sel" id="sels">

        </select>
        Rename with : <input type="text" NAME="rename_table" id="rename_table" class="text" maxlength="30" />
        <input type="submit" value="Save" name="Save_tables" id = "Save_tables">

        <p>Attributes</p>
        <select name="sel" id="sels1">

        </select>
        Rename with : <input type="text" NAME="rename_attribute" id="rename_attribute" class="text" maxlength="30" />
        <input type="submit" value="Save" name="Save_columns" id="Save_columns">
    </body>
    <script type = "text/javascript" src="script.js"></script>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var o = "";
        var callChange = document.getElementById('sele');
        callChange.addEventListener('change',
                function valueselect()
                {
                    var parentSelect = document.getElementById('sels');
                    while (parentSelect.hasChildNodes()) {
                        parentSelect.removeChild(parentSelect.lastChild);
                    }
                    var response = null;
                    var s = document.getElementById("sele");
                    o = s.options[s.selectedIndex].textContent;
                    console.log(o);
                    $.ajax({
                        url: "getSelectedQuery.php",
                        async: false,
                        data: {
                            data: o
                        },
                        error: function () {
                            alert("error")
                        },
                        success: function (data) {
                            // console.log( typeof data);
                            response = data;
                        },
                        type: 'GET'
                    });
                    response = response.split(',');
					


                    for (var i = 0; i < response.length; i++) {
                        var optionSelect = document.createElement('option');
                        optionSelect.innerHTML = response[i];
                        parentSelect.appendChild(optionSelect);
                    }
                });
        var o1 = "";
        var callChange1 = document.getElementById('sels');
        callChange1.addEventListener('change',
                function valueselect2()
                {
                    var parentSelect = document.getElementById('sels1');
                    while (parentSelect.hasChildNodes()) {
                        parentSelect.removeChild(parentSelect.lastChild);
                    }
                    var response = null;
                    var s2 = document.getElementById("sels");
                    o1 = s2.options[s2.selectedIndex].textContent;
                    console.log(o1);
                    $.ajax({
                        url: "getColumnNames.php",
                        async: false,
                        data: {
                            data: o,
                            data1: o1
                        },
                        error: function () {
                            alert("error")
                        },
                        success: function (data1) {
                            // console.log( typeof data);
                            response = data1;
                        },
                        type: 'GET'
                    });
                    response = response.split(',');


                    for (var i = 0; i < response.length; i++) {
                        var optionSelect = document.createElement('option');
                        optionSelect.innerHTML = response[i];
                        parentSelect.appendChild(optionSelect);
                    }


                });
        var o3 = "";
        var callClick = document.getElementById('Save_tables');
        callClick.addEventListener('click',
                function rename_table1()
                {
                    var response = null;
                    var s = document.getElementById("sele");
                    o = s.options[s.selectedIndex].textContent;
                    console.log(o);
                    var s2 = document.getElementById("sels");
                    o1 = s2.options[s2.selectedIndex].textContent;
                    console.log(o1);
                    var s3 = document.getElementById("rename_table");
                    var o22 = s3.value;
                    console.log(o22);
                    $.ajax({
                        url: "Rename_tab.php",
                        async: false,
                        data: {
                            Save_tables: "save",
                            data: o,
                            data1: o1,
                            data2: o22
                        },
                        error: function () {
                            alert("error")
                        },
                        success: function (data) {
                            // console.log( typeof data);
                            response = data;
                            document.getElementById('rename_table').value = "";

                        },
                        type: 'POST'
                    });

                });
        var o4 = "";
        var callClick1 = document.getElementById('Save_columns');
        callClick1.addEventListener('click',
                function rename_column1()
                {
                    var response = null;
                    var s = document.getElementById("sele");
                    o = s.options[s.selectedIndex].textContent;
                    console.log(o);
                    var s2 = document.getElementById("sels");
                    o1 = s2.options[s2.selectedIndex].textContent;
                    console.log(o1);
                    var s3 = document.getElementById("rename_attribute");
                    var o22 = s3.value;
                    var s4 = document.getElementById("sels1");
                    o4 = s4.options[s4.selectedIndex].textContent;
                    console.log(o22);
                    $.ajax({
                        url: "Rename_att.php",
                        async: false,
                        data: {
                            Save_attributes: "save",
                            data: o,
                            data1: o1,
                            data2: o22,
                            data3: o4
                        },
                        error: function () {
                            alert("error")
                        },
                        success: function (data) {
                            // console.log( typeof data);
                            response = data;
                            document.getElementById('rename_attribute').value = "";

                        },
                        type: 'POST'
                    });

                });
    });
</script>