<?php include 'auth.php' ?>
<?php include 'base.php' ?>

<?php if(isset($_SESSION['username'])) startblock('extrastyle') ?>
    <script src="static/js/selections.js"></script>
    <title> CI - Selections </title>
    <style>
        html {
            /* background-color: rgba(255, 210, 210, 0.692); */
            background-color: rgba(182, 225, 253, 0.3);
        }
        body {
            /* background-color: rgba(122, 47, 47, 0); */
            background-color: rgba(17, 58, 97, 0);
            padding: 10px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#selections_navbar').addClass("active");
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });
    </script>
<?php if(isset($_SESSION['username'])) endblock() ?>

<?php if(isset($_SESSION['username'])) startblock('body') ?>
    <div class="ui form">
        <div class="three fields">
            <div class="field">
                <div style="padding: 25px;" class="ui segment container">
                    <h3 style="text-align: center;">Manage Sources</h3>
                </div>
            </div>
            <div class="field">
                <div style="padding: 25px;" class="ui segment container">
                    <h3 style="text-align: center;">Manage ADC</h3>
                </div>
            </div>
            <div class="field">
                <div style="padding: 25px;" class="ui segment container">
                    <h3 style="text-align: center;">Manage Triggers</h3>
                </div>
            </div>
        </div>
        <div style="margin-top: -10px;" class="three fields">
            <div class="field">
                <div style="padding: 25px; height: 82%;" class="ui segment container">
                    <div style="height: 90%; overflow-x: scroll;">
                        <table class="ui celled stackable table">
                            <thead><tr>
                                <th style="background-color: rgba(182, 225, 253, 0.3);"></th>
                                <th style="text-align: center; background-color: rgba(182, 225, 253, 0.3);" class="eleven wide">Name</th>
                            </tr></thead>
                            <tbody>
                                <?php $conn = mysqli_connect("localhost", "root", "", "charles_db"); ?>
                                <?php $query = "SELECT * FROM charles_table_source"; ?>
                                <?php $sources = mysqli_query($conn, $query); ?>
                                <?php while($row = mysqli_fetch_assoc($sources)) { ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div class="ui dropdown item mini basic button">
                                                Options <i class="dropdown icon"></i>
                                                <div class="menu">
                                                    <?php $sid = $row['id']; ?>
                                                    <a style="color: black;" class="item" onclick="update('<?php echo $row['value']?>', 'source', '<?php echo $sid ?>')">Update</a>
                                                    <a style="color: black;" class="item" onclick="del('<?php echo $row['value']?>', 'source', '<?php echo $sid ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td title="Name" style="text-align: center; vertical-align: middle;"><?php echo $row['value'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button class="ui green button" onclick="create('source')" style="position: absolute; bottom: 20px;">
                        <i class="plus icon"></i> CREATE
                    </button>
                </div>
            </div>
            <div class="field">
                <div style="padding: 25px; height: 82%;" class="ui segment container">
                    <div style="height: 90%; overflow-x: scroll;">
                        <table class="ui celled stackable table">
                            <thead><tr>
                                <th style="background-color: rgba(182, 225, 253, 0.3);"></th>
                                <th style="text-align: center; background-color: rgba(182, 225, 253, 0.3);" class="eleven wide">Name</th>
                            </tr></thead>
                            <tbody>
                                <?php $conn = mysqli_connect("localhost", "root", "", "charles_db"); ?>
                                <?php $query = "SELECT * FROM charles_table_adc"; ?>
                                <?php $adcs = mysqli_query($conn, $query); ?>
                                <?php while($row = mysqli_fetch_assoc($adcs)) { ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div class="ui dropdown item mini basic button">
                                                Options <i class="dropdown icon"></i>
                                                <div class="menu">
                                                    <?php $sid = $row['id']; ?>
                                                    <a style="color: black;" class="item" onclick="update('<?php echo $row['value']?>', 'adc', '<?php echo $sid ?>')">Update</a>
                                                    <a style="color: black;" class="item" onclick="del('<?php echo $row['value']?>', 'adc', '<?php echo $sid ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td title="Name" style="text-align: center; vertical-align: middle;"><?php echo $row['value'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button class="ui green button" onclick="create('adc')" style="position: absolute; bottom: 20px;">
                        <i class="plus icon"></i> CREATE
                    </button>
                </div>
            </div>
            <div class="field">
                <div style="padding: 25px; height: 82%;" class="ui segment container">
                    <div style="height: 90%; overflow-x: scroll;">
                        <table class="ui celled stackable table">
                            <thead><tr>
                                <th style="background-color: rgba(182, 225, 253, 0.3);"></th>
                                <th style="text-align: center; background-color: rgba(182, 225, 253, 0.3);" class="eleven wide">Name</th>
                            </tr></thead>
                            <tbody>
                                <?php $conn = mysqli_connect("localhost", "root", "", "charles_db"); ?>
                                <?php $query = "SELECT * FROM charles_table_trig"; ?>
                                <?php $triggers = mysqli_query($conn, $query); ?>
                                <?php while($row = mysqli_fetch_assoc($triggers)) { ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <div class="ui dropdown item mini basic button">
                                                Options <i class="dropdown icon"></i>
                                                <div class="menu">
                                                    <?php $sid = $row['id']; ?>
                                                    <a style="color: black;" class="item" onclick="update('<?php echo $row['name']?>', 'trig', '<?php echo $sid ?>')">Update</a>
                                                    <a style="color: black;" class="item" onclick="del('<?php echo $row['name']?>', 'trig', '<?php echo $sid ?>')">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td title="Name" style="text-align: center; vertical-align: middle;"><?php echo $row['name'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <button class="ui green button" onclick="create('trig')" style="position: absolute; bottom: 20px;">
                        <i class="plus icon"></i> CREATE
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="ui mini modal" id="modal_create">
        <i class="close icon"></i>
        <div class="header" id="header_create" style="text-align: center;"></div>
        <div class="content">
            <form class="ui form" id="form_create" method="post" action="selections_create.php">
                <input type="hidden" name="sel_type" id="type_create" value="source">
                <div style="width: calc(100% - 65px);" class="ui labeled input">
                    <div class="ui grey label">Name : </div>
                    <input type="text" name="sel_name" id="name_create" placeholder="e.g: Threat Hunting" required>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button" onclick="$('.ui.modal').modal('hide')">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            <button type="submit" form="form_create" id="create_submit" class="ui blue button">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_update">
        <div class="header" id="header_update" style="text-align: center;"></div>
        <div class="content">
            <form class="ui form" method="post" id="form_update" action="selections_update.php">
                <input type="hidden" name="sel_id" id="id_update" value="">
                <input type="hidden" name="sel_type" id="type_update" value="">
                <div class="ui labeled input">
                    <div class="ui grey label">Name : </div>
                    <input type="text" name="sel_name" id="name_update" value="" required>
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button" onclick="$('.ui.modal').modal('hide')">
                <i class="thumbs down outline icon"></i> Cancel
            </a>
            <button type="submit" form="form_update" id="update_submit" class="ui blue button">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_delete">
        <div class="header" style="text-align: center;" id="header_delete"></div>
        <div class="content">
            <form class="ui form" method="post" id="form_delete" action="selections_delete.php">
                <input type="hidden" name="sel_id" id="id_delete" value="">
                <input type="hidden" name="sel_type" id="type_delete" value="">
                <div style="width: calc(100% - 95px);" class="ui labeled input">
                    <div class="ui grey label">Password : </div>
                    <input type="password" name="pw" id="pw">
                </div>
            </form>
        </div>
        <div class="actions">
            <a class="ui red button" onclick="$('.ui.modal').modal('hide')">
                <i class="thumbs down outline icon"></i> Cancel
            </a>
            <button class="ui blue button" id="submit_del" onclick="check_pw()">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
<?php if(isset($_SESSION['username'])) endblock() ?>

<?php if(isset($_SESSION['username'])) startblock('extrascripts') ?>
    <script>
        var del_inputs = document.getElementById("pw");
            del_inputs.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('submit_del').click();
                }
        });
        var update_inputs = document.getElementById("name_update");
            update_inputs.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('update_submit').click();
                }
        });
        var create_inputs = document.getElementById("name_create");
            create_inputs.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('create_submit').click();
                }
        });

        function create(type) {
            document.getElementById('type_create').setAttribute('value', type);
            if(type == 'source') {
                document.getElementById('header_create').innerHTML = 'Create Source';
                document.getElementById('name_create').setAttribute('placeholder', 'e.g: Threat Hunting')
            } else if(type == 'adc') {
                document.getElementById('header_create').innerHTML = 'Create ADC';
                document.getElementById('name_create').setAttribute('placeholder', 'e.g: Supported')
            } else if(type == 'trig') {
                document.getElementById('header_create').innerHTML = 'Create Trigger';
                document.getElementById('name_create').setAttribute('placeholder', 'e.g: Download')
            }
            $('#modal_create').modal({autofocus: true}).modal('show');
        }

        function update(name, type, id) {
            document.getElementById('id_update').setAttribute('value', id);
            document.getElementById('type_update').setAttribute('value', type);
            document.getElementById('name_update').setAttribute('value', name);
            if(type == 'source') document.getElementById('header_update').innerHTML = 'UPDATE SOURCE';
            else if(type == 'adc') document.getElementById('header_update').innerHTML = 'UPDATE ADC';
            else if(type == 'trig') document.getElementById('header_update').innerHTML = 'UPDATE TRIGGER';
            $('#modal_update').modal({autofocus: true}).modal('show');
        }

        function del(name, type, id) {
            document.getElementById('id_delete').setAttribute('value', id);
            document.getElementById('type_delete').setAttribute('value', type);
            if(type == 'source') document.getElementById('header_delete').innerHTML = 'DELETE SOURCE : ' + name;
            else if(type == 'adc') document.getElementById('header_delete').innerHTML = 'DELETE ADC : ' + name;
            else if(type == 'trig') document.getElementById('header_delete').innerHTML = 'DELETE TRIGGER : ' + name;
            $('#modal_delete').modal({autofocus: true}).modal('show');
        }

        function check_pw() {
            <?php
                $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
                $user = mysqli_query($conn, $user);
                $user = mysqli_fetch_assoc($user);
                $password = $user['password'];
            ?>
            var x = document.getElementById("pw").value;
            if(x != "<?php echo $password ?>") {
                $.uiAlert({
                    textHead: "Wrong Password!",
                    text: 'Enter correct password to proceed',
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
            } else {
                document.getElementById('form_delete').submit();
            }
        }
    </script>
<?php if(isset($_SESSION['username'])) endblock() ?>